<?php
require '../properties/connection.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $details = trim($_POST['details']);
    $status = $_POST['status'];
    $price = floatval($_POST['price']);
    $pin_x = floatval($_POST['pin_x']);
    $pin_y = floatval($_POST['pin_y']);

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["success" => false, "message" => "Image upload failed."]);
        exit;
    }

    $targetDir = "images/";
    $filename = basename($_FILES["image"]["name"]);
    $uniqueName = uniqid() . "_" . $filename;
    $targetFile = $targetDir . $uniqueName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed)) {
        echo json_encode(["success" => false, "message" => "Invalid file type."]);
        exit;
    }

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        echo json_encode(["success" => false, "message" => "Failed to move uploaded image."]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO facility (name, pin_x, pin_y, details, status, price, image, date_added) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");

    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("sddssds", $name, $pin_x, $pin_y, $details, $status, $price, $targetFile);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
