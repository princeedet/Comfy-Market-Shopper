<?php
include 'config.php';

// Helper to fetch product name
function getProductName($conn, $product_id) {
    if (!$product_id) return 'Unknown';
    $stmt = $conn->prepare("SELECT name FROM products WHERE id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['name'] ?? 'Unknown';
}

// Determine tab, search, and status
$tab = $_GET['tab'] ?? 'orders';
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

$sql = "SELECT * FROM orders WHERE 1";
$params = [];
$types = '';

// Tab filter
if ($tab === 'meat') {
    $sql .= " AND product_id IN (SELECT id FROM products WHERE category='Meat')";
}

// Search filter
if ($search) {
    $sql .= " AND (customer LIKE ? OR id LIKE ?)";
    $searchTerm = "%$search%";
    $params[] = &$searchTerm;
    $params[] = &$searchTerm;
    $types .= "ss";
}

// Status filter
if ($status) {
    $sql .= " AND status=?";
    $params[] = &$status;
    $types .= "s";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Output table rows
while ($row = $result->fetch_assoc()) {
    $productName = getProductName($conn, $row['product_id']);
    $customer = $row['customer'] ?? 'N/A';
    $quantity = $row['quantity'] ?? 0;
    $total = $row['value'] ?? 0;
    $status = $row['status'] ?? 'Pending';

    $statusColor = match($status) {
        'Completed' => 'bg-green-600',
        'Processing' => 'bg-yellow-500',
        'Pending' => 'bg-red-600',
        default => 'bg-gray-500'
    };

    echo "<tr class='border-b'>
        <td>ORD-" . str_pad($row['id'], 3, '0', STR_PAD_LEFT) . "</td>
        <td>{$productName}</td>
        <td>{$customer}</td>
        <td>{$quantity}</td>
        <td>₦" . number_format($total) . "</td>
        <td><span class='px-2 py-1 text-white rounded {$statusColor}'>{$status}</span></td>
        <td>
            <button onclick='openOrderModal({$row['id']})' class='text-blue-600 hover:underline text-sm'>View</button> | 
            <button onclick='deleteOrder({$row['id']})' class='text-red-600 hover:underline text-sm'>Delete</button>
        </td>
    </tr>";
}
?>
