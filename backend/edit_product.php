<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $special_offer = isset($_POST['special_offer']) ? 'Yes' : 'No';

    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        $image = $targetDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    if ($image) {
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category=?, image=?, special_offer=? WHERE id=?");
        $stmt->bind_param("ssdsssi", $name, $description, $price, $category, $image, $special_offer, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category=?, special_offer=? WHERE id=?");
        $stmt->bind_param("ssdssi", $name, $description, $price, $category, $special_offer, $id);
    }

    if ($stmt->execute()) {
        header("Location: products.php?msg=updated");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
