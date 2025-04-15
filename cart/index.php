<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ModaVibe | Fashion Store</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(45deg, #3B8A9C, #E74C3C);
        }
        
        .card-hover-effect {
            transition: all 0.3s ease;
            transform: perspective(1000px) rotateX(0deg);
        }
        
        .card-hover-effect:hover {
            transform: perspective(1000px) rotateX(5deg);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        .mobile-menu.open {
            max-height: 500px;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 backdrop-blur-sm bg-opacity-90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-600 to-red-500 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">MV</span>
                        </div>
                        <span class="text-xl font-bold text-gray-800 hidden sm:block">ModaVibe</span>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium relative group">
                        Home
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="shop.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium relative group">
                        Shop
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="collection.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium relative group">
                        Collection
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="contact.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium relative group">
                        Contact
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>

                <!-- Icons -->
                <div class="flex items-center space-x-6">
                    <div class="hidden md:flex items-center space-x-4">
                        <button class="text-gray-600 hover:text-blue-600 transition">
                            <i class="fas fa-search text-lg"></i>
                        </button>
                        <button class="text-gray-600 hover:text-blue-600 transition">
                            <i class="fas fa-heart text-lg"></i>
                        </button>
                        <button class="text-gray-600 hover:text-blue-600 transition relative">
                            <i class="fas fa-shopping-bag text-lg"></i>
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                        </button>
                    </div>

                    <!-- Auth Button -->
                    <a href="login.php" class="bg-gradient-to-r from-blue-600 to-red-500 hover:from-blue-600-dark hover:to-red-500-dark text-white px-4 py-2 rounded-full text-sm font-medium transition-all transform hover:scale-105 shadow-md">
                        Login
                    </a>

                    <!-- Mobile menu button -->
                    <button id="mobile-menu-button" class="md:hidden text-gray-600 hover:text-blue-600 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu md:hidden bg-white px-4">
            <div class="py-4 space-y-4">
                <a href="index.php" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Home</a>
                <a href="shop.php" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Shop</a>
                <a href="collection.php" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Collection</a>
                <a href="contact.php" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Contact</a>
                <div class="pt-4 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-600 hover:text-blue-600 transition">
                            <i class="fas fa-search text-lg"></i>
                        </button>
                        <button class="text-gray-600 hover:text-blue-600 transition">
                            <i class="fas fa-heart text-lg"></i>
                        </button>
                        <button class="text-gray-600 hover:text-blue-600 transition relative">
                            <i class="fas fa-shopping-bag text-lg"></i>
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-gray-800 opacity-90"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white space-y-6 animate-fade-in">
                    <span class="inline-block bg-white text-blue-600 px-4 py-1 rounded-full text-sm font-medium mb-4">New Collection</span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        <span class="gradient-text">Elevate</span> Your Style
                    </h1>
                    <p class="text-lg opacity-90 max-w-lg">Discover the latest trends in fashion with our exclusive collection. Quality materials, perfect fit, and unbeatable prices.</p>
                    <div class="flex space-x-4">
                        <button class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-full font-medium transition-all transform hover:scale-105 shadow-lg">
                            Shop Now
                        </button>
                        <button class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-6 py-3 rounded-full font-medium transition-all transform hover:scale-105">
                            Explore
                        </button>
                    </div>
                </div>
                <div class="relative animate-fade-in delay-200">
                    <div class="relative animate-float">
                        <img src="https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="Fashion Model" 
                             class="rounded-2xl shadow-2xl w-full h-auto max-h-[500px] object-cover">
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-red-500 text-white rounded-full w-28 h-28 flex items-center justify-center shadow-xl animate-fade-in delay-300">
                        <div class="text-center">
                            <span class="block text-2xl font-bold">50%</span>
                            <span class="block text-xs uppercase">OFF</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-16">
            <span class="inline-block text-blue-600 font-medium mb-2 animate-fade-in">Categories</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 animate-fade-in delay-100">Shop by Style</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mt-4 animate-fade-in delay-200">Find your perfect look from our carefully curated collections</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Men's -->
            <div class="group relative overflow-hidden rounded-2xl shadow-md card-hover-effect animate-fade-in delay-200">
                <div class="relative h-80 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1527719327859-c6ce80353573?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                         alt="Men's Fashion" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent flex items-end p-6">
                        <div>
                            <h3 class="text-white text-xl font-bold mb-1">Men's</h3>
                            <button class="text-white text-sm font-medium hover:underline">Shop Now →</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Women's -->
            <div class="group relative overflow-hidden rounded-2xl shadow-md card-hover-effect animate-fade-in delay-300">
                <div class="relative h-80 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1551232864-3f0890e580d9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" 
                         alt="Women's Fashion" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent flex items-end p-6">
                        <div>
                            <h3 class="text-white text-xl font-bold mb-1">Women's</h3>
                            <button class="text-white text-sm font-medium hover:underline">Shop Now →</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kids -->
            <div class="group relative overflow-hidden rounded-2xl shadow-md card-hover-effect animate-fade-in delay-400">
                <div class="relative h-80 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1604917019118-2049b1bda302?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                         alt="Kids Fashion" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent flex items-end p-6">
                        <div>
                            <h3 class="text-white text-xl font-bold mb-1">Kids</h3>
                            <button class="text-white text-sm font-medium hover:underline">Shop Now →</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Accessories -->
            <div class="group relative overflow-hidden rounded-2xl shadow-md card-hover-effect animate-fade-in delay-500">
                <div class="relative h-80 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1592155931584-901ac15763e3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                         alt="Accessories" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent flex items-end p-6">
                        <div>
                            <h3 class="text-white text-xl font-bold mb-1">Accessories</h3>
                            <button class="text-white text-sm font-medium hover:underline">Shop Now →</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block text-blue-600 font-medium mb-2">Featured</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Our Best Sellers</h2>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Product 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="Product 1" 
                             class="w-full h-64 object-cover">
                        <div class="absolute top-4 right-4">
                            <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition">
                                <i class="far fa-heart text-gray-600"></i>
                            </button>
                        </div>
                        <div class="absolute bottom-0 left-0 bg-blue-600 text-white text-xs font-bold px-2 py-1">
                            NEW
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Classic Denim Jacket</h3>
                        <div class="flex items-center mb-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-gray-500 text-sm ml-2">(42 reviews)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">$89.99</span>
                            <button class="bg-blue-600 hover:bg-blue-600-dark text-white px-3 py-1 rounded-full text-sm transition">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                             alt="Product 2" 
                             class="w-full h-64 object-cover">
                        <div class="absolute top-4 right-4">
                            <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition">
                                <i class="far fa-heart text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Summer Floral Dress</h3>
                        <div class="flex items-center mb-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="text-gray-500 text-sm ml-2">(36 reviews)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">$59.99</span>
                            <button class="bg-blue-600 hover:bg-blue-600-dark text-white px-3 py-1 rounded-full text-sm transition">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1591047139829-d91aecb1c4f5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1476&q=80" 
                             alt="Product 3" 
                             class="w-full h-64 object-cover">
                        <div class="absolute top-4 right-4">
                            <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition">
                                <i class="far fa-heart text-gray-600"></i>
                            </button>
                        </div>
                        <div class="absolute bottom-0 left-0 bg-red-500 text-white text-xs font-bold px-2 py-1">
                            SALE
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Leather Crossbody Bag</h3>
                        <div class="flex items-center mb-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-gray-500 text-sm ml-2">(58 reviews)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-lg font-bold text-gray-900">$49.99</span>
                                <span class="text-sm text-gray-500 line-through ml-2">$69.99</span>
                            </div>
                            <button class="bg-blue-600 hover:bg-blue-600-dark text-white px-3 py-1 rounded-full text-sm transition">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product 4 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1526&q=80" 
                             alt="Product 4" 
                             class="w-full h-64 object-cover">
                        <div class="absolute top-4 right-4">
                            <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition">
                                <i class="far fa-heart text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Casual Sneakers</h3>
                        <div class="flex items-center mb-2">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-gray-500 text-sm ml-2">(47 reviews)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">$79.99</span>
                            <button class="bg-blue-600 hover:bg-blue-600-dark text-white px-3 py-1 rounded-full text-sm transition">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <button class="border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-8 py-3 rounded-full font-medium transition-all transform hover:scale-105">
                    View All Products
                </button>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="bg-gradient-to-r from-blue-600 to-gray-800 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Join Our Newsletter</h2>
            <p class="text-white opacity-90 mb-8 max-w-2xl mx-auto">Subscribe to get updates on new arrivals, special offers and other discount information.</p>
            
            <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto sm:max-w-xl">
                <input type="email" placeholder="Your email address" class="flex-grow px-4 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-white">
                <button class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-full font-medium transition-all transform hover:scale-105 shadow-lg whitespace-nowrap">
                    Subscribe Now
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-600 to-red-500 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">MV</span>
                        </div>
                        <span class="text-xl font-bold">ModaVibe</span>
                    </div>
                    <p class="text-gray-400 mb-4">Your one-stop shop for the latest fashion trends and accessories.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Shop</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Customer Service</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">FAQs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Shipping Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Returns & Refunds</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Size Guide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Payment Methods</a></li>
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
                            <span>hello@modavibe.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3"></i>
                            <span>+1 (555) 123-4567</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">&copy; 2023 ModaVibe. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition">Cookies Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('open');
            });
            
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                        
                        // Close mobile menu if open
                        if (mobileMenu.classList.contains('open')) {
                            mobileMenu.classList.remove('open');
                        }
                    }
                });
            });
            
            // Add animation classes as elements come into view
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.animate-fade-in');
                
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;
                    
                    if (elementPosition < windowHeight - 100) {
                        element.style.opacity = '1';
                    }
                });
            };
            
            // Run once on load
            animateOnScroll();
            
            // Then run on scroll
            window.addEventListener('scroll', animateOnScroll);
        });
    </script>
</body>
</html>