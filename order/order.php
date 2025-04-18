<?php
session_start();

$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if (!isset($_SESSION['user_id'])) {
    header("Location: /FULLSTACK_PROJECT/auth/login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT orders.id, orders.product_id, products.name AS product_name, orders.quantity, orders.total_amount, orders.address, orders.payment_method, orders.created_at FROM orders JOIN products ON orders.product_id = products.id WHERE orders.user_id = ? ORDER BY orders.created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="bg-gradient-to-r from-[#5a99a8] to-[#F5F7FA] text-[#3B8A9C] font-sans">

    <!-- Navigation Bar -->
    <nav class="bg-[#3B8A9C] text-white">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex space-x-4">
                <!-- <a href="/FULLSTACK_PROJECT/homepage/homepage1.php" class="px-3 py-2 block hover:bg-white hover:text-[#3B8A9C] rounded transition">HOME</a> -->
                <a href="shop.php" class="px-3 py-2 block bg-white text-[#3B8A9C] rounded transition">SHOP</a>
                <a href="/FULLSTACK_PROJECT/cart/cart.php" class="px-3 py-2 block hover:bg-white hover:text-[#3B8A9C] rounded transition">CART</a>
                <a href="/FULLSTACK_PROJECT/wishlist/wishlist.php" class="px-3 py-2 block hover:bg-white hover:text-[#3B8A9C] rounded transition">WISHLIST</a>
                <a href="/FULLSTACK_PROJECT/contactus/contact.php" class="px-3 py-2 block hover:bg-white hover:text-[#3B8A9C] rounded transition">CONTACT</a>
            </div>
            <div class="flex items-center space-x-4 ml-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-white">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                    <a href="/FULLSTACK_PROJECT/homepage/logout.php" class="px-3 py-2 bg-white text-[#3B8A9C] rounded">LOGOUT</a>
                <?php else: ?>
                    <a href="/FULLSTACK_PROJECT/auth/login.html" class="px-3 py-2 bg-white text-[#3B8A9C] rounded">LOGIN / SIGN UP</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-10 fade-in">
        <h1 class="text-4xl font-bold mb-8 text-center text-[#3B8A9C]">My Orders</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="overflow-x-auto shadow-xl rounded-xl border border-[#3B8A9C]/30">
                <table class="min-w-full bg-white rounded-xl text-sm">
                    <thead>
                        <tr class="bg-[#3B8A9C] text-white uppercase tracking-wider">
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Product</th>
                            <th class="px-6 py-4">Quantity</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Payment</th>
                            <th class="px-6 py-4">Address</th>
                            <th class="px-6 py-4">Order Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#3B8A9C]/20">
                        <?php $count = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-[#3B8A9C]/10 transition duration-200">
                                <td class="px-6 py-4"><?= $count++ ?></td>
                                <td class="px-6 py-4 font-medium"><?= htmlspecialchars($row['product_name']) ?></td>
                                <td class="px-6 py-4"><?= $row['quantity'] ?></td>
                                <td class="px-6 py-4">₹<?= number_format($row['total_amount'], 2) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['payment_method']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['address']) ?></td>
                                <td class="px-6 py-4"><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center text-lg bg-[#3B8A9C]/10 p-6 rounded-lg shadow mt-10 text-[#3B8A9C] font-semibold">
                You haven't placed any orders yet.
            </div>
        <?php endif; ?>

        <div class="mt-10 text-center fade-in">
            <a href="/FULLSTACK_PROJECT/homepage/homepage1.php"
               class="inline-block bg-[#3B8A9C] hover:bg-[#317685] text-white font-semibold py-2 px-6 rounded-full shadow transition duration-300 transform hover:scale-105">
                Back to Home
            </a>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
