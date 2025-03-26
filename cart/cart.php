<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    echo "<p class='text-center text-red-500 mt-10'>You must <a href='/FULLSTACK_PROJECT/auth/login.html' class='text-blue-500'>log in</a> to view your cart.</p>";
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT c.id, p.name, p.price, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
</head>
<body class="bg-gray-100">

    <nav class="bg-black text-white">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between">
            <a href="/FULLSTACK_PROJECT/shop/shop.php" class="px-3 py-2 hover:bg-yellow-500 rounded">SHOP</a>
            <a href="/FULLSTACK_PROJECT/cart/cart.php" class="px-3 py-2 bg-yellow-500 rounded">CART</a>
        </div>
    </nav>

    <section class="max-w-7xl mx-auto py-12 px-4">
        <h2 class="text-3xl font-bold text-center mb-8">Your Cart</h2>

        <?php if ($result->num_rows > 0): ?>
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-yellow-500 text-white">
                        <th class="px-4 py-2">Product</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="text-center">
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td class="px-4 py-2">₹<?php echo number_format($row['price'], 2); ?></td>
                            <td class="px-4 py-2"><?php echo $row['quantity']; ?></td>
                            <td class="px-4 py-2">₹<?php echo number_format($row['price'] * $row['quantity'], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-gray-600 mt-10">Your cart is empty.</p>
        <?php endif; ?>

    </section>

</body>
</html>

<?php $conn->close(); ?>