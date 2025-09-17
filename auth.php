<?php
session_start();

// Dummy credentials for demo
$admin_email = "admin@comfy.com";
$admin_pass = "12345";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === $admin_email && $password === $admin_pass) {
        $_SESSION['user'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid credentials!'); window.location='index.php';</script>";
    }
}
