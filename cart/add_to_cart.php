<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    die(json_encode(["status" => "Error", "message" => "Connection failed!", "icon" => "error"]));
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "Error", "message" => "You must be logged in!", "icon" => "error"]);
    exit;
}

if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    echo json_encode(["status" => "Error", "message" => "Invalid product data!", "icon" => "error"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);
$quantity = intval($_POST['quantity']);

// Check if the product is already in the cart
$check_sql = "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If product exists, update quantity
    $row = $result->fetch_assoc();
    $new_quantity = $row['quantity'] + $quantity;
    $update_sql = "UPDATE cart SET quantity = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ii", $new_quantity, $row['id']);
    $stmt->execute();
} else {
    // If product is not in cart, insert new row
    $insert_sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    $stmt->execute();
}

echo json_encode(["status" => "Success", "message" => "Item added to cart!", "icon" => "success"]);
$conn->close();
?>