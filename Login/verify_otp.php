<?php
session_start();
require '../properties/connection.php';
require '../properties/sweetalert.php'; // ✅ Include SweetAlert function

// Check if OTP and registration data exist
if (!isset($_SESSION['otp'], $_SESSION['registration'])) {
    showSweetAlert("❌ Session expired or invalid. Please register again.", "register.php", "error");
}

// Check OTP
$input_otp = $_POST['otp'] ?? '';
if ($input_otp != $_SESSION['otp']) {
    showSweetAlert("❌ Invalid OTP. Please try again.", "otp.php", "error");
}

// Extract registration data
$data     = $_SESSION['registration'];
$name     = $data['name'];
$email    = $data['email'];
$username = $data['username'];
$password = $data['password'];
$number   = $data['number'];
$address  = $data['address'];
$gender   = $data['gender'];
$role     = 'customer';
$now      = date('Y-m-d H:i:s');

// Check if username/email already exists
$check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
$check->bind_param("ss", $email, $username);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $check->close();
    showSweetAlert("❌ Username or email already exists.", "register.php", "error");
}

// Insert new user
$stmt = $conn->prepare("INSERT INTO users (fullname, email, number, username, password, gender, role, address, date_added, date_updated)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $name, $email, $number, $username, $password, $gender, $role, $address, $now, $now);

if ($stmt->execute()) {
    unset($_SESSION['otp'], $_SESSION['registration']);
    showSweetAlert("✅ Registration successful! Please log in.", "login.php", "success");
} else {
    showSweetAlert("❌ Something went wrong during registration.", "register.php", "error");
}

$stmt->close();
$conn->close();
