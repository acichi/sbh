<?php
session_start();
require '../properties/connection.php';

// Ensure user is admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if (!$id || !in_array($action, ['hide', 'unhide'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$is_hidden = ($action === 'hide') ? 1 : 0;

$stmt = $conn->prepare("UPDATE feedback SET is_hidden = ? WHERE id = ?");
$stmt->bind_param('ii', $is_hidden, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Feedback updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update feedback']);
}

$stmt->close();
$conn->close();
?>
