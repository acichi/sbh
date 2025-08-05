<?php
require '../properties/connection.php';
header('Content-Type: application/json');

$sql = "SELECT id, name, pin_x, pin_y, details, status, price, image FROM facility";
$result = $conn->query($sql);

$facilities = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Default status from facility table
        $facility_status = strtolower(trim($row['status']));

        // If status is unavailable, check receipt table for future check-in
        if ($facility_status === 'unavailable') {
            $facility_name = $conn->real_escape_string($row['name']);
            $now = date('Y-m-d H:i:s');
            $receipt_sql = "SELECT date_checkin FROM receipt WHERE facility_name = '$facility_name' AND date_checkin > '$now' ORDER BY date_checkin ASC LIMIT 1";
            $receipt_result = $conn->query($receipt_sql);

            if ($receipt_result && $receipt_result->num_rows > 0) {
                // There is a future reservation, set status to 'blue'
                $row['status'] = 'blue';
            }
        }

        $facilities[] = $row;
    }
}

echo json_encode($facilities);
$conn->close();
