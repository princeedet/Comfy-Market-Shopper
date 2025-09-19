<?php
header('Content-Type: application/json');

// Connect to DB
$conn = new mysqli("localhost", "root", "", "shopdb");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}

// Collect and sanitize inputs
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$status = 'Active';

// Basic validation
if (empty($name) || empty($email)) {
    echo json_encode(["success" => false, "message" => "Name and Email are required"]);
    exit;
}

// Generate emp_id safely (EMP001, EMP002, etc.)
$result = $conn->query("SELECT emp_id FROM employees ORDER BY emp_id DESC LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    $lastEmpId = intval(substr($row['emp_id'], 3));
    $newEmpId = "EMP" . str_pad($lastEmpId + 1, 3, "0", STR_PAD_LEFT);
} else {
    $newEmpId = "EMP001";
}

// Prepare insert statement
$stmt = $conn->prepare("INSERT INTO employees (emp_id, name, email, phone, status) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(["success" => false, "message" => $conn->error]);
    exit;
}

$stmt->bind_param("sssss", $newEmpId, $name, $email, $phone, $status);

// Execute
if ($stmt->execute()) {
    echo json_encode(["success" => true, "emp_id" => $newEmpId, "name" => $name, "email" => $email, "phone" => $phone, "status" => $status]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

// Close
$stmt->close();
$conn->close();
