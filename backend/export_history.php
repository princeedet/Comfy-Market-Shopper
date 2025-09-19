<?php
include 'config.php';

// Set headers so it downloads as CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="payment_history.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Add CSV header row
fputcsv($output, ['ID', 'Order ID', 'Customer', 'Product', 'Amount', 'Method', 'Transaction ID', 'Status', 'Date']);

// Fetch payment history
$query = $conn->query("SELECT * FROM payments ORDER BY created_at DESC");

while ($row = $query->fetch_assoc()) {
    fputcsv($output, [
        $row['id'],
        $row['order_id'],
        $row['customer'],
        $row['product'],
        $row['amount'],
        $row['method'],
        $row['txn_id'],
        $row['status'],
        $row['created_at']
    ]);
}

fclose($output);
exit;
?>
