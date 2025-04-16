<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products WHERE category='Kids'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans bg-white text-black" id="body">

    <!-- Navigation Bar -->
    <nav class="bg-[#3B8A9C] text-white">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex space-x-4">
                <a href="/FULLSTACK_PROJECT/homepage/homepage1.php" class="px-3 py-2 block hover:bg-white hover:text-[#3B8A9C] rounded transition">HOME</a>
                <a href="shop.php" class="px-3 py-2 block bg-white text-[#3B8A9C] rounded transition">SHOP</a>
                <a href="/FULLSTACK_PROJECT/cart/cart.php" class="px-3 py-2 block hover:bg-white hover:text-[#3B8A9C] rounded transition">CART</a>
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

    <section class="max-w-7xl mx-auto py-12 px-4">
        <h2 class="text-3xl font-bold italic text-center mb-8">KID'S LATEST COLLECTIONS</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-[40px] p-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-300 hover:shadow-2xl hover:scale-105 relative">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="w-full h-60 object-cover">

                    <div class="p-5">
                        <a href="/FULLSTACK_PROJECT/product/product.php?id=<?php echo $row['id']; ?>" class="text-xl font-semibold hover:underline">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </a>
                        <p class="text-gray-600 text-sm"><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="text-lg font-bold text-[#3B8A9C] mt-2">₹<?php echo number_format($row['price'], 2); ?></p>
                        <button onclick="addToCart(<?php echo $row['id']; ?>)" 
                            class="mt-4 w-full bg-[#3B8A9C] text-white px-4 py-2 rounded transition-transform duration-200 hover:scale-110">
                            Add to Cart
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <script>
        function addToCart(productId) {
            fetch('/FULLSTACK_PROJECT/cart/add_to_cart.php', {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "product_id=" + encodeURIComponent(productId) + "&quantity=1"
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: data.status,
                    text: data.message,
                    icon: data.icon,
                    confirmButtonColor: "#FFD700"
                });
            })
            .catch(error => {
                console.error("Fetch Error:", error);
                Swal.fire({
                    title: "Error",
                    text: "Failed to connect to the server!",
                    icon: "error",
                    confirmButtonColor: "#FFD700"
                });
            });
        }
    </script>

</body>
</html>

<?php $conn->close(); ?>