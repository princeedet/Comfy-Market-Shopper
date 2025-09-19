<?php
include 'config.php';

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM orders WHERE id = $order_id");
    $order = $result->fetch_assoc();
}

// If modal mode, just return partial HTML
if (isset($_GET['modal'])) {
    if ($order): ?>
        <div class="bg-white rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Order #<?= $order['id']; ?></h2>
            <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer']); ?></p>
            <p><strong>Product:</strong> <?= htmlspecialchars($order['product']); ?></p>
            <p><strong>Quantity:</strong> <?= htmlspecialchars($order['quantity']); ?></p>
            <p><strong>Deadline:</strong> <?= htmlspecialchars($order['deadline']); ?></p>
            <p><strong>Amount:</strong> ₦<?= number_format($order['value']); ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($order['status']); ?></p>
            <p><strong>Date:</strong> <?= $order['created_at']; ?></p>
        </div>
    <?php else: ?>
        <p class="text-red-600">Order not found.</p>
    <?php endif;
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>…</head>
<body>
   <!-- full page version -->
</body>
</html>
