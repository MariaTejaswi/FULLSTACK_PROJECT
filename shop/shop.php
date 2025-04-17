<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .wishlist-button {
            position: absolute;
            top: 2px;
            right: 2px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.5rem; /* Adjust size as needed */
            color: #9ca3af; /* Gray color for unfilled */
            transition: color 0.2s ease;
            z-index: 10; /* Ensure it stays above other elements */
        }
        .wishlist-button:hover {
            color: #ef4444; /* Red on hover */
        }
        .wishlist-button.filled {
            color: #ef4444; /* Red when filled */
        }
    </style>
</head>
<body class="font-sans bg-gradient-to-r from-[#5a99a8] to-[#F5F7FA] text-black" id="body">

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
        <!-- <h2 class="text-3xl font-bold italic text-center mb-8">OUR LATEST COLLECTIONS</h2> -->
      <h2 id="auto-type-text" class="text-3xl md:text-4xl font-semibold italic text-center text-black"></h2><br>


        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-[40px] p-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                $is_in_wishlist = false;
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    $check_wishlist_sql = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
                    $check_wishlist_stmt = $conn->prepare($check_wishlist_sql);
                    $check_wishlist_stmt->bind_param('ii', $user_id, $row['id']);
                    $check_wishlist_stmt->execute();
                    $wishlist_result = $check_wishlist_stmt->get_result();
                    $is_in_wishlist = $wishlist_result->num_rows > 0;
                    $check_wishlist_stmt->close();
                }
                ?>
                <div class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-300 hover:shadow-2xl hover:scale-105 relative">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="w-full h-60 object-cover">

                    <!-- Heart button using Font Awesome -->
                    <button onclick="toggleWishlist(<?php echo $row['id']; ?>, this)" 
                            class="wishlist-button <?php echo $is_in_wishlist ? 'filled' : ''; ?>"
                            data-product-id="<?php echo $row['id']; ?>">
                        <i class="fas fa-heart"></i>
                    </button>

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

const text = "OUR LATEST COLLECTIONS";
  const autoTypeElement = document.getElementById("auto-type-text");
  let typeIndex = 0;

  function typeEffect() {
    if (typeIndex < text.length) {
      autoTypeElement.textContent += text.charAt(typeIndex);
      typeIndex++;
      setTimeout(typeEffect, 100); // Typing speed (100ms per character)
    } else {
      setTimeout(() => {
        autoTypeElement.textContent = ""; // Clear text
        typeIndex = 0; // Reset index
        typeEffect(); // Restart typing
      }, 2000); // Pause for 2 seconds before restarting
    }
  }

  window.addEventListener("DOMContentLoaded", typeEffect);






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

        function toggleWishlist(productId, buttonElement) {
            const heartIcon = buttonElement.querySelector('i');
            const isFilled = buttonElement.classList.contains('filled');
            const action = isFilled ? 'remove' : 'add';

            fetch('/FULLSTACK_PROJECT/cart/toggle_wishlist.php', { // Updated path
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + encodeURIComponent(productId) + '&action=' + encodeURIComponent(action)
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: data.status,
                    text: data.message,
                    icon: data.icon,
                    confirmButtonColor: '#3B8A9C'
                });

                // Toggle heart icon appearance
                if (data.status === 'Success') {
                    if (action === 'add') {
                        buttonElement.classList.add('filled');
                    } else {
                        buttonElement.classList.remove('filled');
                    }
                }
            })
            .catch(error => {
                console.error('Wishlist Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to connect to the server!',
                    icon: 'error',
                    confirmButtonColor: '#3B8A9C'
                });
            });
        }
    </script>

</body>
</html>

<?php $conn->close(); ?>