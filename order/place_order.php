<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/FULLSTACK_PROJECT/auth/db.php");

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Unauthorized";
    exit;
}

$user_id = $_SESSION['user_id'];
$payment_method = $_POST['payment_method'] ?? '';
$total_amount = $_POST['total_amount'] ?? 0;
$address = $_POST['address'] ?? '';

if (!$payment_method || !$total_amount || !$address) {
    http_response_code(400);
    echo "Missing required fields";
    exit;
}

// Get all cart items for the user
$cart_sql = "SELECT * FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($cart_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();

if ($cart_result->num_rows > 0) {
    while ($row = $cart_result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];

        // Insert into orders
        $insert_sql = "INSERT INTO orders (user_id, product_id, quantity, total_amount, payment_method, address, created_at)
                       VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt2 = $conn->prepare($insert_sql);
        $stmt2->bind_param("iiisss", $user_id, $product_id, $quantity, $total_amount, $payment_method, $address);
        $stmt2->execute();
    }

    // Clear cart after order
    $delete_sql = "DELETE FROM cart WHERE user_id = ?";
    $stmt3 = $conn->prepare($delete_sql);
    $stmt3->bind_param("i", $user_id);
    $stmt3->execute();

    echo "Order placed successfully";
    exit;
} else {
    echo "No items in cart";
}

$conn->close();
?>