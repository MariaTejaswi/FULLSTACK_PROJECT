<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Fashion Store</title>
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <link rel="stylesheet" href="../src/output.css">
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
    #auto-type-text::after {
      content: "|";
      animation: blink 0.7s infinite;
    }
    @keyframes blink {
      0% { opacity: 1; }
      50% { opacity: 0; }
      100% { opacity: 1; }
    }
    button:hover {
      animation: pulse 0.5s;
    }
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }
    @media (max-width: 768px) {
      .mobile-flex-col {
        flex-direction: column;
      }
      .mobile-text-center {
        text-align: center;
      }
      .mobile-w-full {
        width: 100%;
      }
      .mobile-mt-4 {
        margin-top: 1rem;
      }
      .mobile-px-2 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
      }
      .mobile-py-1 {
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
      }
      .mobile-space-y-2 > * + * {
        margin-top: 0.5rem;
      }
      .mobile-hidden {
        display: none;
      }
      .mobile-block {
        display: block;
      }
      .mobile-h-auto {
        height: auto;
      }
      .mobile-mx-auto {
        margin-left: auto;
        margin-right: auto;
      }
    }
  </style>
</head>
<body class="h-screen bg-gradient-to-r from-gray-400 to-[#6daab9]">

<!-- Navigation Bar -->
<div class="flex flex-col md:flex-row items-center justify-between px-4 md:px-6 py-2 mobile-space-y-2">
  <!-- Logo on the left -->
  <div class="mobile-w-full mobile-text-center md:w-auto">
    <img src="../images/logo.svg" alt="logo" class="h-16 md:h-20 rounded-xl mobile-mx-auto" />
  </div>

  <!-- Search bar and dropdowns on the right -->
  <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2 mobile-w-full">
    <select class="border border-black rounded px-2 py-1 mobile-w-full md:w-auto" onchange="navigateCategory(this)">
      <option value="all">All Categories</option>
      <option value="mens">Men's</option>
      <option value="womens">Women's</option>
      <option value="kids">Kids</option>
      <option value="accessories">Accessories</option>
    </select>
    <div class="flex mobile-w-full">
      <input type="text" placeholder="What do you need?" class="border border-black rounded px-2 py-1 w-full md:w-60" />
      <button class="bg-[#3B8A9C] text-white px-4 py-1 rounded">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>
</div>

<hr>

