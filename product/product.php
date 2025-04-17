<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "<script>
        alert('Product not found!');
        window.location.href = '/FULLSTACK_PROJECT/shop/shop.php';
    </script>";
    exit;
}

$product = $result->fetch_assoc();
// Update global product click count
$update_clicks_sql = "UPDATE products SET clicks = clicks + 1 WHERE id = ?";
$stmt = $conn->prepare($update_clicks_sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();

// If user is logged in, update per-user clicks
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Try to update first
    $update_user_click = "UPDATE product_clicks SET clicks = clicks + 1 WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($update_user_click);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();

    // If no row was updated, insert new
    if ($stmt->affected_rows === 0) {
        $insert_user_click = "INSERT INTO product_clicks (user_id, product_id, clicks) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($insert_user_click);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?> | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 font-sans">

<nav class="w-full bg-[#3B8A9C] flex items-center justify-between h-20 px-3 md:px-20 border-b-2 shadow-md fixed top-0 left-0 right-0 z-10">
    <!-- Left Side: Logo & Name -->
    <div class="flex items-center gap-3 bg-[#3B8A9C]">
        <img src="../images/fashionStore.jpg" alt="logo" class="w-20 h-20 rounded-4xl">
        <h2 class="font-serif text-3xl md:text-5xl">Fashion Store</h2>
    </div>

    <!-- Right Side: Sign Up Button -->
    <div class="flex gap-4 md:gap-6 justify-center mt-2">
      <a href="/FULLSTACK_PROJECT/shop/shop.php">
        <button class="bg-white hover:bg-gray-400 hover:text-white text-[#3B8A9C] font-serif border-2 rounded-2xl h-10 px-4 md:h-12 md:px-5 hover:cursor-pointer">
          Shop
        </button>
      </a>
      
      <a href="/FULLSTACK_PROJECT/cart/cart.php">
        <button class="bg-white hover:bg-gray-400 hover:text-white text-[#3B8A9C] font-serif border-2 rounded-2xl h-10 px-4 md:h-12 md:px-5 hover:cursor-pointer">
          Cart
        </button>
      </a>
    </div>
</nav>

    <section class="max-w-5xl mx-auto p-8 bg-white mt-30 rounded-lg shadow-md flex flex-col md:flex-row gap-8">
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full md:w-1/2 rounded object-cover">

        <div class="md:w-1/2">
            <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="text-lg text-gray-600 mb-4"><?php echo htmlspecialchars($product['description']); ?></p>
            <p class="text-2xl font-bold text-[#3B8A9C] mb-6">₹<?php echo number_format($product['price'], 2); ?></p>

            <button onclick="addToCart(<?php echo $product['id']; ?>)" 
    class="bg-[#3B8A9C] text-white px-6 py-3 rounded hover:scale-105 transition-transform">
    Add to Cart
</button>


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
        console.error("Error:", error);
        Swal.fire({
            title: "Error",
            text: "Could not add item to cart.",
            icon: "error",
            confirmButtonColor: "#FFD700"
        });
    });
}

</script>

</body>
</html>

<?php $conn->close(); ?>