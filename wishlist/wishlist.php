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
$sql = "SELECT w.id AS wishlist_id, w.product_id, p.name, p.price 
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>
<body class="bg-white text-[#3B8A9C] font-sans">

    <nav class="bg-[#3B8A9C] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between">
            <a href="/FULLSTACK_PROJECT/homepage/homepage1.php" class="px-3 py-2 hover:bg-white hover:text-[#3B8A9C] transition rounded">HOME</a>
            <a href="/FULLSTACK_PROJECT/shop/shop.php" class="px-3 py-2 bg-white text-[#3B8A9C] font-bold rounded shadow">SHOP</a>
        </div>
    </nav>

    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="w-full bg-white border-2 border-[#3B8A9C] shadow-lg rounded-xl p-6 animate-fadein">
            <h2 class="text-3xl font-bold mb-6">💖 Your Wishlist</h2>

            <?php if ($result->num_rows > 0): ?>
                <div class="space-y-4">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="flex justify-between items-center bg-[#3B8A9C]/10 px-4 py-3 rounded-lg hover:shadow transition">
                            <div>
                                <p class="font-semibold text-lg"><?php echo htmlspecialchars($row['name']); ?></p>
                                <p class="text-sm">₹<?php echo number_format($row['price'], 2); ?></p>
                            </div>
                            <div class="text-right">
                            <button onclick="removeFromWishlist(<?php echo $row['product_id']; ?>)" class="text-red-500 hover:text-red-700">Remove</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <img src="https://cdn-icons-png.flaticon.com/512/4202/4202843.png" alt="Empty Wishlist" class="w-24 mx-auto mb-4 animate-bounce">
                    <p class="text-xl">Your wishlist is currently empty.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script>
function removeFromWishlist(productId) {
    fetch('/FULLSTACK_PROJECT/wishlist/remove_from_wishlist.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
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
            // Save the removed product ID to localStorage for syncing with shop page
            let removed = JSON.parse(localStorage.getItem("removedWishlist")) || [];
            removed.push(productId);
            localStorage.setItem("removedWishlist", JSON.stringify(removed));

            // Reload to update wishlist page
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
</script>

</body>
</html>

<?php $conn->close(); ?>
