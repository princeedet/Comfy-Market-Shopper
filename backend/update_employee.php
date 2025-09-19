<?php
include 'config.php';

$id = $_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$status = $_POST['status'] ?? 'Inactive';

$stmt = $conn->prepare("UPDATE employees SET name=?, email=?, phone=?, status=? WHERE id=?");
$stmt->bind_param("ssssi", $name, $email, $phone, $status, $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "id" => $id,
        "name" => $name,
        "email" => $email,
        "phone" => $phone,
        "status" => $status
    ]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
