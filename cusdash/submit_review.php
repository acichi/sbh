<?php
require '../properties/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'] ?? '';
    $facility_name = $_POST['facility_name'] ?? '';
    $feedback = $_POST['feedback'] ?? '';
    $rate = $_POST['rate'] ?? '';

    $sql = "INSERT INTO feedback (fullname, facility_name, feedback, rate) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $fullname, $facility_name, $feedback, $rate);
    
    $response = ['success' => false, 'message' => ''];
    
    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = $conn->error;
    }
    
    $stmt->close();
    $conn->close();
    
    header('Content-Type: application/json');
    echo json_encode($response);
}