<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "user_auth";

// Create Connection
$conn = new mysqli($host, $user, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>