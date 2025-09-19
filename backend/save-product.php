<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'];
    $category = $_POST['category'] ?? '';
    
    // Handle image upload
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $imagePath = $targetDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    // Insert product into database
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $name, $description, $price, $category, $imagePath);
    if ($stmt->execute()) {

        // Insert into activity feed
        $message = "New product <b>{$name}</b> added";
        $stmt2 = $conn->prepare("INSERT INTO activity (type, message) VALUES ('product', ?)");
        $stmt2->bind_param("s", $message);
        $stmt2->execute();

        echo "<script>
            alert('Product added successfully!');
            window.location.href='dashboard.php';
        </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
