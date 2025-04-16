<?php
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products WHERE clicks > 0 ORDER BY clicks DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top Trending Ads | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
</head>
<body class="bg-gradient-to-r from-[#5a99a8] to-[#F5F7FA]">

    <nav class="bg-black text-white py-4 px-6">
        <div class="max-w-7xl mx-auto flex justify-between">
            <a href="/FULLSTACK_PROJECT/homepage/homepage.php" class="hover:text-yellow-500">Home</a>
            <!-- <a href="/FULLSTACK_PROJECT/advertise/ad.php" class="hover:text-yellow-500">Advertisements</a> -->
        </div>
    </nav>

    <section class="max-w-7xl mx-auto py-12 px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Top Trending Products</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <img src="<?php echo $row['image']; ?>" class="w-full h-48 object-cover rounded mb-4">
                        <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p class="text-yellow-600 font-bold mb-2">₹<?php echo number_format($row['price'], 2); ?></p>
                        <p class="text-gray-600 text-sm">Clicks: <?php echo $row['clicks']; ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">No product clicks recorded yet.</p>
        <?php endif; ?>

    </section>

</body>
</html>

<?php $conn->close(); ?>