<?php
include "db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = intval($_POST['id']);

    $delete = $conn->query("DELETE FROM users WHERE id = $userId");

    if ($delete) echo json_encode(['status'=>'success','message'=>'User deleted']);
    else echo json_encode(['status'=>'error','message'=>$conn->error]);
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid request']);
}
?>
