<?php
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch top 3 products by clicks
$sql = "SELECT p.id, p.name, p.image, p.price, pc.clicks FROM product_clicks pc JOIN products p ON pc.product_id = p.id WHERE pc.user_id = $user_id AND pc.clicks > 0 ORDER BY pc.clicks DESC LIMIT 3";
$result = $conn->query($sql);
$top_products = $result->fetch_all(MYSQLI_ASSOC);


?>

<div class="max-w-7xl mx-auto py-12 px-4">
    <h2 class="text-3xl font-bold mb-8 text-center text-[#3B8A9C]">PERSONALISED RECOMMENDATION <br> BUY NOW!!!</h2>
    
    <?php if (empty($top_products)): ?>
        <p class="text-center text-gray-600">No personalised data yet.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php foreach ($top_products as $product): ?>
                <div class="bg-white shadow-md rounded-lg p-4 transform transition duration-300 hover:shadow-xl hover:scale-105">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-48 object-cover rounded mb-4">
                    <h3 class="text-xl font-semibold mb-2 text-[#3B8A9C]"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="text-[#3B8A9C] font-bold mb-2">₹<?php echo number_format($product['price'], 2); ?></p>
                    <!-- <p class="text-gray-600 text-sm mb-4">Clicks: <?php echo $product['clicks']; ?></p> -->
                    <a href="/FULLSTACK_PROJECT/product/product.php?id=<?php echo $product['id']; ?>" class="block bg-[#3B8A9C] text-white text-center px-4 py-2 rounded hover:bg-[#2a6a7c] transition">Shop Now</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>