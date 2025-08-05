<?php
require "../properties/connection.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$uploadDir = "../uploads/gallery/";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

if (empty($_POST['description'])) {
    http_response_code(400);
    echo "Description is required.";
    exit;
}
$description = trim($_POST['description']);

if (empty($_FILES['files']['name'][0])) {
    http_response_code(400);
    echo "No files selected.";
    exit;
}

$successCount = 0;
$errorCount = 0;

foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
    $fileName = time() . "_" . basename($_FILES['files']['name'][$key]);
    $targetPath = $uploadDir . $fileName;

    $allowedExt = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) {
        $errorCount++;
        continue;
    }

    if (move_uploaded_file($tmpName, $targetPath)) {
        $location = "uploads/gallery/" . $fileName;

        $stmt = $conn->prepare("INSERT INTO gallery (description, location, date_added) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $description, $location);

        if ($stmt->execute()) $successCount++;
        else $errorCount++;

        $stmt->close();
    } else {
        $errorCount++;
    }
}

if ($successCount > 0) {
    echo "$successCount file(s) uploaded successfully. $errorCount failed.";
} else {
    http_response_code(500);
    echo "Upload failed.";
}
?>
