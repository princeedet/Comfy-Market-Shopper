<?php
header('Content-Type: application/json');

// Connect to DB
$conn = new mysqli("localhost", "root", "", "shopdb");
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit;
}

// Get employee ID
$empId = $_POST['employee_id'] ?? '';

if (empty($empId)) {
    echo json_encode([
        "success" => false,
        "message" => "Employee ID missing"
    ]);
    exit;
}

// Delete employee
$stmt = $conn->prepare("DELETE FROM employees WHERE emp_id = ?");
$stmt->bind_param("s", $empId);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Employee deleted successfully!"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "No employee found with ID: " . $empId
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Delete failed: " . $conn->error
    ]);
}

$stmt->close();
$conn->close();
exit;

