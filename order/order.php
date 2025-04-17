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
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">My Orders</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left text-sm">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3">Quantity</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Payment</th>
                            <th class="px-4 py-3">Address</th>
                            <th class="px-4 py-3">Order Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <?php $count = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3"><?= $count++ ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($row['product_name']) ?></td>
                                <td class="px-4 py-3"><?= $row['quantity'] ?></td>
                                <td class="px-4 py-3">₹<?= number_format($row['total_amount'], 2) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($row['payment_method']) ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($row['address']) ?></td>
                                <td class="px-4 py-3"><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center text-lg bg-white p-6 rounded-lg shadow mt-10">
                You haven't placed any orders yet.
            </div>
        <?php endif; ?>

        <div class="mt-8 text-center">
            <a href="/FULLSTACK_PROJECT/homepage/homepage1.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition">
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