<nav class="relative top-0 left-0 w-full bg-transparent shadow-md text-black px-2 md:px-6 py-2">
  <div class="flex flex-col md:flex-row items-center justify-between w-full mobile-space-y-2">
    <!-- Left: Menu Links -->
    <div class="flex flex-wrap justify-center md:flex-nowrap md:space-x-6 z-10 mobile-w-full">
      <a href="/FULLSTACK_PROJECT/homepage/homepage1.php" class="px-2 md:px-3 py-1 md:py-2 block hover:bg-[#3B8A9C] hover:text-white rounded text-sm md:text-base"><i class="fas fa-home mr-1"></i>HOME</a>
      <a href="/FULLSTACK_PROJECT/shop/shop.php" class="px-2 md:px-3 py-1 md:py-2 block hover:bg-[#3B8A9C] hover:text-white rounded text-sm md:text-base"><i class="fas fa-store mr-1"></i>SHOP</a>
      <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="#" onclick="showLoginAlert('cart')" class="px-2 md:px-3 py-1 md:py-2 block hover:bg-[#3B8A9C] hover:text-white rounded text-sm md:text-base"><i class="fas fa-shopping-cart mr-1"></i>CART</a>
        <a href="#" onclick="showLoginAlert('wishlist')" class="px-2 md:px-3 py-1 md:py-2 block hover:bg-[#3B8A9C] hover:text-white rounded text-sm md:text-base"><i class="fas fa-heart mr-1"></i>WISHLIST</a>
        <a href="#" onclick="showLoginAlert('orders')" class="px-2 md:px-3 py-1 md:py-2 block hover:bg-[#3B8A9C] hover:text-white rounded text-sm md:text-base"><i class="fas fa-box mr-1"></i>ORDERS</a>
        <script>
          function showLoginAlert() {
            Swal.fire({
              title: 'Login Required',
              text: 'Please log in to view this page.',
              icon: 'warning',
              confirmButtonColor: '#3B8A9C'
            }).then(() => {
              window.location.href = '/FULLSTACK_PROJECT/auth/login.html';
            });
          }
        </script>
      <?php else: ?>
        <a href="/FULLSTACK_PROJECT/cart/cart.php" class="px-2 md:px-3 py-1 md:py-2 block hover:bg-[#3B8A9C] hover:text-white rounded text-sm md:text-base"><i class="fas fa-shopping-cart mr-1"></i>CART</a>
        <a href="/FULLSTACK_PROJECT/wishlist/wishlist.php" class="px-2 md:px-3 py-1 md:py-2 block hover:bg-[#3B8A9C] hover:text-white rounded text-sm md:text-base"><i class="fas fa-heart mr-1"></i>WISHLIST</a>
        <a href="/FULLSTACK_PROJECT/order/order.php" class="px-2 md:px-3 py-1 md:py-2 block hover:bg-[#3B8A9C] hover:text-white rounded text-sm md:text-base"><i class="fas fa-box mr-1"></i>ORDERS</a>
      <?php endif; ?>
    </div>

    <!-- Right: Contact & Auth -->
    <div class="flex items-center space-x-2 md:space-x-4 z-10 mobile-mt-2 md:mt-0">
      <a href="/FULLSTACK_PROJECT/contactus/contact.php" class="px-2 md:px-3 py-1 md:py-2 block hover:bg-[#3B8A9C] hover:text-white rounded text-sm md:text-base"><i class="fas fa-envelope mr-1"></i>CONTACT</a>
      <div class="flex items-center space-x-2">
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="../profile/profile.php" class="px-2 md:px-3 py-1 md:py-2 text-white rounded-full border-[#3B8A9C] border-2 hover:bg-[#3B8A9C] transition text-sm md:text-base"><i class="fas fa-user"></i></a>
          <a href="logout.php" class="px-2 md:px-3 py-1 md:py-2 bg-[#3B8A9C] text-white rounded hover:bg-[#337685] whitespace-nowrap text-sm md:text-base">LOGOUT</a>
        <?php else: ?>
          <a href="/FULLSTACK_PROJECT/auth/login.html" class="px-2 md:px-3 py-1 md:py-2 bg-[#3B8A9C] text-white rounded hover:bg-[#337685] whitespace-nowrap text-sm md:text-base">LOGIN/SIGNUP</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Center: Crown image, absolutely centered -->
    <div class="absolute left-1/2 transform -translate-x-1/2 hidden [@media(min-width:1500px)]:block">
      <img src="../images/1bg.svg" alt="crown" class="w-16 md:w-24 h-auto" />
    </div>
  </div>
</nav>

<hr>

