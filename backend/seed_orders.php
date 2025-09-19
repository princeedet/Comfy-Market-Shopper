<?php
include "config.php"; // Make sure this connects to your database

// Array of sample customers
$customers = [
    ["John Doe", "john@example.com", "08012345678", "12 Broad Street, Lagos"],
    ["Grace Johnson", "grace@example.com", "08077778888", "22 Ikoyi Crescent, Lagos"],
    ["Samuel Okoro", "samuel@example.com", "08122223333", "8 Marina Road, Abuja"],
    ["Linda Peter", "linda@example.com", "09044445555", "34 Opebi Road, Ikeja"],
    ["David Bright", "david@example.com", "08066667777", "9 Garki Area 2, Abuja"],
    ["Mary Samuel", "mary@example.com", "08155556666", "2 Lekki Phase 1, Lagos"],
    ["James Tony", "james@example.com", "07033334444", "7 Maitama Crescent, Abuja"],
    ["Victoria Kings", "victoria@example.com", "08099990000", "16 Allen Avenue, Ikeja"],
    ["Paul Andrew", "paul@example.com", "08022221111", "5 Aguda Road, Surulere"],
    ["Elizabeth Adams", "liz@example.com", "08188887777", "3 Wuse Zone 5, Abuja"]
];

// Order statuses
$statuses = ["Pending", "Processing", "Completed", "Cancelled"];

// Insert 15 random orders
for ($i = 0; $i < 15; $i++) {
    $customer = $customers[array_rand($customers)];
    $status = $statuses[array_rand($statuses)];
    $product_id = rand(1, 3); // Assuming you already have products with IDs 1–3
    $quantity = rand(1, 5);
    $price_per_item = rand(5000, 15000); // ₦5,000 – ₦15,000
    $total_price = $quantity * $price_per_item;

    $sql = "INSERT INTO orders 
            (product_id, quantity, total_price, customer_name, customer_email, customer_phone, delivery_address, status) 
            VALUES 
            ($product_id, $quantity, $total_price, 
            '{$customer[0]}', '{$customer[1]}', '{$customer[2]}', '{$customer[3]}', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Order for {$customer[0]} inserted successfully.<br>";
    } else {
        echo "❌ Error: " . $conn->error . "<br>";
    }
}

$conn->close();
