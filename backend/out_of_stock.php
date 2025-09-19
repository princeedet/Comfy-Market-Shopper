<?php
include 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Fetch current status
    $stmt = $conn->prepare("SELECT status FROM products WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!$result) {
        echo json_encode(['success' => false, 'error' => 'Product not found']);
        exit;
    }

    $currentStatus = $result['status'] ?? 'Available';
    $newStatus = $currentStatus === 'Available' ? 'Out of Stock' : 'Available';

    // Update status
    $stmt = $conn->prepare("UPDATE products SET status=? WHERE id=?");
    $stmt->bind_param("si", $newStatus, $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'newStatus' => $newStatus]);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
