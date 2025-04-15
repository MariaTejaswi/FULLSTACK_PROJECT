<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin=""/>
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
        
        /* This is needed for the map to display - can't be replaced with Tailwind classes */
        #map {
            height: 300px;
            width: 100%;
            border-radius: 0.5rem;
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

    <!-- Contact Info Section with Map -->
    <section class="max-w-4xl mx-auto pb-12 bg-white p-8 rounded-lg shadow-md relative z-10">
        <div class="flex flex-col md:flex-row gap-5">
            <div class="w-full md:w-2/5">
                <p class="text-gray-700 mb-4">📍 Address: 123 Fashion Street, Mumbai, MH 400001</p>
                <p class="text-gray-700 mb-4">📞 Phone: +91 98765 43210</p>
                <p class="text-gray-700 mb-4">✉️ Email: support@fashionstore.com</p>
                <p class="text-gray-700">⏰ Working Hours: Mon - Fri (10AM - 6PM)</p>
            </div>
            
            <div class="w-full md:w-3/5 h-[300px] rounded-lg overflow-hidden">
                <div id="map" class="w-full h-full"></div>
            </div>
        </div>
    </section>

    <script>
        // Wait for the DOM to fully load
        document.addEventListener('DOMContentLoaded', function() {
            // Fade-in animation
            document.getElementById('formCard').classList.add('show');
            
            // Initialize the map
            initMap();
        });
        
        function initMap() {
            try {
                // Make sure the map container exists
                const mapElement = document.getElementById('map');
                if (!mapElement) {
                    console.error("Map element not found");
                    return;
                }
                
                // Initialize map
                const map = L.map('map').setView([18.9538, 72.8311], 16); // Mumbai coordinates
                
                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                
                // Add marker for the store location
                const marker = L.marker([18.9538, 72.8311]).addTo(map);
                
                // Add popup with store info
                marker.bindPopup("<b>Fashion Store</b><br>123 Fashion Street, Mumbai").openPopup();
                
                // Force a map resize after a short delay to handle any rendering issues
                setTimeout(function() {
                    map.invalidateSize();
                }, 100);
                
                console.log("Map initialized successfully");
            } catch (error) {
                console.error("Error initializing map:", error);
            }
        }
    </script>
    
    <!-- Make sure Leaflet JS is loaded -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
            crossorigin=""></script>
</body>
</html>
