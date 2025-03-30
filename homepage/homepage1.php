<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Store</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
     <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   
   
   
</head>
<body class="h-screen bg-contain bg-no-repeat bg-center bg-white" style="background-image: url('../images/background.png');">
<!-- <body class="bg-white h-screen"> -->

    <!-- Top Bar -->
    <!-- <div class="py-[16px] bg-[#3B8A9C]">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-4">
            Left: Contact Info
            <div class="text-sm text-black text-center md:text-left">
                <span><i class="fas fa-envelope mr-1"></i> hello.lpu@gmail.com</span>
                <span class="ml-0 md:ml-4 block md:inline"><i class="fas fa-phone mr-1"></i> +91 999888800</span>
            </div>
            Right: Social, Language, Cart
            <div class="flex items-center space-x-4 text-sm mt-2 md:mt-0">
                <div class="flex space-x-2">
                    <i class="fab fa-facebook-f text-black"></i>
                    <i class="fab fa-twitter text-black"></i>
                    <i class="fab fa-linkedin-in text-black"></i>
                    <i class="fab fa-pinterest text-black"></i>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-globe mr-1 text-black"></i>
                    <select class="border-none text-black">
                        <option>English</option>
                    </select>
                </div>
                
            </div>
        </div>
    </div> -->

         <!-- Navigation -->
 <nav class="top-0 left-0 w-full bg-transparent shadow-md text-black flex items-center justify-between px-6 py-2">

  <img src="../images/fashionStore.jpg" alt="logo" class="w-20 mr-5 h-auto rounded-xl">
 
  <div class="w-full flex justify-between items-center">

        <!-- Left: Menu Items -->
        <div class="flex space-x-20 ">
            <!-- <img src="../images/logo.png" alt="logo" class="w-40 h-auto"> -->
            <a href="index.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded">HOME</a>
            <a href="shop.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded">ACCESSORIES</a>
            <a href="collection.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded">CART</a>
    <!-- <img src="../images/crown.png" alt="crown" class="ml-48 block w-26 h-auto"> -->

        </div>
    <img src="../images/crown.png" alt="crown" class="ml-60 block w-26 h-auto">

         <!-- Search Bar -->
         <div class="flex ml-35
          space-x-2 w-full">
                <select class="border border-black rounded px-2 py-1">
                    <option value="all">All Categories</option>
                    <option value="mens">Men's</option>
                    <option value="womens">Women's</option>
                    <option value="kids">Kids</option>
                    <!-- <option value="bags">Bags</option> -->
                    <option value="accessories">Accessories</option>
                </select>
                <input type="text" placeholder="What do you need?" class="border border-black rounded px-2 py-1 w-full md:w-60">
                <button class="bg-[#3B8A9C] text-white px-4 py-1 rounded">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        <div class="flex flex-end space-x-2">
            <a href="wishlist.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded">CONTACT</a>
            <!-- <a href="contact.php" class="px-3 py-2 block bg-[#3B8A9C] hover:bg-[#3B8A9C] hover:text-white rounded">LOGIN/SIGNUP</a> -->
        </div>
        <!-- Right: Conditional Login/Logout -->
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="text-[#3B8A9C]">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                <a href="logout.php" class="px-3 py-2 ml-4 bg-[#3B8A9C] text-white rounded">LOGOUT</a>
            <?php else: ?>
                <a href="/FULLSTACK_PROJECT/auth/login.html" class="px-3 py-2 bg-[#3B8A9C] hover:text-white text-black rounded">LOGIN/SIGNUP</a>
            <?php endif; ?>
        </div>
    </div>
    </nav>

     <!-- Hero Section -->
<section class="bg-[#3B8A9C] py-10 mt-28">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center px-4 space-y-8 md:space-y-0">
        <!-- Left: Text and Button -->
        <div class="w-full md:w-1/2 text-center md:text-left">
            <!-- <p class="text-sm text-gray-500">BAG, KIDS</p> -->
            <h2 class="text-4xl text-black md:text-5xl font-bold mt-2">Black Friday</h2>
            <p class="text-black mt-4">
                Discover the latest trends this Black Friday! <br class="hidden md:block">
                Unbeatable deals on stylish clothing for the whole family.
            </p>
            <button class="bg-white text-black px-6 py-2 mt-6 rounded hover:scale-105">SHOP NOW</button>
        </div>
        <!-- Right: Image with Sale Badge -->
<div class="w-full md:w-1/2 relative">
    <img src="\FULLSTACK_PROJECT\images\Hero_img.jpg" alt="Hero Image" class="w-full md:w-[500px] md:h-[700px] object-cover shadow-2xl shadow-black ">
    <div class="absolute top-4 right-4 md:top-1 md:right-15 bg-white text-[#3B8A9C] rounded-full w-28 h-28 flex items-center justify-center z-10">
        <span class="text-2xl font-bold">SALE 50%</span>
    </div>
</div>
    </div>
</section>

<!-- Category Section -->
<!-- <div style="background-image: url(../images/man.png); opacity: 75%; width: full; height: auto; object-fit:cover;"> -->
<section class="max-w-7xl mx-auto py-16 px-4 " >
    <!-- <div style="background-image: url(../images/man.png); opacity: 75%; object-cover"> -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
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
            <!-- Accessories -->
            <div class="relative">
                <img src="\FULLSTACK_PROJECT\images\acc.png" alt="ACC" class="w-full h-64 object-fit hover:scale-105 shadow-2xl shadow-black">
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-gray-300 px-6 py-2">
                    <span class="text-xl font-bold">Accessories</span>
                </div>
            </div>
        </div>
    
    </section>
    <!-- </div> -->
</body>
</html>
