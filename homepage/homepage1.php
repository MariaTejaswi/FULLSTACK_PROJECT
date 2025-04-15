<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Fashion Store</title>
  <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter&family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
  <style>
    .fade {
      animation: fadeEffect 1s ease-in-out;
    }
    @keyframes fadeEffect {
      from { opacity: 0.4; }
      to { opacity: 1; }
    }
  </style>
</head>
<body class="h-screen bg-white">

<!-- Navigation Bar -->
<nav class="top-0 left-0 w-full bg-transparent shadow-md text-black flex items-center justify-between px-6 py-2">
  <img src="../images/fashionStore.jpg" alt="logo" class="w-20 mr-5 h-auto rounded-xl" />
  <div class="w-full flex justify-between items-center">
    <div class="flex space-x-20">
      <a href="index.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded">HOME</a>
      <a href="shop.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded">ACCESSORIES</a>
      <a href="collection.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded">CART</a>
    </div>

    <img src="../images/crown.png" alt="crown" class="ml-60 block w-26 h-auto" />

    <div class="flex ml-35 space-x-2 w-full">
      <select class="border border-black rounded px-2 py-1">
        <option value="all">All Categories</option>
        <option value="mens">Men's</option>
        <option value="womens">Women's</option>
        <option value="kids">Kids</option>
        <option value="accessories">Accessories</option>
      </select>
      <input type="text" placeholder="What do you need?" class="border border-black rounded px-2 py-1 w-full md:w-60" />
      <button class="bg-[#3B8A9C] text-white px-4 py-1 rounded"><i class="fas fa-search"></i></button>
    </div>

    <div class="flex flex-end space-x-2">
      <a href="wishlist.php" class="px-3 py-2 block hover:bg-[#3B8A9C] hover:text-white rounded">CONTACT</a>
    </div>

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

<div class="text-black font-light text-center text-4xl mt-4" style="font-family: 'Playfair Display', sans-serif;">Fashion Store</div>

<!-- Hero Section -->
<section class="bg-[#3B8A9C] min-h-[900px] py-24 mt-10">
  <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center px-4 space-y-8 md:space-y-0">
    <!-- Text Section -->
    <div class="w-full md:w-1/2 text-center md:text-left">
      <h2 class="text-4xl text-black md:text-5xl font-bold mt-2">Black Friday</h2>
      <p class="text-black mt-4">
        Discover the latest trends this Black Friday! <br class="hidden md:block" />
        Unbeatable deals on stylish clothing for the whole family.
      </p>
      <button class="bg-white text-black px-6 py-2 mt-6 rounded hover:scale-105">SHOP NOW</button>
    </div>

    <!-- Image Carousel Section -->
    <div class="w-full md:w-1/2 relative">
      <div class="relative w-full h-[700px] rounded overflow-hidden shadow-2xl shadow-black flex items-center justify-center">
        <img class="carousel-image absolute w-full h-full object-contain fade" src="/FULLSTACK_PROJECT/images/Hero_img.jpg" alt="Hero 1" />
        <img class="carousel-image absolute w-full h-full object-contain fade hidden" src="/FULLSTACK_PROJECT/images/kids.jpg" alt="Hero 2" />
        <img class="carousel-image absolute w-full h-full object-contain fade hidden" src="/FULLSTACK_PROJECT/images/mens.jpg" alt="Hero 3" />
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
  <div class="bg-[#3B8A9C] w-full md:w-1/4 p-6 text-center rounded-lg shadow-md hover:scale-105 transition">
    <h2 class="text-2xl font-semibold mb-2 text-white">MEN</h2>
    <p class="text-white">Trendy styles for every man out there. Check out our newest arrivals.</p>
    <img src="../images/mens.jpg" alt="mens">
  </div>
  <div class="bg-[#3B8A9C] w-full md:w-1/4 p-6 text-center rounded-lg shadow-md hover:scale-105 transition">
    <h2 class="text-2xl font-semibold mb-2 text-white">WOMEN</h2>
    <p class="text-white">Fashion-forward picks to keep you glowing. Discover now.</p><br>
    <img src="../images/womens.avif" alt="womens">
  </div>
  <div class="bg-[#3B8A9C] w-full md:w-1/4 p-6 text-center rounded-lg shadow-md hover:scale-105 transition">
    <h2 class="text-2xl font-semibold mb-2 text-white">KIDS</h2>
    <p class="text-white">Adorable, durable, and fun outfits for the little ones.</p><br>
    <img src="../images/kids.jpg" alt="kids">
  </div>
  <div class="bg-[#3B8A9C] w-full md:w-1/4 p-6 text-center rounded-lg shadow-md hover:scale-105 transition">
    <h2 class="text-2xl font-semibold mb-2 text-white">ACCESSORIES</h2>
    <p class="text-white">Complete your vibe with the latest accessories.</p><br>
    <img src="../images/acc.png" alt="acc">
  </div>
</section>
<br><br>


<!-- JavaScript for Image Carousel -->
<script>
  let index = 0;
  const slides = document.querySelectorAll(".carousel-image");

  function showSlide() {
    slides.forEach((img, i) => {
      img.classList.add("hidden");
    });
    slides[index].classList.remove("hidden");
    slides[index].classList.add("fade");

    index = (index + 1) % slides.length;
  }

  setInterval(showSlide, 3000);
</script>

</body>
</html>
