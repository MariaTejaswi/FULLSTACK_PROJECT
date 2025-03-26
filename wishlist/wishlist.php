<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("Please login to view your wishlist.");
}

// Fetch wishlist items
$sql = "SELECT products.* FROM wishlist 
        JOIN products ON wishlist.product_id = products.id 
        WHERE wishlist.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans bg-gray-100">

    <!-- Navigation -->
    <nav class="bg-black text-white">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex space-x-4">
                <a href="/FULLSTACK_PROJECT/homepage/homepage.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">HOME</a>
                <a href="shop.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">SHOP</a>
                <a href="wishlist.php" class="px-3 py-2 block bg-yellow-500 rounded">WISHLIST</a>
                <a href="contact.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">CONTACT</a>
            </div>
            <div>
                <?php if ($user_id): ?>
                    <span class="text-yellow-500">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                    <a href="logout.php" class="px-3 py-2 ml-4 bg-red-500 text-white rounded">LOGOUT</a>
                <?php else: ?>
                    <a href="/FULLSTACK_PROJECT/auth/login.html" class="px-3 py-2 bg-yellow-500 text-white rounded">LOGIN / SIGN UP</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Wishlist Section -->
    <section class="max-w-7xl mx-auto py-12 px-4">
        <h2 class="text-3xl font-bold text-center mb-8">Your Wishlist</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10 p-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-300 hover:shadow-2xl hover:scale-105">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="w-full h-60 object-cover">
                    <div class="p-5">
                        <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p class="text-gray-600 text-sm"><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="text-lg font-bold text-yellow-500 mt-2">₹<?php echo number_format($row['price'], 2); ?></p>
                        <button onclick="removeFromWishlist(<?php echo $row['id']; ?>)" 
                            class="mt-4 w-full bg-red-500 text-white px-4 py-2 rounded transition-transform duration-200 hover:scale-110">
                            Remove from Wishlist
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <script>
        function removeFromWishlist(productId) {
            fetch("remove_wishlist.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "product_id=" + productId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: "Removed!",
                        text: "Item removed from wishlist.",
                        icon: "success",
                        confirmButtonColor: "#FFD700"
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire("Error", "Something went wrong!", "error");
                }
            });
        }
    </script>

</body>
</html>

<?php $conn->close(); ?>
