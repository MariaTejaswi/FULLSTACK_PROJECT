<?php
session_start();
header("Content-Type: application/json");

if (!isset($_POST['product_id'])) {
    echo json_encode(["status" => "Error", "message" => "Product ID missing!", "icon" => "error"]);
    exit;
}

$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    echo json_encode(["status" => "Error", "message" => "Database connection failed!", "icon" => "error"]);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "Error", "message" => "You must log in to add items to the cart.", "icon" => "warning"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);

// Check if product exists
$product_check = $conn->query("SELECT id FROM products WHERE id = $product_id");
if ($product_check->num_rows == 0) {
    echo json_encode(["status" => "Error", "message" => "Product not found!", "icon" => "error"]);
    exit;
}

// Insert into cart or update quantity
$conn->query("INSERT INTO cart (user_id, product_id, quantity) 
              VALUES ($user_id, $product_id, 1) 
              ON DUPLICATE KEY UPDATE quantity = quantity + 1");

echo json_encode(["status" => "Success", "message" => "Item added to cart!", "icon" => "success"]);
$conn->close();
?>