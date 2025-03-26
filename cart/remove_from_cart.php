<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    die(json_encode(["status" => "Error", "message" => "Database connection failed", "icon" => "error"]));
}

if (!isset($_SESSION['user_id'])) {
    die(json_encode(["status" => "Error", "message" => "User not logged in", "icon" => "error"]));
}

if (!isset($_POST['cart_id'])) {
    die(json_encode(["status" => "Error", "message" => "Invalid request", "icon" => "error"]));
}

$cart_id = intval($_POST['cart_id']);
$user_id = $_SESSION['user_id'];

// Get current quantity of the product in the cart
$sql = "SELECT quantity FROM cart WHERE id = $cart_id AND user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $quantity = $row['quantity'];

    if ($quantity > 1) {
        // Reduce the quantity by 1
        $update_sql = "UPDATE cart SET quantity = quantity - 1 WHERE id = $cart_id AND user_id = $user_id";
        if ($conn->query($update_sql) === TRUE) {
            echo json_encode(["status" => "Success", "message" => "Quantity updated!", "icon" => "success"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Failed to update quantity", "icon" => "error"]);
        }
    } else {
        // If quantity is 1, delete the product from cart
        $delete_sql = "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id";
        if ($conn->query($delete_sql) === TRUE) {
            echo json_encode(["status" => "Success", "message" => "Product removed from cart!", "icon" => "success"]);
        } else {
            echo json_encode(["status" => "Error", "message" => "Failed to remove product", "icon" => "error"]);
        }
    }
} else {
    echo json_encode(["status" => "Error", "message" => "Product not found", "icon" => "error"]);
}

$conn->close();
?>