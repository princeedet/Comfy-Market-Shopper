<?php
header('Content-Type: application/json'); // Tell browser this is JSON
require 'db.php'; // your DB connection file

$response = ["success" => false, "message" => "Unknown error"];

// Collect form data safely
$name   = trim($_POST['name'] ?? '');
$email  = trim($_POST['email'] ?? '');
$phone  = trim($_POST['phone'] ?? '');
$status = trim($_POST['status'] ?? 'Inactive');

// Basic validation
if ($name === '' || $email === '' || $phone === '') {
    $response['message'] = "All fields are required.";
    echo json_encode($response);
    exit;
}

// Generate random password (you can improve this)
$password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);

// Insert into DB
$stmt = $conn->prepare("INSERT INTO employees (name, email, phone, status, password) VALUES (?, ?, ?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("sssss", $name, $email, $phone, $status, $password);
    if ($stmt->execute()) {
        $response = [
            "success"  => true,
            "message"  => "Employee created successfully!",
            "emp_id"   => $stmt->insert_id,
            "name"     => $name,
            "email"    => $email,
            "phone"    => $phone,
            "status"   => $status,
            "password" => $password
        ];
    } else {
        $response['message'] = "Database insert failed: " . $stmt->error;
    }
    $stmt->close();
} else {
    $response['message'] = "SQL prepare failed: " . $conn->error;
}

echo json_encode($response);
exit;
