<?php
include 'db.php';
header('Content-Type: application/json');

if(isset($_POST['id'])){
    $id = intval($_POST['id']);

    // Get current status
    $row = $conn->query("SELECT status FROM users WHERE id=$id")->fetch_assoc();
    if(!$row){
        echo json_encode(['status'=>'error','message'=>'User not found']);
        exit;
    }

    $newStatus = ($row['status'] === 'Inactive') ? 'Active' : 'Inactive';
    $update = $conn->query("UPDATE users SET status='$newStatus' WHERE id=$id");

    if($update){
        $counts = [
            'totalUsers' => (int)$conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'],
            'activeUsers' => (int)$conn->query("SELECT COUNT(*) AS c FROM users WHERE status='Active'")->fetch_assoc()['c'],
            'newThisMonth' => (int)$conn->query("SELECT COUNT(*) AS c FROM users WHERE MONTH(created_at)=MONTH(CURRENT_DATE()) AND YEAR(created_at)=YEAR(CURRENT_DATE())")->fetch_assoc()['c'],
            'totalOrders' => (int)$conn->query("SELECT COUNT(*) AS c FROM orders")->fetch_assoc()['c']
        ];
        echo json_encode(['status'=>'success','counts'=>$counts,'newStatus'=>$newStatus]);
    } else {
        echo json_encode(['status'=>'error','message'=>'Could not update user status']);
    }
}
?>