<!-- Hero Section -->
<section class="bg-[#3B8A9C] min-h-[600px] md:min-h-[900px] py-12 md:py-24">
  <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center space-y-8 md:space-y-0 px-4">
    <!-- Text Section -->
    <div class="w-full md:w-1/2 text-center md:text-left mobile-px-2">
      <h1 id="auto-type-text" class="text-2xl md:text-5xl font-semibold text-center md:text-left text-white"></h1>
      <p class="text-white mt-2 md:mt-4 text-sm md:text-base">
        Dive into the Hottest Black Friday Fashion Frenzy! <br class="hidden md:block" />
        Irresistible Deals on Trendsetting Looks for Everyone.
      </p>
      <a href="/FULLSTACK_PROJECT/shop/shop.php">
        <button class="bg-white text-[#3B8A9C] font-bold px-4 md:px-6 py-1 md:py-2 mt-4 md:mt-6 rounded hover:scale-105 text-sm md:text-base">GRAB YOUR FAVES NOW!</button>
      </a>
    </div>

    <!-- Image Carousel Section -->
    <div class="w-full md:w-1/2 relative mt-8 md:mt-0">
      <div class="relative w-full h-[300px] md:h-[700px] rounded overflow-hidden shadow-2xl shadow-black flex items-center justify-center">
        <img class="carousel-image absolute w-full h-full object-contain fade" src="/FULLSTACK_PROJECT/images/Hero_img.jpg" alt="Hero 1" />
        <img class="carousel-image absolute w-full h-full object-contain fade hidden" src="/FULLSTACK_PROJECT/images/hero2.avif" alt="Hero 2" />
        <img class="carousel-image absolute w-full h-full object-contain fade hidden" src="/FULLSTACK_PROJECT/images/hero3.avif" alt="Hero 3" />
        <img class="carousel-image absolute w-full h-full object-contain fade hidden" src="/FULLSTACK_PROJECT/images/hero4.webp" alt="Hero 4" />
        <img class="carousel-image absolute w-full h-full object-contain fade hidden" src="/FULLSTACK_PROJECT/images/hero5.jpg" alt="Hero 5" />
        <img class="carousel-image absolute w-full h-full object-contain fade hidden" src="/FULLSTACK_PROJECT/images/hero6.avif" alt="Hero 6" />
      </div>

      <!-- Sale Tag -->
      <div class="absolute top-2 md:top-4 right-2 md:right-4 bg-white text-[#3B8A9C] rounded-full w-16 h-16 md:w-28 md:h-28 flex items-center justify-center z-10">
        <span class="text-sm md:text-2xl font-bold">SALE 50%</span>
      </div>
    </div>
  </div>
</section>

<br><br>
<!-- 4 Column Section (MEN WOMEN KIDS ACCESSORIES) -->
<section class="flex flex-col md:flex-row justify-center items-stretch gap-4 px-4 mt-10 md:mt-20">
  <a href="/FULLSTACK_PROJECT/shop/men.php" class="w-full md:w-1/4">
    <div class="bg-[#3B8A9C] h-full p-4 md:p-6 text-center rounded-lg shadow-md hover:scale-105 transition cursor-pointer">
      <h2 class="text-xl md:text-2xl font-semibold mb-2 text-white">MEN</h2>
      <p class="text-white text-sm md:text-base">Trendy styles for every man out there. Check out our newest arrivals.</p>
      <img src="../images/mens.jpg" alt="mens" class="mt-2 md:mt-4 mx-auto h-24 md:h-auto">
    </div>
  </a>

  <a href="/FULLSTACK_PROJECT/shop/women.php" class="w-full md:w-1/4">
    <div class="bg-[#3B8A9C] h-full p-4 md:p-6 text-center rounded-lg shadow-md hover:scale-105 transition cursor-pointer">
      <h2 class="text-xl md:text-2xl font-semibold mb-2 text-white">WOMEN</h2>
      <p class="text-white text-sm md:text-base">Fashion-forward picks to keep you glowing. Discover now.</p>
      <img src="../images/womens.avif" alt="womens" class="mt-2 md:mt-4 mx-auto h-24 md:h-auto">
    </div>
  </a>

  <a href="/FULLSTACK_PROJECT/shop/kids.php" class="w-full md:w-1/4">
    <div class="bg-[#3B8A9C] h-full p-4 md:p-6 text-center rounded-lg shadow-md hover:scale-105 transition cursor-pointer">
      <h2 class="text-xl md:text-2xl font-semibold mb-2 text-white">KIDS</h2>
      <p class="text-white text-sm md:text-base">Adorable, durable, and fun outfits for the little ones.</p>
      <img src="../images/kids.jpg" alt="kids" class="mt-2 md:mt-4 mx-auto h-24 md:h-auto">
    </div>
  </a>

  <a href="/FULLSTACK_PROJECT/shop/accessories.php" class="w-full md:w-1/4">
    <div class="bg-[#3B8A9C] h-full p-4 md:p-6 text-center rounded-lg shadow-md hover:scale-105 transition cursor-pointer">
      <h2 class="text-xl md:text-2xl font-semibold mb-2 text-white">ACCESSORIES</h2>
      <p class="text-white text-sm md:text-base">Complete your vibe with the latest accessories.</p>
      <img src="../images/acc.png" alt="acc" class="mt-2 md:mt-4 mx-auto h-24 md:h-auto">
    </div>
  </a>
</section>

<br><br>

