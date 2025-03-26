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
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans bg-gray-100">

    <nav class="bg-black text-white">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex space-x-4">
                <a href="/FULLSTACK_PROJECT/homepage/homepage.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">HOME</a>
                <a href="shop.php" class="px-3 py-2 block bg-yellow-500 rounded">SHOP</a>
                <a href="/FULLSTACK_PROJECT/cart/cart.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">CART</a>
                <a href="contact.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">CONTACT</a>
            </div>
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-yellow-500">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                    <a href="/FULLSTACK_PROJECT/homepage/logout.php" class="px-3 py-2 ml-4 bg-red-500 text-white rounded">LOGOUT</a>
                <?php else: ?>
                    <a href="/FULLSTACK_PROJECT/auth/login.html" class="px-3 py-2 bg-yellow-500 text-white rounded">LOGIN / SIGN UP</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="max-w-7xl mx-auto py-12 px-4">
        <h2 class="text-3xl font-bold text-center mb-8">Our Latest Collection</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-[40px] p-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-300 hover:shadow-2xl hover:scale-105 relative">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="w-full h-60 object-cover">
                    
                    <button onclick="addToWishlist(<?php echo $row['name']; ?>)"
                        class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-lg transition duration-200 hover:bg-yellow-500 group">
                        <svg class="w-6 h-6 text-gray-500 group-hover:text-white transition duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-.06-.06a5.5 5.5 0 00-7.78 7.78l7.84 7.84a.75.75 0 001.06 0l7.84-7.84a5.5 5.5 0 000-7.78z"></path>
                        </svg>
                    </button>

                    <div class="p-5">
                        <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p class="text-gray-600 text-sm"><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="text-lg font-bold text-yellow-500 mt-2">₹<?php echo number_format($row['price'], 2); ?></p>
                        <button onclick="addToCart(<?php echo $row['id']; ?>)" 
                            class="mt-4 w-full bg-yellow-500 text-white px-4 py-2 rounded transition-transform duration-200 hover:scale-110">
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
        body: "product_id=" + encodeURIComponent(productId)
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