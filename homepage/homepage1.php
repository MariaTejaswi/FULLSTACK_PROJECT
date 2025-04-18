<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Fashion Store</title>
  <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter&family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .fade {
      animation: fadeEffect 1s ease-in-out;
    }
    @keyframes fadeEffect {
      from { opacity: 0.4; }
      to { opacity: 1; }
    }
    /* Blinking cursor for autotyper */
    #auto-type-text::after {
      content: "|";
      animation: blink 0.7s infinite;
    }
    @keyframes blink {
      0% { opacity: 1; }
      50% { opacity: 0; }
      100% { opacity: 1; }
    }
    /* Pulse animation for button */
    button:hover {
      animation: pulse 0.5s;
    }
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }
  </style>
</head>
<body class="h-screen bg-gradient-to-r from-gray-400 to-[#6daab9]">

<!-- Navigation Bar -->
<div class="flex items-center justify-between px-6 py-2">
  <!-- Logo on the left -->
  <div>
    <img src="../images/2bg.svg" alt="logo" class="h-20 rounded-xl" />
  </div>

  <!-- Search bar and dropdowns on the right -->
  <div class="flex items-center space-x-2">
    <select class="border border-black rounded px-2 py-1" onchange="navigateCategory(this)">
      <option value="all">All Categories</option>
      <option value="mens">Men's</option>
      <option value="womens">Women's</option>
      <option value="kids">Kids</option>
      <option value="accessories">Accessories</option>
    </select>
    <input type="text" placeholder="What do you need?" class="border border-black rounded px-2 py-1 w-40 md:w-60" />
    <button class="bg-[#3B8A9C] text-white px-4 py-1 rounded">
      <i class="fas fa-search"></i>
    </button>
  </div>
</div>

<hr>

<nav class="top-0 left-0 w-full bg-transparent shadow-md text-black flex items-center px-6 py-2">
  <!-- <img src="../images/1bg.svg" alt="logo" class="w-20 mr-5 h-auto rounded-xl" /> -->
  <div class="w-full flex items-center justify-between">
  
    <!-- Left: Menu Links -->
<div class="flex space-x-6">
  <a href="/FULLSTACK_PROJECT/homepage/homepage1.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded"><i class="fas fa-home mr-1 align-middle"></i>HOME</a>
  <a href="/FULLSTACK_PROJECT/shop/shop.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded"><i class="fas fa-store mr-1 align-middle"></i>SHOP</a>
  <?php if (!isset($_SESSION['user_id'])): ?>
  <a href="#" onclick="showLoginAlert('cart')" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded"><i class="fas fa-shopping-cart mr-1 align-middle"></i>CART</a>
  <a href="#" onclick="showLoginAlert('wishlist')" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded"><i class="fas fa-heart mr-1 align-middle"></i>WISHLIST</a>
  <script>
          function showLoginAlert() {
              Swal.fire({
                  title: 'Login Required',
                  text: 'Please log in to view your cart.',
                  icon: 'warning',
                  confirmButtonColor: '#3B8A9C'
              }).then(() => {
                  window.location.href = '/FULLSTACK_PROJECT/auth/login.html';
              });
          }
      </script>
  <?php else: ?>
  <a href="/FULLSTACK_PROJECT/cart/cart.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded"><i class="fas fa-shopping-cart mr-1 align-middle"></i>CART</a>
  <a href="/FULLSTACK_PROJECT/wishlist/wishlist.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded"><i class="fas fa-heart mr-1 align-middle"></i>WISHLIST</a>
  <?php endif; ?>
</div>
    <!-- Center: Crown Image -->
<img src="../images/1bg.svg" alt="crown" class="mx-auto w-24 h-auto"/>

    <!-- Right: Contact and Login/Logout -->
    <div class="flex items-center space-x-4">
      <a href="/FULLSTACK_PROJECT/contactus/contact.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded"><i class="fas fa-envelope mr-1 align-middle"></i>CONTACT</a>
      <div class="flex items-center space-x-2">
        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- Debug: Check if $_SESSION['username'] is set correctly in login script -->
          <span class="text-[#3B8A9C] font-medium max-w-[150px] overflow-hidden text-ellipsis whitespace-nowrap">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
          <a href="logout.php" class="px-3 py-2 bg-[#3B8A9C] text-white rounded hover:bg-[#337685] whitespace-nowrap">LOGOUT</a>
        <?php else: ?>
          <a href="/FULLSTACK_PROJECT/auth/login.html" class="px-3 py-2 bg-[#3B8A9C] text-white rounded hover:bg-[#337685] whitespace-nowrap">LOGIN/SIGNUP</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<!-- Heading and Search Bar Section -->


