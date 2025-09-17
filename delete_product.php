<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // 1. Get product image so we can delete it too
    $result = $conn->query("SELECT image FROM products WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row['image'];

        // If image exists on server, delete it
        if (!empty($imagePath) && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // 2. Delete product from database
    $sql = "DELETE FROM products WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // Redirect back with success message
        header("Location: products.php?msg=deleted");
        exit;
    } else {
        echo "Error deleting product: " . $conn->error;
    }
} else {
    // If accessed incorrectly, go back
    header("Location: products.php");
    exit;
}
