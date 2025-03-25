<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub</title>
    <!-- Local Tailwind CSS -->
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="font-sans">
    <!-- Top Bar -->
    <div class="bg-white border-b border-gray-200 py-2">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-4">
            <!-- Left: Contact Info -->
            <div class="text-sm text-gray-600 text-center md:text-left">
                <span><i class="fas fa-envelope mr-1"></i> hello.lpu@gmail.com</span>
                <span class="ml-0 md:ml-4 block md:inline"><i class="fas fa-phone mr-1"></i> +91 999888800</span>
            </div>
            <!-- Right: Social, Language, Cart -->
            <div class="flex items-center space-x-4 text-sm mt-2 md:mt-0">
                <div class="flex space-x-2">
                    <i class="fab fa-facebook-f text-gray-600"></i>
                    <i class="fab fa-twitter text-gray-600"></i>
                    <i class="fab fa-linkedin-in text-gray-600"></i>
                    <i class="fab fa-pinterest text-gray-600"></i>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-globe mr-1 text-gray-600"></i>
                    <select class="border-none text-gray-600">
                        <option>English</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-shopping-cart mr-1 text-gray-600"></i>
                    <span class="text-gray-600">1000/-</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white py-4">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-4 space-y-4 md:space-y-0">
            <!-- Logo -->
            <h1 class="text-2xl font-bold">Fashi<span class="text-yellow-500">.</span></h1>
            <!-- Search Bar -->
            <div class="flex items-center space-x-2 w-full md:w-auto">
                <select class="border border-gray-300 rounded px-2 py-1">
                    <option value="all">All Categories</option>
                    <option value="mens">Men's</option>
                    <option value="womens">Women's</option>
                    <option value="kids">Kids</option>
                    <option value="bags">Bags</option>
                    <!-- <option value="accessories">Accessories</option> -->
                </select>
                <input type="text" placeholder="What do you need?" class="border border-gray-300 rounded px-2 py-1 w-full md:w-64">
                <button class="bg-yellow-500 text-white px-4 py-1 rounded">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <!-- Navigation -->
<nav class="bg-black text-white">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Left: Menu Items -->
        <div class="flex space-x-4">
            <a href="homepage.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">HOME</a>
            <a href="/FULLSTACK_PROJECT/shop/shop.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">SHOP</a>
            <a href="collection.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">COLLECTION</a>
            <a href="wishlist.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">WISHLIST</a>
            <a href="contact.php" class="px-3 py-2 block hover:bg-yellow-500 rounded">CONTACT</a>
        </div>

        <!-- Right: Conditional Login/Logout -->
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="text-yellow-500">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                <a href="logout.php" class="px-3 py-2 ml-4 bg-red-500 text-white rounded">LOGOUT</a>
            <?php else: ?>
                <a href="/FULLSTACK_PROJECT/auth/login.html" class="px-3 py-2 bg-yellow-500 text-white rounded">LOGIN / SIGN UP</a>
            <?php endif; ?>
        </div>
    </div>
</nav>


    <!-- Hero Section -->
<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center px-4 space-y-8 md:space-y-0">
        <!-- Left: Text and Button -->
        <div class="w-full md:w-1/2 text-center md:text-left">
            <!-- <p class="text-sm text-gray-500">BAG, KIDS</p> -->
            <h2 class="text-4xl md:text-5xl font-bold mt-2">Black Friday</h2>
            <p class="text-gray-600 mt-4">
                Discover the latest trends this Black Friday! <br class="hidden md:block">
                Unbeatable deals on stylish clothing for the whole family.
            </p>
            <button class="bg-yellow-500 text-white px-6 py-2 mt-6 rounded hover:scale-105">SHOP NOW</button>
        </div>
        <!-- Right: Image with Sale Badge -->
<div class="w-full md:w-1/2 relative">
    <img src="\FULLSTACK_PROJECT\images\Hero_img.jpg" alt="Hero Image" class="w-full md:w-[500px] md:h-[700px] object-cover shadow-2xl shadow-black ">
    <div class="absolute top-4 right-4 md:top-1 md:right-15 bg-yellow-500 text-white rounded-full w-28 h-28 flex items-center justify-center z-10">
        <span class="text-2xl font-bold">SALE 50%</span>
    </div>
</div>
    </div>
</section>

    <!-- Category Section -->
    <section class="max-w-7xl mx-auto py-16 px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Men's -->
            <div class="relative">
                <img src="\FULLSTACK_PROJECT\images\men's.jpg" alt="Men's" class="w-full h-64 object-cover hover:scale-105 shadow-2xl shadow-black">
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-gray-300 px-6 py-2">
                    <span class="text-xl font-bold">Men's</span>
                </div>
            </div>
            <!-- Women's -->
            <div class="relative">
                <img src="\FULLSTACK_PROJECT\images\women's.avif" alt="Women's" class="w-full h-64 object-cover hover:scale-105 shadow-2xl shadow-black">
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-gray-300 px-6 py-2">
                    <span class="text-xl font-bold">Women's</span>
                </div>
            </div>
            <!-- Kids -->
            <div class="relative">
                <img src="\FULLSTACK_PROJECT\images\kid's.jpg" alt="Kids" class="w-full h-64 object-cover hover:scale-105 shadow-2xl shadow-black">
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-gray-300 px-6 py-2">
                    <span class="text-xl font-bold ">Kids</span>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for Mobile Menu Toggle -->
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('menu');

        menuToggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>