<!-- Footer -->
<footer class="bg-gray-900 text-white pt-8 md:pt-16 pb-6 md:pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-12">
            <div class="mobile-text-center md:text-left">
                <div class="flex items-center space-x-2 mb-4 mobile-justify-center md:justify-start">
                    <div class="w-8 md:w-10 h-8 md:h-10 rounded-lg bg-gradient-to-r from-gray-500 to-[#3B8A9C] flex items-center justify-center">
                        <span class="text-white font-bold text-lg md:text-xl">FS</span>
                    </div>
                    <span class="text-lg md:text-xl font-bold">Fashion Store</span>
                </div>
                <p class="text-gray-400 mb-4 text-sm md:text-base">Your one-stop shop for the latest fashion trends and accessories.</p>
                <div class="flex space-x-4 mobile-justify-center md:justify-start">
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
            
            <div class="mobile-text-center md:text-left">
                <h3 class="text-base md:text-lg font-semibold mb-3 md:mb-4">Quick Links</h3>
                <ul class="space-y-2 md:space-y-3">
                    <li><a href="/FULLSTACK_PROJECT/homepage/homepage1.php" class="text-gray-400 hover:text-white transition text-sm md:text-base">Home</a></li>
                    <li><a href="/FULLSTACK_PROJECT/shop/shop.php" class="text-gray-400 hover:text-white transition text-sm md:text-base">Shop</a></li>
                    <li><a href="/FULLSTACK_PROJECT/about.php" class="text-gray-400 hover:text-white transition text-sm md:text-base">About Us</a></li>
                    <li><a href="/FULLSTACK_PROJECT/contactus/contact.php" class="text-gray-400 hover:text-white transition text-sm md:text-base">Contact</a></li>
                </ul>
            </div>
            
            <div class="mobile-text-center md:text-left">
                <h3 class="text-base md:text-lg font-semibold mb-3 md:mb-4">Customer Service</h3>
                <ul class="space-y-2 md:space-y-3">
                    <li><a href="/FULLSTACK_PROJECT/auth/terms-and-privacy.html" class="text-gray-400 hover:text-white transition text-sm md:text-base">Shipping Policy</a></li>
                    <li><a href="/FULLSTACK_PROJECT/auth/terms-and-privacy.html" class="text-gray-400 hover:text-white transition text-sm md:text-base">Returns & Refunds</a></li>
                    <li><a href="/FULLSTACK_PROJECT/cart/cart.php" class="text-gray-400 hover:text-white transition text-sm md:text-base">Payment Methods</a></li>
                </ul>
            </div>
            
            <div class="mobile-text-center md:text-left">
                <h3 class="text-base md:text-lg font-semibold mb-3 md:mb-4">Contact Us</h3>
                <ul class="space-y-2 md:space-y-3 text-gray-400">
                    <li class="flex items-start mobile-justify-center md:justify-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-2 md:mr-3"></i>
                        <span class="text-sm md:text-base">123 Fashion Street, Style City, 10001</span>
                    </li>
                    <li class="flex items-center mobile-justify-center md:justify-start">
                        <i class="fas fa-envelope mr-2 md:mr-3"></i>
                        <span class="text-sm md:text-base">fashionstore@help.com</span>
                    </li>
                    <li class="flex items-center mobile-justify-center md:justify-start">
                        <i class="fas fa-phone mr-2 md:mr-3"></i>
                        <span class="text-sm md:text-base">+91 8008567896</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 md:mt-12 pt-6 md:pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-xs md:text-sm mb-3 md:mb-0">© 2023 ModaVibe. All rights reserved.</p>
            <div class="flex space-x-4 md:space-x-6">
                <a href="/FULLSTACK_PROJECT/privacy-policy.php" class="text-gray-400 hover:text-white text-xs md:text-sm transition">Privacy Policy</a>
                <a href="/FULLSTACK_PROJECT/terms-of-service.php" class="text-gray-400 hover:text-white text-xs md:text-sm transition">Terms of Service</a>
                <a href="/FULLSTACK_PROJECT/cookies-policy.php" class="text-gray-400 hover:text-white text-xs md:text-sm transition">Cookies Policy</a>
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