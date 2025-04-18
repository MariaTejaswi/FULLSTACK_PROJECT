<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// Initialize filter parameters
$category = isset($_GET['category']) ? array_filter(explode(',', $_GET['category'])) : [];
$min_price = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? floatval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? floatval($_GET['max_price']) : 10000;
$size = isset($_GET['size']) ? array_filter(explode(',', $_GET['size'])) : [];

// Build the SQL query
$sql = "SELECT id, name, category, price, description, image FROM products WHERE 1=1";
$params = [];
$types = '';

if (!empty($category)) {
    $placeholders = implode(',', array_fill(0, count($category), '?'));
    $sql .= " AND category IN ($placeholders)";
    $params = array_merge($params, $category);
    $types .= str_repeat('s', count($category));
}
if ($min_price > 0) {
    $sql .= " AND price >= ?";
    $params[] = $min_price;
    $types .= 'd';
}
if ($max_price < 10000) {
    $sql .= " AND price <= ?";
    $params[] = $max_price;
    $types .= 'd';
}
if (!empty($size)) {
    $placeholders = implode(',', array_fill(0, count($size), '?'));
    $sql .= " AND size IN ($placeholders)";
    $params = array_merge($params, $size);
    $types .= str_repeat('s', count($size));
}

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Query preparation failed: ' . $conn->error]);
    exit();
}
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
if (!$stmt->execute()) {
    echo json_encode(['error' => 'Query execution failed: ' . $stmt->error]);
    exit();
}
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Get wishlist items for the user
$wishlist = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $wishlist_sql = "SELECT product_id FROM u_wishlist WHERE user_id = ?";
    $wishlist_stmt = $conn->prepare($wishlist_sql);
    if (!$wishlist_stmt) {
        echo json_encode(['error' => 'Wishlist query preparation failed: ' . $conn->error]);
        exit();
    }
    $wishlist_stmt->bind_param('i', $user_id);
    $wishlist_stmt->execute();
    $wishlist_result = $wishlist_stmt->get_result();
    while ($row = $wishlist_result->fetch_assoc()) {
        $wishlist[] = strval($row['product_id']);
    }
    $wishlist_stmt->close();
}

echo json_encode([
    'products' => $products,
    'wishlist' => $wishlist
]);

$stmt->close();
$conn->close();
?>