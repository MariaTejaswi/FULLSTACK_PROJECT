<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if (!isset($_SESSION['user_id'])) {
    echo "
    <script>
    window.onload = function () {
        Swal.fire({
            title: 'Login Required',
            text: 'Please log in to view your wishlist.',
            icon: 'warning',
            confirmButtonColor: '#3B8A9C'
        }).then(() => {
            window.location.href = '/FULLSTACK_PROJECT/auth/login.html';
        });
    }
    </script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT w.id AS wishlist_id, w.product_id, p.name, p.price, p.image 
        FROM u_wishlist w 
        JOIN products p ON w.product_id = p.id 
        WHERE w.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wishlist | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-r to-[#5a99a8] from-[#F5F7FA] text-[#3B8A9C] font-sans">

    <nav class="bg-[#3B8A9C] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between">
            <a href="/FULLSTACK_PROJECT/homepage/homepage1.php" class="px-3 py-2 hover:bg-white hover:text-[#3B8A9C] transition rounded">HOME</a>
            <a href="/FULLSTACK_PROJECT/shop/shop.php" class="px-3 py-2 bg-white text-[#3B8A9C] font-bold rounded shadow">SHOP</a>
        </div>
    </nav>

    <section class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold mb-6">Your Wishlist</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="bg-white border border-[#3B8A9C]/30 rounded-xl shadow hover:shadow-lg transition">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="w-full h-48 object-cover rounded-t-xl">
                        <div class="p-4 space-y-2">
                            <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($row['name']); ?></h3>
                            <p class="text-sm">₹<?php echo number_format($row['price'], 2); ?></p>
                            <button onclick="removeFromWishlist(<?php echo $row['product_id']; ?>)" class="text-white hover:text-gray-200 bg-red-500 rounded h-7 w-15 text-sm">Remove</button>
                            <button onclick="addToCart(<?php echo $row['product_id']; ?>)" class="mt-4 w-full bg-[#3B8A9C] text-white px-4 py-2 rounded transition-transform duration-200 hover:scale-110">Add to Cart</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="flex justify-center gap-4 mt-12">
                <a href="/FULLSTACK_PROJECT/cart/cart.php" class="px-6 py-2 bg-[#3B8A9C] text-white rounded hover:bg-[#357788] transition">Go to Cart</a>
                <a href="/FULLSTACK_PROJECT/shop/shop.php" class="px-6 py-2 bg-[#3B8A9C] text-white rounded hover:bg-[#357788] transition">Continue Shopping</a>
            </div>

        <?php else: ?>
            <div class="text-center py-12">
                <img src="https://cdn-icons-png.flaticon.com/512/4202/4202843.png" alt="Empty Wishlist" class="w-24 mx-auto mb-4 animate-bounce">
                <p class="text-xl">Your wishlist is currently empty.</p>
            </div>
        <?php endif; ?>
    </section>

    <script>
    function removeFromWishlist(productId) {
        fetch('/FULLSTACK_PROJECT/wishlist/remove_from_wishlist.php', {
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
                confirmButtonColor: "#3B8A9C"
            }).then(() => {
                let removed = JSON.parse(localStorage.getItem("removedWishlist")) || [];
                removed.push(productId);
                localStorage.setItem("removedWishlist", JSON.stringify(removed));
                location.reload();
            });
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire({
                title: "Error",
                text: "Failed to remove product from wishlist.",
                icon: "error",
                confirmButtonColor: "#3B8A9C"
            });
        });
    }

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
                confirmButtonColor: "#3B8A9C"
            });
        })
        .catch(error => {
            console.error("Fetch Error:", error);
            Swal.fire({
                title: "Error",
                text: "Failed to connect to the server!",
                icon: "error",
                confirmButtonColor: "#3B8A9C"
            });
        });
    }
    </script>

</body>
</html>

<?php $conn->close(); ?>
