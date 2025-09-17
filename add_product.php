<?php
include "db.php"; // your DB connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $price       = $_POST['price'];
    $category    = $_POST['category'];

    // Handle Image Upload
    $imagePath = "";
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName   = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $name, $description, $price, $category, $imagePath);

    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully!'); window.location.href='products.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
