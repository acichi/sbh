<?php
require "../properties/connection.php";

// Set upload folder
$uploadDir = "../uploads/gallery/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Validate description
if (!isset($_POST['description']) || empty(trim($_POST['description']))) {
    http_response_code(400);
    echo "Description is required.";
    exit;
}
$description = trim($_POST['description']);

// Validate files
if (!isset($_FILES['files']) || empty($_FILES['files']['name'][0])) {
    http_response_code(400);
    echo "No files selected.";
    exit;
}

$successCount = 0;
$errorCount = 0;

foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
    $fileName = basename($_FILES['files']['name'][$key]);
    $targetPath = $uploadDir . $fileName;

    // Validate file type
    $allowedExt = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) {
        $errorCount++;
        continue;
    }

    // Move file
    if (move_uploaded_file($tmpName, $targetPath)) {
        // Save path in DB (relative to index)
        $location = "uploads/gallery/" . $fileName;

        $stmt = $conn->prepare("INSERT INTO gallery (description, location, date_added) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $description, $location);

        if ($stmt->execute()) {
            $successCount++;
        } else {
            $errorCount++;
        }

        $stmt->close();
    } else {
        $errorCount++;
    }
}

// Return response
if ($successCount > 0) {
    echo "$successCount file(s) uploaded successfully. $errorCount failed.";
} else {
    http_response_code(500);
    echo "Upload failed.";
}
?>
