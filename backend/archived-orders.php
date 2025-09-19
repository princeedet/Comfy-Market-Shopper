<?php
include 'config.php';
$result = $conn->query("SELECT * FROM orders WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC");
?>

<h2>Archived Orders</h2>
<?php while ($row = $result->fetch_assoc()): ?>
  <div class="order-card">
    <p><strong>Order ID:</strong> <?php echo $row['id']; ?></p>
    <p><strong>Customer:</strong> <?php echo $row['customer_name']; ?></p>
    <p><strong>Deleted At:</strong> <?php echo $row['deleted_at']; ?></p>
    <a href="restore-order.php?id=<?php echo $row['id']; ?>" class="btn bg-blue-600 hover:bg-blue-700">Restore</a>
  </div>
<?php endwhile; ?>
