<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "fashionhub_db";

// Create Connection
$conn = new mysqli($host, $user, $password, $database);

// Check Connection
if ($conn->connect_errno) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set charset to UTF-8 (for better encoding support)
$conn->set_charset("utf8mb4");
?>