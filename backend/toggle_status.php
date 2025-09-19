<?php
include "db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = intval($_POST['id']);
    $result = $conn->query("SELECT status FROM users WHERE id = $userId");

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $newStatus = ($user['status'] === 'Active') ? 'Inactive' : 'Active';

        $update = $conn->query("UPDATE users SET status='$newStatus' WHERE id = $userId");
        if ($update) echo json_encode(['status'=>'success','newStatus'=>$newStatus]);
        else echo json_encode(['status'=>'error','message'=>$conn->error]);
    } else {
        echo json_encode(['status'=>'error','message'=>'User not found']);
    }
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid request']);
}
?>