<!-- Hero Section -->
<section class="bg-[#3B8A9C] min-h-[900px] py-24">
<div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center space-y-8 md:space-y-0">
    <!-- Text Section -->
    <div class="w-full md:w-1/2 text-center md:text-left">
      <!-- <h2 class="text-4xl text-black md:text-5xl font-bold mt-2">Black Friday</h2> -->
      <h1 id="auto-type-text" class="text-3xl md:text-5xl font-semibold text-center text-white"></h1>
      <p class="text-white mt-4">
        Dive into the Hottest Black Friday Fashion Frenzy! <br class="hidden md:block" />
        Irresistible Deals on Trendsetting Looks for Everyone.
      </p>
      <a href="/FULLSTACK_PROJECT/shop/shop.php">
        <button class="bg-white text-[#3B8A9C] font-bold px-6 py-2 mt-6 rounded hover:scale-105">GRAB YOUR FAVES NOW!</button>
      </a>
    </div>

    <!-- Image Carousel Section -->
    <div class="w-full md:w-1/2 relative">
      <div class="relative w-full h-[700px] rounded overflow-hidden shadow-2xl shadow-black flex items-center justify-center">
        <img class="carousel-image absolute w-full h-full object-contain fade" src="/FULLSTACK_PROJECT/images/Hero_img.jpg" alt="Hero 1" />
        <img class="carousel-image absolute w-full h-full object-contain fade hidden" src="/FULLSTACK_PROJECT/images/hero2.avif" alt="Hero 2" />
        <img class="carousel-image absolute w-full h-full object-contain fade hidden" src="/FULLSTACK_PROJECT/images/hero3.avif" alt="Hero 3" />
        <img class="carousel-image absolute w-full h-full object-contain fade hidden" src="/FULLSTACK_PROJECT/images/hero4.webp" alt="Hero 4" />
        <img class="carousel-image absolute w-full h-full object-contain fade hidden" src="/FULLSTACK_PROJECT/images/hero5.jpg" alt="Hero 5" />
        <img class="carousel-image absolute w-full h-full object-contain fade hidden" src="/FULLSTACK_PROJECT/images/hero6.avif" alt="Hero 6" />
      </div>

      <!-- Sale Tag -->
      <div class="absolute top-4 right-4 md:top-1 md:right-15 bg-white text-[#3B8A9C] rounded-full w-28 h-28 flex items-center justify-center z-10">
        <span class="text-2xl font-bold">SALE 50%</span>
      </div>
    </div>
  </div>
</section>

<br><br>
<!-- 4 Column Section (MEN WOMEN KIDS ACCESSORIES) -->
<section class="flex flex-col md:flex-row justify-center items-stretch gap-4 px-4 mt-20">
  <a href="/FULLSTACK_PROJECT/shop/men.php" class="w-full md:w-1/4">
    <div class="bg-[#3B8A9C] h-full p-6 text-center rounded-lg shadow-md hover:scale-105 transition cursor-pointer">
      <h2 class="text-2xl font-semibold mb-2 text-white">MEN</h2>
      <p class="text-white">Trendy styles for every man out there. Check out our newest arrivals.</p>
      <img src="../images/mens.jpg" alt="mens" class="mt-4 mx-auto">
    </div>
  </a>

  <a href="/FULLSTACK_PROJECT/shop/women.php" class="w-full md:w-1/4">
    <div class="bg-[#3B8A9C] h-full p-6 text-center rounded-lg shadow-md hover:scale-105 transition cursor-pointer">
      <h2 class="text-2xl font-semibold mb-2 text-white">WOMEN</h2>
      <p class="text-white">Fashion-forward picks to keep you glowing. Discover now.</p>
      <img src="../images/womens.avif" alt="womens" class="mt-4 mx-auto">
    </div>
  </a>

  <a href="/FULLSTACK_PROJECT/shop/kids.php" class="w-full md:w-1/4">
    <div class="bg-[#3B8A9C] h-full p-6 text-center rounded-lg shadow-md hover:scale-105 transition cursor-pointer">
      <h2 class="text-2xl font-semibold mb-2 text-white">KIDS</h2>
      <p class="text-white">Adorable, durable, and fun outfits for the little ones.</p>
      <img src="../images/kids.jpg" alt="kids" class="mt-4 mx-auto">
    </div>
  </a>

  <a href="/FULLSTACK_PROJECT/shop/accessories.php" class="w-full md:w-1/4">
    <div class="bg-[#3B8A9C] h-full p-6 text-center rounded-lg shadow-md hover:scale-105 transition cursor-pointer">
      <h2 class="text-2xl font-semibold mb-2 text-white">ACCESSORIES</h2>
      <p class="text-white">Complete your vibe with the latest accessories.</p>
      <img src="../images/acc.png" alt="acc" class="mt-4 mx-auto">
    </div>
  </a>
