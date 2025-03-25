<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css"> <!-- Tailwind CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
</head>
<body class="font-sans bg-gray-100">

    <!-- Navigation Bar -->
    <nav class="bg-black text-white">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex space-x-4">
                <a href="homepage.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">HOME</a>
                <a href="shop.php" class="px-3 py-2 block bg-yellow-500 rounded">SHOP</a>
                <a href="collection.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">COLLECTION</a>
                <a href="wishlist.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">WISHLIST</a>
                <a href="contact.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">CONTACT</a>
            </div>
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-yellow-500">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                    <a href="logout.php" class="px-3 py-2 ml-4 bg-red-500 text-white rounded">LOGOUT</a>
                <?php else: ?>
                    <a href="/FULLSTACK_PROJECT/auth/login.html" class="px-3 py-2 bg-yellow-500 text-white rounded">LOGIN / SIGN UP</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Shop Section -->
    <section class="max-w-7xl mx-auto py-12 px-4">
        <h2 class="text-3xl font-bold text-center mb-8">Our Latest Collection</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="w-full h-60 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p class="text-gray-600 text-sm"><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="text-lg font-bold text-yellow-500 mt-2">₹<?php echo number_format($row['price'], 2); ?></p>
                        <button onclick="addToCart('<?php echo htmlspecialchars($row['name']); ?>')" class="mt-4 w-full bg-yellow-500 text-white px-4 py-2 rounded hover:scale-105">Add to Cart</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <script>
        function addToCart(productName) {
            Swal.fire({
                title: "Added to Cart!",
                text: productName + " has been added to your cart.",
                icon: "success",
                confirmButtonColor: "#FFD700"
            });
        }
    </script>

</body>
</html>

<?php $conn->close(); ?>
