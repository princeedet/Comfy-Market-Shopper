<?php
include "config.php";

if (isset($_GET['view'])) {
    $id = intval($_GET['view']);
    $result = $conn->query("SELECT * FROM orders WHERE id = $id");
    $order = $result->fetch_assoc();

    if ($order) {
        echo "<p><b>Order ID:</b> {$order['id']}</p>";
        echo "<p><b>Customer:</b> {$order['customer_name']} ({$order['customer_email']})</p>";
        echo "<p><b>Phone:</b> {$order['customer_phone']}</p>";
        echo "<p><b>Address:</b> {$order['delivery_address']}</p>";
        echo "<p><b>Status:</b> {$order['status']}</p>";
        echo "<p><b>Quantity:</b> {$order['quantity']}</p>";
        echo "<p><b>Total Price:</b> ₦" . number_format($order['total_price'], 2) . "</p>";
    } else {
        echo "Order not found.";
    }
    exit;
}

// Normal search
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$dateFrom = $_GET['dateFrom'] ?? '';
$dateTo = $_GET['dateTo'] ?? '';

$query = "SELECT * FROM orders WHERE 1=1";

if ($search) {
    $search = $conn->real_escape_string($search);
    $query .= " AND (customer_name LIKE '%$search%' OR customer_email LIKE '%$search%')";
}

if ($status) {
    $status = $conn->real_escape_string($status);
    $query .= " AND status = '$status'";
}

if ($dateFrom && $dateTo) {
    $query .= " AND created_at BETWEEN '$dateFrom' AND '$dateTo'";
}

$query .= " ORDER BY created_at DESC";
$result = $conn->query($query);

echo "<table class='w-full text-sm'>
<thead class='bg-gray-100'>
<tr>
  <th class='px-4 py-2'>ID</th>
  <th class='px-4 py-2'>Customer</th>
  <th class='px-4 py-2'>Status</th>
  <th class='px-4 py-2'>Quantity</th>
  <th class='px-4 py-2'>Total</th>
  <th class='px-4 py-2'>Actions</th>
</tr>
</thead><tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr class='border-b'>
          <td class='px-4 py-2'>{$row['id']}</td>
          <td class='px-4 py-2'>{$row['customer_name']}</td>
          <td class='px-4 py-2'>{$row['status']}</td>
          <td class='px-4 py-2'>{$row['quantity']}</td>
          <td class='px-4 py-2'>₦" . number_format($row['total_price'], 2) . "</td>
          <td class='px-4 py-2'>
            <button onclick='openOrderModal({$row['id']})' class='px-3 py-1 bg-blue-600 text-white rounded text-xs'>View</button>
            <button onclick='deleteOrder({$row['id']})' class='px-3 py-1 bg-red-600 text-white rounded text-xs'>Delete</button>
          </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center py-4'>No orders found.</td></tr>";
}
echo "</tbody></table>";
