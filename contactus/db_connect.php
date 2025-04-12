<?php
$servername = "localhost"; // Typically 'localhost'
$username = "root"; // Default MySQL username for XAMPP
$password = ""; // Default is empty for XAMPP
$dbname = "fashionhub_db"; // Database name you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
