<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'Login Required',
            text: 'Please log in to view your cart.',
            icon: 'warning',
            confirmButtonColor: '#3B8A9C'
        }).then(() => {
            window.location.href = '/FULLSTACK_PROJECT/auth/login.html';
        });
    </script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT c.id, p.name, p.price, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = $user_id";
$result = $conn->query($sql);

$total_amount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>
<body class="bg-white text-[#3B8A9C] font-sans">

    <nav class="bg-[#3B8A9C] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between">
            <a href="/FULLSTACK_PROJECT/shop/shop.php" class="px-3 py-2 hover:bg-white hover:text-[#3B8A9C] transition rounded">SHOP</a>
            <a href="/FULLSTACK_PROJECT/cart/cart.php" class="px-3 py-2 bg-white text-[#3B8A9C] font-bold rounded shadow">CART</a>
        </div>
    </nav>

    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Cart Card -->
            <div class="w-full lg:w-1/2 bg-white border-2 border-[#3B8A9C] shadow-lg rounded-xl p-6 animate-fadein">
                <h2 class="text-3xl font-bold mb-6">🛍️ Your Cart</h2>

                <?php if ($result->num_rows > 0): ?>
                    <div class="space-y-4">
                        <?php while ($row = $result->fetch_assoc()):
                            $product_total = $row['price'] * $row['quantity'];
                            $total_amount += $product_total;
                        ?>
                            <div class="flex justify-between items-center bg-[#3B8A9C]/10 px-4 py-3 rounded-lg hover:shadow transition">
                                <div>
                                    <p class="font-semibold text-lg"><?php echo htmlspecialchars($row['name']); ?></p>
                                    <p class="text-sm">₹<?php echo number_format($row['price'], 2); ?> × <?php echo $row['quantity']; ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-lg">₹<?php echo number_format($product_total, 2); ?></p>
                                    <button onclick="removeFromCart(<?php echo $row['id']; ?>)" class="text-red-600 hover:text-red-800 text-sm">✖ Remove</button>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="mt-8 border-t pt-4 text-right">
                        <p class="text-xl font-bold">Total: ₹<?php echo number_format($total_amount, 2); ?></p>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Empty Cart" class="w-24 mx-auto mb-4 animate-bounce">
                        <p class="text-xl">Oops! Your cart is empty.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Ads Section -->
            <div class="w-full lg:w-1/2 bg-[#3B8A9C]/10 border-2 border-[#3B8A9C] rounded-xl p-6 flex items-center justify-center animate-fadein">
                <div class="text-center">
                    <h3 class="text-2xl font-bold mb-4 text-[#3B8A9C]">✨ Hot Offers</h3>
                    <img src="https://cdn-icons-png.flaticon.com/512/1055/1055646.png" alt="Ad Banner" class="w-40 mx-auto mb-4">
                    <p class="text-[#3B8A9C] text-lg">Use code <span class="font-bold">FASHION10</span> to get 10% OFF!</p>
                </div>
            </div>

        </div>
    </section>

    <script>
    function removeFromCart(cartId) {
        fetch('/FULLSTACK_PROJECT/cart/remove_from_cart.php', {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "cart_id=" + encodeURIComponent(cartId)
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                title: data.status,
                text: data.message,
                icon: data.icon,
                confirmButtonColor: "#3B8A9C"
            }).then(() => {
                location.reload();
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

    gsap.from(".animate-fadein", {
        opacity: 0,
        y: 50,
        duration: 1,
        ease: "power3.out",
        stagger: 0.2
    });
    </script>

</body>
</html>

<?php $conn->close(); ?>
