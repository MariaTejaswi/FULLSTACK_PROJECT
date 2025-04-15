<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.7s ease-in-out;
        }
        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-white relative min-h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-[url('/FULLSTACK_PROJECT/images/contactus.png')] bg-cover bg-center opacity-75 z-0"></div>

    <!-- Navigation Bar -->
    <nav class="w-full bg-[#3B8A9C] flex items-center justify-between h-20 px-3 md:px-20 border-b-2 shadow-md top-0 left-0 right-0 z-10 relative">
        <!-- Left Side: Logo & Name -->
        <div class="flex items-center gap-3">
            <img src="../images/fashionStore.jpg" alt="logo" class="w-20 h-20 rounded-4xl">
            <h2 class="font-serif text-3xl md:text-5xl">Fashion Store</h2>
        </div>

        <!-- Right Side: Sign Up Button -->
        <div class="flex gap-4 md:gap-6 justify-center mt-2">
            <a href="/FULLSTACK_PROJECT/auth/signup.html">
                <button class="bg-white hover:bg-gray-400 hover:text-white text-[#3B8A9C] font-serif border-2 rounded-2xl h-10 px-4 md:h-12 md:px-5 hover:cursor-pointer">
                    Log In
                </button>
            </a>
            <a href="/FULLSTACK_PROJECT/homepage/homepage1.php">
                <button class="bg-white hover:bg-gray-400 hover:text-white text-[#3B8A9C] font-serif border-2 rounded-2xl h-10 px-4 md:h-12 md:px-5 hover:cursor-pointer">
                    Home
                </button>
            </a>
        </div>
    </nav>

    <!-- Contact Form Section -->
    <div class="flex items-center justify-center py-12 relative z-10">
        <div id="formCard" class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md fade-in scale-95">
            <h2 class="text-3xl font-bold mb-6 text-[#3B8A9C] text-center animate-bounce">Contact Us</h2>
            <form action="submit_contact.php" method="POST" class="space-y-5">
                <input type="text" name="name" placeholder="Your Name" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3B8A9C] transition-all duration-300 hover:shadow-md" />

                <input type="email" name="email" placeholder="Your Email" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3B8A9C] transition-all duration-300 hover:shadow-md" />

                <select name="type" required 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3B8A9C] transition-all duration-300 hover:shadow-md">
                    <option value="">-- Select Query Type --</option>
                    <option value="Order Related">Order Related</option>
                    <option value="Product Info">Product Info</option>
                    <option value="Return/Exchange">Return/Exchange</option>
                    <option value="Other">Other</option>
                </select>

                <textarea name="message" rows="5" placeholder="Type your query here..." required 
                          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3B8A9C] transition-all duration-300 hover:shadow-md"></textarea>

                <button type="submit" 
                        class="w-full bg-[#3B8A9C] text-white py-3 rounded-lg hover:bg-[#337685] transition-all duration-300 transform hover:scale-105">Send Message</button>
            </form>
        </div>
    </div>

    <!-- Contact Info Section -->
    <section class="max-w-4xl mx-auto pb-12 bg-white p-8 rounded-lg shadow-md relative z-10">
        <p class="text-gray-700 mb-4">📍 Address: 123 Fashion Street, Mumbai, MH 400001</p>
        <p class="text-gray-700 mb-4">📞 Phone: +91 98765 43210</p>
        <p class="text-gray-700 mb-4">✉️ Email: support@fashionstore.com</p>
        <p class="text-gray-700">⏰ Working Hours: Mon - Fri (10AM - 6PM)</p>
    </section>

    <script>
        // Fade-in animation on page load
        window.addEventListener('DOMContentLoaded', () => {
            document.getElementById('formCard').classList.add('show');
        });
    </script>
</body>
</html>