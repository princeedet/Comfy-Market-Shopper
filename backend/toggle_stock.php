<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Fetch current status
    $stmt = $conn->prepare("SELECT status FROM products WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if($result) {
        $currentStatus = $result['status'] ?? 'Available';
        $newStatus = ($currentStatus === 'Available') ? 'Out of Stock' : 'Available';

        // Update status
        $update = $conn->prepare("UPDATE products SET status=? WHERE id=?");
        $update->bind_param("si", $newStatus, $id);
        if($update->execute()){
            echo json_encode(['success'=>true, 'status'=>$newStatus]);
            exit;
        } else {
            echo json_encode(['success'=>false, 'error'=>$update->error]);
            exit;
        }
    } else {
        echo json_encode(['success'=>false, 'error'=>"Product not found"]);
        exit;
    }
}
?>
