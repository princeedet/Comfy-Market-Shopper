<?php
include 'config.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];

    $query = "UPDATE orders SET status=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    header("Location: order-details.php?id=$id");
    exit;
} else {
    die("Invalid request.");
}
