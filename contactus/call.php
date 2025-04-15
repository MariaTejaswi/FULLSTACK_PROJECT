<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
</head>
<body class="bg-white relative">

<!-- Background Image -->
<div class="absolute inset-0 h-screen bg-cover bg-center opacity-75 z-0" style="background-image: url('/FULLSTACK_PROJECT/images/contactus.png');"></div>

<!-- Navigation Bar -->
<nav class="bg-black text-white relative z-10">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex space-x-4">
            <a href="/FULLSTACK_PROJECT/homepage/homepage.php" class="px-3 py-2 block hover:bg-[#3B8A9C] rounded">HOME</a>
            <a href="/FULLSTACK_PROJECT/shop/shop.php" class="px-3 py-2 block hover:bg-[#3B8A9C] rounded">SHOP</a>
            <a href="/FULLSTACK_PROJECT/cart/cart.php" class="px-3 py-2 block hover:bg-[#3B8A9C] rounded">CART</a>
            <a href="/FULLSTACK_PROJECT/contact/contact.php" class="px-3 py-2 block hover:bg-[#3B8A9C] rounded">CONTACT</a>
        </div>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="text-[#3B8A9C]">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                <a href="logout.php" class="px-3 py-2 ml-4 bg-red-500 text-white rounded">LOGOUT</a>
            <?php else: ?>
                <a href="/FULLSTACK_PROJECT/auth/login.html" class="px-3 py-2 bg-[#3B8A9C] text-white rounded">LOGIN / SIGN UP</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Contact Section -->
<section class="max-w-4xl mx-auto mt-12 bg-white p-8 rounded-lg shadow-md relative z-10">
    <h1 class="text-3xl font-bold mb-6 text-center">Contact Us</h1>
    <p class="text-gray-700 mb-4">📍 Address: 123 Fashion Street, Mumbai, MH 400001</p>
    <p class="text-gray-700 mb-4">📞 Phone: +91 98765 43210</p>
    <p class="text-gray-700 mb-4">✉️ Email: support@fashionstore.com</p>
    <p class="text-gray-700">⏰ Working Hours: Mon - Fri (10AM - 6PM)</p>
</section>

</body>
</html>
