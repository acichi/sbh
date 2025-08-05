<?php
require '../properties/connection.php';

$range = $_GET['range'] ?? 'monthly';

$labels = [];
$counts = [];

if ($range === 'weekly') {
    $query = $conn->query("
        SELECT DATE_FORMAT(timestamp, '%a') as label, COUNT(*) as total
        FROM feedback
        WHERE timestamp >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY DATE(timestamp)
        ORDER BY DATE(timestamp)
    ");
} elseif ($range === 'yearly') {
    $query = $conn->query("
        SELECT YEAR(timestamp) as label, COUNT(*) as total
        FROM feedback
        GROUP BY YEAR(timestamp)
        ORDER BY YEAR(timestamp)
    ");
} else {
    $query = $conn->query("
        SELECT DATE_FORMAT(timestamp, '%b') as label, COUNT(*) as total
        FROM feedback
        GROUP BY MONTH(timestamp)
        ORDER BY MONTH(timestamp)
    ");
}

while ($row = $query->fetch_assoc()) {
    $labels[] = $row['label'];
    $counts[] = (int) $row['total'];
}

echo json_encode([
    'labels' => $labels,
    'counts' => $counts
]);
?>
