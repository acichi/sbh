<?php
// paymongo_success.php
require '../properties/connection.php';

$transaction_id = $_GET['checkout_session_id'] ?? uniqid();
$reservee = $_GET['reservee'] ?? 'Unknown';
$facility_name = $_GET['facility_name'] ?? 'N/A';
$amount_paid = $_GET['amount'] ?? 0;
$payment_type = $_GET['payment_type'] ?? 'GCash';
$date_booked = date("Y-m-d H:i:s");
$date_checkin = $_GET['date_checkin'] ?? null;
$date_checkout = $_GET['date_checkout'] ?? null;

// Insert to receipt table
$stmt = $conn->prepare("INSERT INTO receipt 
  (transaction_id, reservee, facility_name, amount_paid, balance, date_checkin, date_checkout, date_booked, payment_type) 
  VALUES (?, ?, ?, ?, 0, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("sssisssss", $transaction_id, $reservee, $facility_name, $amount_paid, $date_checkin, $date_checkout, $date_booked, $payment_type);
if (!$stmt->execute()) {
    die("Execute failed (receipt): " . $stmt->error);
}
$stmt->close();

// Update facility status
$updateStmt = $conn->prepare("UPDATE facility SET status = 'unavailable' WHERE name = ?");
if (!$updateStmt) {
    die("Prepare failed (facility): " . $conn->error);
}
$updateStmt->bind_param("s", $facility_name);
if (!$updateStmt->execute()) {
    die("Execute failed (facility): " . $updateStmt->error);
}
$updateStmt->close();

// Confirmation
echo "<script>
  alert('Payment successful! Reservation saved.');
  window.location.href = 'your-reservation-confirmation-page.php';
</script>";
