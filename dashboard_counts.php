<?php
include 'db.php';
header('Content-Type: application/json');

$counts = [
    'totalUsers' => (int)$conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'],
    'activeUsers' => (int)$conn->query("SELECT COUNT(*) AS c FROM users WHERE status='Active'")->fetch_assoc()['c'],
    'newThisMonth' => (int)$conn->query("SELECT COUNT(*) AS c FROM users WHERE MONTH(created_at)=MONTH(CURRENT_DATE()) AND YEAR(created_at)=YEAR(CURRENT_DATE())")->fetch_assoc()['c'],
    'totalOrders' => (int)$conn->query("SELECT COUNT(*) AS c FROM orders")->fetch_assoc()['c']
];

echo json_encode($counts);
?>