</section>

<br><br>

<!-- Footer -->
<footer class="bg-gray-900 text-white pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-gray-500 to-[#3B8A9C] flex items-center justify-center">
                        <span class="text-white font-bold text-xl">FS</span>
                    </div>
                    <span class="text-xl font-bold">Fashion Store</span>
                </div>
                <p class="text-gray-400 mb-4">Your one-stop shop for the latest fashion trends and accessories.</p>
                <div class="flex space-x-4">
                    <a href="https://facebook.com" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://instagram.com" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://pinterest.com" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-3">
                    <li><a href="/FULLSTACK_PROJECT/homepage/homepage1.php" class="text-gray-400 hover:text-white transition">Home</a></li>
                    <li><a href="/FULLSTACK_PROJECT/shop/shop.php" class="text-gray-400 hover:text-white transition">Shop</a></li>
                    <li><a href="/FULLSTACK_PROJECT/about.php" class="text-gray-400 hover:text-white transition">About Us</a></li>
                    <li><a href="/FULLSTACK_PROJECT/contactus/contact.php" class="text-gray-400 hover:text-white transition">Contact</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold mb-4">Customer Service</h3>
                <ul class="space-y-3">
                    <li><a href="/FULLSTACK_PROJECT/auth/terms-and-privacy.html" class="text-gray-400 hover:text-white transition">Shipping Policy</a></li>
                    <li><a href="/FULLSTACK_PROJECT/auth/terms-and-privacy.html" class="text-gray-400 hover:text-white transition">Returns & Refunds</a></li>
                    <li><a href="/FULLSTACK_PROJECT/cart/cart.php" class="text-gray-400 hover:text-white transition">Payment Methods</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                <ul class="space-y-3 text-gray-400">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                        <span>123 Fashion Street, Style City, 10001</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3"></i>
                        <span>fashionstore@help.com</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone mr-3"></i>
                        <span>+91 8008567896</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm mb-4 md:mb-0">© 2023 ModaVibe. All rights reserved.</p>
            <div class="flex space-x-6">
                <a href="/FULLSTACK_PROJECT/privacy-policy.php" class="text-gray-400 hover:text-white text-sm transition">Privacy Policy</a>
                <a href="/FULLSTACK_PROJECT/terms-of-service.php" class="text-gray-400 hover:text-white text-sm transition">Terms of Service</a>
                <a href="/FULLSTACK_PROJECT/cookies-policy.php" class="text-gray-400 hover:text-white text-sm transition">Cookies Policy</a>
            </div>
        </div>
    </div>
</footer>

<!-- JavaScript for Image Carousel and Autotyper -->
<script>
  // Autotyper Effect
  const text = "Make Style at Fashion Store!";
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

  // Carousel Effect
  let slideIndex = 0;
  const slides = document.querySelectorAll(".carousel-image");

  function showSlide() {
    slides.forEach((img) => {
      img.classList.add("hidden");
    });
    slides[slideIndex].classList.remove("hidden");
    slides[slideIndex].classList.add("fade");

    slideIndex = (slideIndex + 1) % slides.length;
  }

  setInterval(showSlide, 3000);

  // Category Navigation
  function navigateCategory(select) {
    const value = select.value;
    switch (value) {
      case "mens":
        window.location.href = "/FULLSTACK_PROJECT/shop/men.php";
        break;
      case "womens":
        window.location.href = "/FULLSTACK_PROJECT/shop/women.php";
        break;
      case "kids":
        window.location.href = "/FULLSTACK_PROJECT/shop/kids.php";
        break;
      case "accessories":
        window.location.href = "/FULLSTACK_PROJECT/shop/accessories.php";
        break;
      case "all":
        window.location.href = "/FULLSTACK_PROJECT/shop/shop.php";
        break;
    }
  }

  function showLoginAlert(type) {
    Swal.fire({
        title: 'Login Required',
        text: `Please log in to view your ${type}.`,
        icon: 'warning',
        confirmButtonColor: '#3B8A9C'
    }).then(() => {
        window.location.href = '/FULLSTACK_PROJECT/auth/login.html';
    });
}
</script>

</body>
</html>