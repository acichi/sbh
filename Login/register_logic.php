<?php
session_start();
require '../properties/connection.php';
require 'send_otp.php'; // Ensure path is correct

function sanitize($data) {
    return htmlspecialchars(trim($data));
}

$name     = sanitize($_POST['name'] ?? '');
$email    = sanitize($_POST['email'] ?? '');
$username = sanitize($_POST['user'] ?? '');
$password = $_POST['password'] ?? ''; // hash later
$number   = sanitize($_POST['mobile'] ?? '');
$address  = sanitize($_POST['address'] ?? '');
$gender   = sanitize($_POST['gender'] ?? '');

// Format mobile number
$formatted_number = preg_replace('/^0/', '+63', $number);

// Generate and store OTP
$otp = rand(100000, 999999);

$_SESSION['registration'] = [
    'name'     => $name,
    'email'    => $email,
    'username' => $username,
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'number'   => $formatted_number,
    'address'  => $address,
    'gender'   => $gender
];

$_SESSION['otp'] = $otp;

// Send OTP
$message = "This is from Shelton Resort here is your OTP: $otp, Please don't give this to anyone else your data is our concern.";
$sms_result = sendSMS([$formatted_number], $message);

// Check SMS response
if ($sms_result['status_code'] == 200 || $sms_result['status_code'] == 201) {
    $response = json_decode($sms_result['response'], true);

    if (isset($response['data']['success']) && $response['data']['success']) {
        header("Location: otp.php"); // ✅ Redirect to form to enter OTP
        exit;
    } else {
        echo "❌ OTP sending failed. Server responded but not successful.<br>";
        echo "Response: " . htmlspecialchars($sms_result['response']);
    }
} else {
    echo "❌ Failed to send OTP.<br>";
    echo "HTTP Code: {$sms_result['status_code']}<br>";
    echo "Error: {$sms_result['error']}";
}
