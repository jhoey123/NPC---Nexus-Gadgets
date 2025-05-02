<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"="width=device-width, initial-scale=1.0">
    <title>NEXUS Gadget - Premium Computer Parts & Electronics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        @font-face {
            font-family: 'SuperDario';
            src: url('uploads/Valorax-lg25V.otf') format('truetype'); /* Update the path to your font file */
        }

        .superdario-font {
            font-family: 'SuperDario', sans-serif;
        }

        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0c4a6e 100%);
            background-attachment: fixed;
            background-size: 200% 200%;
            animation: gradientBG 15s ease infinite;
            color: #ffffff;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, rgba(110, 142, 251, 0.8) 0%, rgba(167, 119, 227, 0.8) 100%);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .category-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            background: rgba(30, 41, 59, 0.7);
        }
        
        .product-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            background: rgba(30, 41, 59, 0.7);
        }
        
        .newsletter-gradient {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.7) 0%, rgba(30, 41, 59, 0.7) 100%);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .scroll-hidden::-webkit-scrollbar {
            display: none;
        }
        
        .scroll-hidden {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        .marquee {
            animation: marquee 20s linear infinite;
        }
        
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        /* Modal styles */
        .modal {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .modal-content {
            transform: translateY(-20px);
            transition: transform 0.3s ease;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .modal.active {
            opacity: 1;
            visibility: visible;
        }
        
        .modal.active .modal-content {
            transform: translateY(0);
        }
        
        .input-field {
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .input-field:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            background: rgba(30, 41, 59, 0.7);
        }
        
        .tab-button {
            transition: all 0.3s ease;
            background: rgba(30, 41, 59, 0.5);
        }
        
        .tab-button.active {
            background-color: #6366f1;
            color: white;
        }
        
        /* Header styles */
        header {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Footer styles */
        footer {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Featured Brands section */
        .featured-brands {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Deal of the Day */
        .deal-section {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.8) 0%, rgba(99, 102, 241, 0.8) 100%);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        /* Why Choose Us section */
        .feature-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            background: rgba(30, 41, 59, 0.7);
        }
        
        /* Text contrast adjustments */
        .text-gray-800 {
            color: #f8fafc !important;
        }
        
        .text-gray-600 {
            color: #cbd5e1 !important;
        }
        
        .text-gray-500 {
            color: #94a3b8 !important;
        }
        
        .text-gray-400 {
            color: #94a3b8 !important;
        }
        
        /* Form placeholders */
        ::placeholder {
            color: #94a3b8 !important;
        }
        
        /* Back to top button */
        #backToTop {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>
<body class="bg-gray-900">
 

    <!-- Header -->
    <header class="sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="#" class="flex items-center">
                        <img src="images/NEXUS GADGETS.png" alt="NEXUS GADGETS Logo" class="w-24 h-24 mr-6"> <!-- Updated logo -->
                        <span class="text-2xl font-bold text-white superdario-font">NEXUS <span class="text-indigo-400">Gadget</span></span>
                    </a>
                </div>
                
                <!-- Navigation Icons -->
                <div class="flex items-center space-x-4">
                    <a href="#" class="p-2 text-gray-300 hover:text-indigo-400">
                        <i class="fas fa-heart text-lg"></i>
                    </a>
                    <a href="logintab.php" class="login-link p-2 text-gray-300 hover:text-indigo-400">
                        <i class="fas fa-user text-lg"></i>
                    </a>
                    <button class="lg:hidden p-2 text-gray-300 hover:text-indigo-400">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

   
    <!-- Hero Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="hero-gradient flex flex-col lg:flex-row items-center p-8">
                <div class="lg:w-1/2 mb-10 lg:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white">Upgrade Your Tech Experience</h1>
                    <p class="text-xl mb-8 text-indigo-100">Premium computer parts, laptops, and smartphones at unbeatable prices.</p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="logintab.php" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition duration-300 text-center">Shop Now</a>
                        <a href="#" class="border-2 border-white text-white px-6 py-3 rounded-lg font-medium hover:bg-white hover:text-indigo-600 transition duration-300 text-center">Learn More</a>
                    </div>
                </div>
                <div class="lg:w-1/2 flex justify-center">
                    <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1025&q=80" alt="Tech Products" class="rounded-lg shadow-xl max-w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Brands -->
    <section class="featured-brands py-8">
        <div class="container mx-auto px-4">
            <div class="flex justify-center items-center space-x-8 py-4">
                <div class="flex-shrink-0 flex items-center justify-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple" class="h-12 object-contain opacity-70 hover:opacity-100 transition duration-300">
                </div>
                <div class="flex-shrink-0 flex items-center justify-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Micro-Star_International_logo.svg" alt="MSI" class="h-12 object-contain opacity-70 hover:opacity-100 transition duration-300">
                </div>
                <div class="flex-shrink-0 flex items-center justify-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg" alt="Samsung" class="h-12 object-contain opacity-70 hover:opacity-100 transition duration-300">
                </div>
                <div class="flex-shrink-0 flex items-center justify-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/7d/Intel_logo_%282006-2020%29.svg" alt="Intel" class="h-12 object-contain opacity-70 hover:opacity-100 transition duration-300">
                </div>
                <div class="flex-shrink-0 flex items-center justify-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/7c/AMD_Logo.svg" alt="AMD" class="h-12 object-contain opacity-70 hover:opacity-100 transition duration-300">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-white">Shop By Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <a href="#" class="category-card rounded-lg p-6 text-center">
                    <div class="bg-indigo-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-laptop text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-medium text-white">Laptops</h3>
                    <p class="text-sm text-gray-400 mt-1">Premium selection</p>
                </a>
                <a href="#" class="category-card rounded-lg p-6 text-center">
                    <div class="bg-blue-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-mobile-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-medium text-white">Smartphones</h3>
                    <p class="text-sm text-gray-400 mt-1">Latest models</p>
                </a>
                <a href="#" class="category-card rounded-lg p-6 text-center">
                    <div class="bg-purple-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-mouse text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-medium text-white">Mouse</h3>
                    <p class="text-sm text-gray-400 mt-1">Gaming & Office</p>
                </a>
                <a href="#" class="category-card rounded-lg p-6 text-center">
                    <div class="bg-green-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-desktop text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-medium text-white">Monitors</h3>
                    <p class="text-sm text-gray-400 mt-1">High resolution</p>
                </a>
                <a href="#" class="category-card rounded-lg p-6 text-center">
                    <div class="bg-yellow-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-keyboard text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="font-medium text-white">Keyboards</h3>
                    <p class="text-sm text-gray-400 mt-1">Mechanical & more</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-white">Featured Products</h2>
                <a href="#" class="text-indigo-400 font-medium hover:underline">View All</a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Product 1 -->
                <div class="product-card rounded-lg overflow-hidden">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1180&q=80" alt="Gaming Laptop" class="w-full h-48 object-cover">
                        <div class="absolute top-2 right-2 bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">NEW</div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-gray-400 text-xs ml-1">(42)</span>
                        </div>
                        <h3 class="font-medium text-white mb-1">NEXUS Pro Gaming Laptop</h3>
                        <p class="text-gray-400 text-sm mb-3">Intel i9, RTX 3080, 32GB RAM</p>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-white">₱1,799.99</span>
                            <button class="bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700 transition duration-300">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product 2 -->
                <div class="product-card rounded-lg overflow-hidden">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1067&q=80" alt="Smartphone" class="w-full h-48 object-cover">
                        <div class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">-15%</div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="text-gray-400 text-xs ml-1">(28)</span>
                        </div>
                        <h3 class="font-medium text-white mb-1">NEXUS Ultra 5G</h3>
                        <p class="text-gray-400 text-sm mb-3">6.7" AMOLED, 128GB, 5000mAh</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-bold text-white">₱899.99</span>
                                <span class="text-gray-400 text-sm line-through ml-2">₱1,059.99</span>
                            </div>
                            <button class="bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700 transition duration-300">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product 3 -->
                <div class="product-card rounded-lg overflow-hidden">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Keyboard" class="w-full h-48 object-cover">
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-gray-400 text-xs ml-1">(64)</span>
                        </div>
                        <h3 class="font-medium text-white mb-1">NEXUS Laptop</h3>
                        <p class="text-gray-400 text-sm mb-3">24GB GDDR6X, PCIe 4.0</p>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-white">₱1,599.99</span>
                            <button class="bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700 transition duration-300">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product 4 -->
                <div class="product-card rounded-lg overflow-hidden">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1603791440384-56cd371ee9a7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="SSD" class="w-full h-48 object-cover">
                        <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">BESTSELLER</div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mb-1">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-gray-400 text-xs ml-1">(87)</span>
                        </div>
                        <h3 class="font-medium text-white mb-1">Laptops</h3>
                        <p class="text-gray-400 text-sm mb-3">3500MB/s Read, 3000MB/s Write</p>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-white">₱249.99</span>
                            <button class="bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700 transition duration-300">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Deal of the Day -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="deal-section rounded-xl overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <div class="lg:w-1/2 p-8 lg:p-12 text-white">
                        <span class="bg-white text-indigo-600 text-xs font-bold px-3 py-1 rounded-full mb-4 inline-block">DEAL OF THE DAY</span>
                        <h2 class="text-3xl font-bold mb-4">NEXUS Creator Pro Workstation</h2>
                        <p class="text-indigo-100 mb-6">Intel i9-13900K, RTX 4080, 64GB DDR5, 2TB NVMe SSD</p>
                        <div class="flex items-center mb-6">
                            <div class="text-4xl font-bold">₱2,599.99</div>
                            <div class="ml-4">
                                <div class="text-sm line-through">₱3,199.99</div>
                                <div class="text-sm font-bold bg-yellow-400 text-indigo-900 px-2 py-1 rounded mt-1">SAVE ₱600</div>
                            </div>
                        </div>
                        <div class="mb-6">
                            <div class="flex items-center mb-2">
                                <div class="w-full bg-indigo-700 rounded-full h-2.5">
                                    <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 75%"></div>
                                </div>
                                <span class="ml-2 text-sm">75% sold</span>
                            </div>
                            <div class="text-sm">Hurry! Only 12 left at this price</div>
                        </div>
                        <div class="flex space-x-4">
                            <button class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition duration-300 flex items-center">
                                <i class="fas fa-heart mr-2"></i> Add to Wishlist
                            </button>
                            <button class="border-2 border-white text-white px-6 py-3 rounded-lg font-bold hover:bg-white hover:text-indigo-600 transition duration-300">
                                Learn More
                            </button>
                        </div>
                    </div>
                    <div class="lg:w-1/2 flex items-center justify-center p-8">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Deal of the Day" class="rounded-lg shadow-xl max-w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-white">Why Choose NEXUS Gadget</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="feature-card p-6 rounded-lg text-center">
                    <div class="bg-indigo-100 w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">2-Year Warranty</h3>
                    <p class="text-gray-400">All our products come with extended warranty coverage for your peace of mind.</p>
                </div>
                <div class="feature-card p-6 rounded-lg text-center">
                    <div class="bg-blue-100 w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-truck text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">Fast Shipping</h3>
                    <p class="text-gray-400">Get your order delivered within 2-3 business days with our express shipping.</p>
                </div>
                <div class="feature-card p-6 rounded-lg text-center">
                    <div class="bg-green-100 w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-headset text-green-600 text-xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">24/7 Support</h3>
                    <p class="text-gray-400">Our tech experts are available round the clock to assist you with any queries.</p>
                </div>
                <div class="feature-card p-6 rounded-lg text-center">
                    <div class="bg-purple-100 w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-undo text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">Easy Returns</h3>
                    <p class="text-gray-400">Not satisfied? Return within 30 days for a full refund, no questions asked.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="newsletter-gradient rounded-lg p-8">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-3xl font-bold mb-4 text-white">Stay Updated</h2>
                    <p class="text-lg mb-8 text-gray-300">Subscribe to our newsletter for exclusive deals, new arrivals, and tech tips.</p>
                    <div class="flex flex-col sm:flex-row justify-center max-w-md mx-auto">
                        <input type="email" placeholder="Your email address" class="px-4 py-3 rounded-l-lg sm:rounded-r-none rounded-r-lg sm:rounded-l-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full mb-2 sm:mb-0 bg-gray-800 text-white">
                        <button class="bg-indigo-600 text-white px-6 py-3 rounded-r-lg sm:rounded-l-none rounded-l-lg sm:rounded-r-lg font-medium hover:bg-indigo-700 transition duration-300">Subscribe</button>
                    </div>
                    <p class="text-sm text-gray-400 mt-4">We respect your privacy. Unsubscribe at any time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="pt-12 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-2">N</div>
                        <span class="text-xl font-bold text-white">NEXUS <span class="text-indigo-400">Gadget</span></span>
                    </div>
                    <p class="text-gray-400 mb-4">Your one-stop shop for premium computer parts, laptops, and smartphones.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4 text-white">Shop</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Laptops</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Smartphones</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Monitors</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Keyboards</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Mouse</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4 text-white">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">FAQs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Shipping Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Returns & Warranty</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Track Order</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4 text-white">Contact</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                            <span class="text-gray-400">123 Tech Street, Silicon Valley, CA</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-2 text-gray-400"></i>
                            <span class="text-gray-400">+1 (800) 123-4567</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>
                            <span class="text-gray-400">support@nexusgadget.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">© 2023 NEXUS Gadget. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition duration-300">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition duration-300">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition duration-300">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-6 right-6 p-3 rounded-full shadow-lg opacity-0 invisible transition-all duration-300">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Back to Top Button
        const backToTopButton = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });
        
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Product card hover effect
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.3)';
                card.style.background = 'rgba(30, 41, 59, 0.7)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
                card.style.boxShadow = '';
                card.style.background = 'rgba(15, 23, 42, 0.7)';
            });
        });
        
        // Category card hover effect
        const categoryCards = document.querySelectorAll('.category-card');
        categoryCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.3)';
                card.style.background = 'rgba(30, 41, 59, 0.7)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
                card.style.boxShadow = '';
                card.style.background = 'rgba(15, 23, 42, 0.7)';
            });
        });
        
        // Feature card hover effect
        const featureCards = document.querySelectorAll('.feature-card');
        featureCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.3)';
                card.style.background = 'rgba(30, 41, 59, 0.7)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
                card.style.boxShadow = '';
                card.style.background = 'rgba(15, 23, 42, 0.7)';
            });
        });
        
        // Auth Modal Functionality
        const authModal = document.getElementById('authModal');
        const loginLinks = document.querySelectorAll('.login-link');
        const closeModal = authModal.querySelector('button');
        const tabButtons = document.querySelectorAll('.tab-button');
        const loginTab = document.getElementById('login-tab');
        const signupTab = document.getElementById('signup-tab');
        
        // Show modal when login links are clicked
        loginLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                authModal.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });
        
        // Close modal when close button is clicked
        closeModal.addEventListener('click', () => {
            authModal.classList.remove('active');
            document.body.style.overflow = '';
        });
        
        // Close modal when clicking outside modal content
        authModal.addEventListener('click', (e) => {
            if (e.target === authModal) {
                authModal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
        
        // Tab switching functionality
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Update active tab button
                tabButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                // Show corresponding tab content
                if (button.dataset.tab === 'login') {
                    loginTab.classList.remove('hidden');
                    signupTab.classList.add('hidden');
                } else {
                    loginTab.classList.add('hidden');
                    signupTab.classList.remove('hidden');
                }
            });
        });
        
        // Form submission handling
        const loginForm = document.getElementById('loginForm');
        const signupForm = document.getElementById('signupForm');
        
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Here you would typically handle login logic
            alert('Login functionality would be implemented here');
            authModal.classList.remove('active');
            document.body.style.overflow = '';
        });
        
        signupForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Here you would typically handle signup logic
            const password = document.getElementById('signupPassword').value;
            const confirmPassword = document.getElementById('signupConfirmPassword').value;
            
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }
            
            alert('Account created successfully!');
            authModal.classList.remove('active');
            document.body.style.overflow = '';
        });
    </script>
</body>
</html>