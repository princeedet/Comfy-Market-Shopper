<?php
include "db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = intval($_POST['id']);

    // Suspend user by setting status to Inactive
    $update = $conn->query("UPDATE users SET status='Inactive' WHERE id = $userId");

    if ($update) echo json_encode(['status'=>'success','message'=>'User suspended']);
    else echo json_encode(['status'=>'error','message'=>$conn->error]);
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid request']);
}
?>

