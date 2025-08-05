<?php
require '../properties/connection.php';
header('Content-Type: application/json');

$sql = "SELECT id, name, pin_x, pin_y, details, status, price, image FROM facility";
$result = $conn->query($sql);

$facilities = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $facilities[] = $row;
    }
}

echo json_encode($facilities);
$conn->close();
