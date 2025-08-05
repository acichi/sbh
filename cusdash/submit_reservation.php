<?php
session_start();
require '../properties/connection.php'; // Adjust if needed

// Make sure user is logged in and has a fullname
if (!isset($_SESSION['fullname'])) {
    http_response_code(403);
    echo "Not authorized.";
    exit;
}

$reservee = $_SESSION['fullname'];
$facility_name = $_POST['facility_name'] ?? '';
$status = $_POST['status'] ?? 'Pending';
$date_booked = $_POST['date_booked'] ?? date('Y-m-d H:i:s');
$date_start = $_POST['date_start'] ?? '';
$date_end = $_POST['date_end'] ?? '';
$payment_type = $_POST['payment_type'] ?? '';
$amount = $_POST['amount'] ?? 0;

// Basic validation
if (empty($facility_name) || empty($date_start) || empty($date_end) || empty($payment_type)) {
    http_response_code(400);
    echo "Missing required fields.";
    exit;
}

$stmt = $conn->prepare("INSERT INTO reservations (reservee, facility_name, status, date_booked, date_start, date_end, payment_type, amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssd", $reservee, $facility_name, $status, $date_booked, $date_start, $date_end, $payment_type, $amount);

if ($stmt->execute()) {
    echo "Reservation successful!";
} else {
    http_response_code(500);
    echo "Database error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
