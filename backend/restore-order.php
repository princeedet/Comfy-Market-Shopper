<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $conn->prepare("UPDATE orders SET deleted_at=NULL WHERE id=?");
    $query->bind_param("i", $id);
    $query->execute();

    header("Location: archived-orders.php?msg=Order+restored+successfully");
    exit;
}
