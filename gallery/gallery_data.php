<?php
require "../properties/connection.php";

// Set upload directory
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
if (empty($_FILES['files']['name'][0])) {
    http_response_code(400);
    echo "No files selected.";
    exit;
}

$responses = [];
foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
    $fileName = basename($_FILES['files']['name'][$key]);
    $targetPath = $uploadDir . $fileName;

    // Check for allowed file types (basic)
    $allowedTypes = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedTypes)) {
        $responses[] = "$fileName skipped (invalid type)";
        continue;
    }

    // Move the file
    if (move_uploaded_file($tmpName, $targetPath)) {
        // Insert into database
        $location = "uploads/gallery/" . $fileName; // relative path for DB
        $stmt = $conn->prepare("INSERT INTO gallery (description, location, date_added) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $description, $location);
        $stmt->execute();
        $stmt->close();

        $responses[] = "$fileName uploaded successfully";
    } else {
        $responses[] = "Error uploading $fileName";
    }
}

echo implode("\n", $responses);
?>
