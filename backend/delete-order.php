<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: order.php"); // Redirect if no ID
    exit;
}

$id = intval($_GET['id']); // Ensure it's an integer

// Delete the order
$stmt = $conn->prepare("DELETE FROM orders WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Optional: Set a success message in session
    session_start();
    $_SESSION['msg'] = "Order deleted successfully.";
} else {
    $_SESSION['msg'] = "Failed to delete order.";
}

$stmt->close();
$conn->close();

// Redirect back to order.php
header("Location: order.php");
exit;
?>

