<?php
// Database connection settings
$host = "localhost";     // Database host
$user = "root";          // Database username (default for XAMPP is root)
$pass = "";              // Database password (default is empty in XAMPP)
$dbname = "shopdb";      // Database name

// Enable error reporting for MySQLi (useful for debugging)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Set charset to UTF-8
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

