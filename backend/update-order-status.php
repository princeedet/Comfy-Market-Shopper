<?php
include 'config.php';

if (isset($_POST['order_id'], $_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['status']);

    $update = $conn->query("UPDATE orders SET status='$status' WHERE id=$order_id");

    if ($update) {
        echo "Order status updated successfully!";
    } else {
        echo "Failed to update order status.";
    }
} else {
    echo "Invalid request.";
}
?>
