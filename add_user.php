<?php
include "db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $location = $conn->real_escape_string($_POST['location']);
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo json_encode(['status'=>'error','message'=>'Username and password required']);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $insert = $conn->query("INSERT INTO users (username, email, phone, location, password, status) 
                            VALUES ('$username','$email','$phone','$location','$hashedPassword','Active')");

    if ($insert) {
        echo json_encode(['status'=>'success','message'=>'User added']);
    } else {
        echo json_encode(['status'=>'error','message'=>$conn->error]);
    }
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid request']);
}
?>
