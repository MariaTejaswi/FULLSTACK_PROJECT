<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'Error',
        'message' => 'You must be logged in to remove from wishlist.',
        'icon' => 'error'
    ]);
    exit;
}

if (!isset($_POST['product_id'])) {
    echo json_encode([
        'status' => 'Error',
        'message' => 'Invalid product.',
        'icon' => 'error'
    ]);
    exit;
}

$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    echo json_encode([
        'status' => 'Error',
        'message' => 'Database connection failed.',
        'icon' => 'error'
    ]);
    exit;
}

$product_id = intval($_POST['product_id']);
$user_id = intval($_SESSION['user_id']);

// Debug logging
error_log("Trying to delete from wishlist: user_id = $user_id, product_id = $product_id");

$stmt = $conn->prepare("DELETE FROM u_wishlist WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $user_id, $product_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode([
        'status' => 'Success',
        'message' => 'Product removed from wishlist.',
        'icon' => 'success'
    ]);
} else {
    echo json_encode([
        'status' => 'Error',
        'message' => 'No product was removed. Maybe it doesn’t exist?',
        'icon' => 'error'
    ]);
}

$stmt->close();
$conn->close();
