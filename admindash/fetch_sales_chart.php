<?php
require '../properties/connection.php';

$range = $_GET['range'] ?? 'monthly';

$labels = [];
$counts = [];
$total = 0;

if ($range === 'weekly') {
    $query = $conn->query("
        SELECT DATE_FORMAT(date_booked, '%a') as label, SUM(amount) as total
        FROM reservations
        WHERE date_booked >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY DATE(date_booked)
        ORDER BY DATE(date_booked)
    ");
} elseif ($range === 'yearly') {
    $query = $conn->query("
        SELECT YEAR(date_booked) as label, SUM(amount) as total
        FROM reservations
        GROUP BY YEAR(date_booked)
        ORDER BY YEAR(date_booked)
    ");
} else {
    $query = $conn->query("
        SELECT DATE_FORMAT(date_booked, '%b') as label, SUM(amount) as total
        FROM reservations
        GROUP BY MONTH(date_booked)
        ORDER BY MONTH(date_booked)
    ");
}

while ($row = $query->fetch_assoc()) {
    $labels[] = $row['label'];
    $counts[] = (float) $row['total'];
    $total += $row['total'];
}

echo json_encode([
    'labels' => $labels,
    'counts' => $counts,
    'total'  => number_format($total, 2)
]);
?>
