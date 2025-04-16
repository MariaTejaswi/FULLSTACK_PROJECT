<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    echo json_encode([
        "status" => "Error",
        "message" => "Database connection failed",
        "icon" => "error"
    ]);
    exit();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "Failed",
        "message" => "You must be logged in to manage your wishlist.",
        "icon" => "warning"
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($product_id <= 0 || !in_array($action, ['add', 'remove'])) {
    echo json_encode([
        "status" => "Error",
        "message" => "Invalid request",
        "icon" => "error"
    ]);
    exit();
}

if ($action === 'add') {
    $check_sql = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $user_id, $product_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            "status" => "Info",
            "message" => "Product is already in your wishlist.",
            "icon" => "info"
        ]);
    } else {
        $insert_sql = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $user_id, $product_id);
        if ($insert_stmt->execute()) {
            echo json_encode([
                "status" => "Success",
                "message" => "Product added to wishlist!",
                "icon" => "success"
            ]);
        } else {
            echo json_encode([
                "status" => "Error",
                "message" => "Failed to add product to wishlist.",
                "icon" => "error"
            ]);
        }
        $insert_stmt->close();
    }
    $check_stmt->close();
} else {
    $delete_sql = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("ii", $user_id, $product_id);
    if ($delete_stmt->execute()) {
        if ($delete_stmt->affected_rows > 0) {
            echo json_encode([
                "status" => "Success",
                "message" => "Product removed from wishlist!",
                "icon" => "success"
            ]);
        } else {
            echo json_encode([
                "status" => "Info",
                "message" => "Product was not in your wishlist.",
                "icon" => "info"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "Error",
            "message" => "Failed to remove product from wishlist.",
            "icon" => "error"
        ]);
    }
    $delete_stmt->close();
}

$conn->close();
?>