<?php 
session_start();


if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
} else {
    include "php/conn_db.php";
    include "php/functions.php";
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT u.email, r.rank_name FROM users u JOIN ranks r ON u.rank_id = r.rank_id WHERE u.email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $email_rank = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    if ($email_rank) {
        $rank = $email_rank['rank_name'];
        if ($rank === "Admin") {
            header("Location: adminpanel.php");
            exit();
        } else if ($rank === "Staff") {
            header("Location: defaultpanel.php");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Gadgets - Premium Electronics Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom CSS for animations and transitions */
        @font-face {
            font-family: 'SuperDario';
            src: url('uploads/Valorax-lg25V.otf') format('truetype'); /* Update the path to your font file */
        }

        .superdario-font {
            font-family: 'SuperDario', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0a192f 0%, #172a45 100%);
            color: #e0e0e0;
            min-height: 100vh;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        
        .cart-item-enter {
            opacity: 0;
            transform: translateX(-20px);
        }
        
        .cart-item-enter-active {
            opacity: 1;
            transform: translateX(0);
            transition: all 300ms ease-out;
        }
        
        .cart-item-exit {
            opacity: 1;
        }
        
        .cart-item-exit-active {
            opacity: 0;
            transform: translateX(20px);
            transition: all 300ms ease-out;
        }
        
        .drawer {
            transition: transform 0.3s ease-in-out;
        }
        
        .drawer-open {
            transform: translateX(0);
        }
        
        .drawer-closed {
            transform: translateX(100%);
        }
        
        .badge {
            transition: all 0.2s ease;
        }
        
        .badge-pulse {
            animation: pulse 1.5s infinite;
        }
        
        .modal {
            transition: all 0.3s ease;
        }
        
        .modal-enter {
            opacity: 0;
            transform: scale(0.9);
        }
        
        .modal-enter-active {
            opacity: 1;
            transform: scale(1);
        }
        
        .modal-exit {
            opacity: 1;
            transform: scale(1);
        }
        
        .modal-exit-active {
            opacity: 0;
            transform: scale(0.9);
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .logo-text {
            background: linear-gradient(90deg, #64b5f6, #bbdefb);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Print-specific styles */
        @media print {
            body * {
                visibility: hidden;
            }
            .current-order, .current-order * {
                visibility: visible;
            }
            .current-order {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }

        /* Add this to your <style> section */
        #cartItems {
            max-height: 50vh;
            overflow-y: auto;
        }

        /* Custom styles for dark theme */
        .bg-white {
            background-color: rgba(30, 30, 40, 0.9) !important;
            color: #e0e0e0;
        }
        
        .text-gray-900 {
            color: #ffffff !important;
        }
        
        .text-gray-500 {
            color: #b0b0b0 !important;
        }
        
        .text-gray-700 {
            color: #d0d0d0 !important;
        }
        
        .border-gray-300 {
            border-color: #444444 !important;
        }
        
        .divide-gray-200 {
            border-color: #444444 !important;
        }
        
        .bg-gray-50 {
            background-color: rgba(40, 40, 50, 0.9) !important;
        }
        
        .bg-gray-100 {
            background-color: rgba(50, 50, 60, 0.9) !important;
        }
        
        .bg-blue-100 {
            background-color: rgba(30, 70, 120, 0.9) !important;
        }
        
        .bg-green-100 {
            background-color: rgba(30, 80, 60, 0.9) !important;
        }
        
        .bg-yellow-100 {
            background-color: rgba(100, 80, 30, 0.9) !important;
        }
        
        .text-blue-800 {
            color: #90caf9 !important;
        }
        
        .text-green-800 {
            color: #a5d6a7 !important;
        }
        
        .text-yellow-800 {
            color: #ffe082 !important;
        }
        
        .shadow-lg {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
        }
        
        .shadow-md {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4) !important;
        }
        
        .border-b {
            border-bottom-color: #444444 !important;
        }
        
        .border-t {
            border-top-color: #444444 !important;
        }
        
        .bg-blue-600 {
            background-color: #1976d2 !important;
        }
        
        .hover\:bg-blue-700:hover {
            background-color: #1565c0 !important;
        }
        
        .text-blue-600 {
            color: #64b5f6 !important;
        }
        
        .hover\:text-blue-600:hover {
            color: #90caf9 !important;
        }
        
        .bg-gradient-to-r {
            background-image: linear-gradient(to right, #0d47a1, #1a237e) !important;
        }
        
        .bg-gray-200 {
            background-color: rgba(60, 60, 70, 0.9) !important;
        }
        
        .hover\:bg-gray-300:hover {
            background-color: rgba(80, 80, 90, 0.9) !important;
        }
        
        .text-gray-800 {
            color: #d0d0d0 !important;
        }
        
        .bg-green-500 {
            background-color: #388e3c !important;
        }
        
        .bg-gray-600 {
            background-color: #424242 !important;
        }
        
        .hover\:bg-gray-700:hover {
            background-color: #616161 !important;
        }
        
        .bg-red-500 {
            background-color: #d32f2f !important;
        }
        
        .hover\:text-red-700:hover {
            color: #f44336 !important;
        }
        
        .text-gray-300 {
            color: #9e9e9e !important;
        }
        
        .text-gray-600 {
            color: #bdbdbd !important;
        }

        /* Update active link styles */
        .nav-link-active {
            color: #90caf9 !important; /* lighter blue */
            background-color: rgba(144, 202, 249, 0.1);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-50">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <div class="flex items-center">
                        <a href="#" class="flex items-center">
                            <img src="images/NEXUS GADGETS.png" alt="NEXUS GADGETS Logo" class="w-24 h-24 mr-6">
                            <span class="text-2xl font-bold text-white superdario-font">
                                NEXUS <span class="text-indigo-400 superdario-font">Gadget</span>
                            </span>
                        </a>
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="#" class="text-white hover:text-blue-300 px-3 py-2 rounded-md text-sm font-medium nav-link" data-page="home" onclick="showHome()">Home</a>
                        <a href="#" class="text-white hover:text-blue-300 px-3 py-2 rounded-md text-sm font-medium nav-link" data-page="products" onclick="showProducts()">Products</a>
                        <a href="#" class="text-white hover:text-blue-300 px-3 py-2 rounded-md text-sm font-medium nav-link" data-page="orders" onclick="showOrders()">My Orders</a>
                        <button id="cartButton" class="relative text-white hover:text-blue-300 px-3 py-2 rounded-md text-sm font-medium" onclick="toggleCart()">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cartBadge" class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center badge">0</span>
                        </button>
                        <button onclick="logout()" class="text-white hover:text-blue-300 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobileMenuButton" class="text-white hover:text-blue-300 focus:outline-none" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <button id="mobileCartButton" class="ml-4 relative text-white hover:text-blue-300 focus:outline-none" onclick="toggleCart()">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="mobileCartBadge" class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center badge">0</span>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <div id="mobileMenu" class="md:hidden hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#" class="text-white hover:text-blue-300 block px-3 py-2 rounded-md text-base font-medium nav-link" data-page="home" onclick="showHome()">Home</a>
                <a href="#" class="text-white hover:text-blue-300 block px-3 py-2 rounded-md text-base font-medium nav-link" data-page="products" onclick="showProducts()">Products</a>
                <a href="#" class="text-white hover:text-blue-300 block px-3 py-2 rounded-md text-base font-medium nav-link" data-page="orders" onclick="showOrders()">My Orders</a>
                <button onclick="logout()" class="text-white hover:text-blue-300 block px-3 py-2 rounded-md text-base font-medium w-full text-left">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        <!-- Home Section -->
        <section id="homeSection">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-8 text-white mb-8">
                <h1 class="text-4xl font-bold mb-4">Welcome to Nexus Gadgets</h1>
                <p class="text-xl mb-6">Discover cutting-edge electronics and premium gadgets</p>
                <button onclick="showProducts()" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Shop Now <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
            
            <h2 class="text-2xl font-bold mb-6">Featured Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Featured products will be loaded here by JavaScript -->
            </div>
        </section>
        
        <!-- Products Section -->
        <section id="productsSection" class="hidden">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">All Products</h2>
                <div class="relative">
                    <select id="categoryFilter" class="block appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                        <option value="all">All Categories</option>
                        <option value="4">Keyboard</option>
                        <option value="1">Laptops</option>
                        <option value="5">Monitors</option>
                        <option value="3">Mouse</option>
                        <option value="2">Smartphone</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="productsContainer">
                <!-- Products will be loaded here by JavaScript -->
            </div>
        </section>
        
        <!-- Orders Section -->
        <section id="ordersSection" class="hidden">
            <h2 class="text-2xl font-bold mb-6">My Orders</h2>
            
            <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold">Order History</h3>
                </div>
                <div id="ordersList" class="divide-y divide-gray-200">
                    <!-- Orders will be loaded here by JavaScript -->
                    <div class="p-4 text-center text-gray-500">
                        You don't have any orders yet.
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <!-- Shopping Cart Drawer -->
    <div id="cartDrawer" class="fixed inset-y-0 right-0 w-full md:w-96 bg-white shadow-xl drawer drawer-closed z-50 overflow-y-auto">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-semibold">Your Shopping Cart</h3>
            <button id="closeCartButton" class="text-gray-500 hover:text-blue-600" onclick="closeCart()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div id="cartItems" class="p-4 divide-y divide-gray-200">
            <!-- Cart items will be loaded here by JavaScript -->
            <div class="py-8 text-center text-gray-500">
                <i class="fas fa-shopping-cart text-4xl mb-4 text-gray-300"></i>
                <p>Your cart is empty</p>
            </div>
        </div>
        
        <div class="p-4 border-t bg-gray-50">
            <div class="flex justify-between mb-2">
                <span class="font-medium">Subtotal:</span>
                <span id="cartSubtotal" class="font-medium">₱0.00</span>
            </div>
            <div class="flex justify-between mb-4">
                <span class="font-medium">Shipping:</span>
                <span id="cartShipping" class="font-medium">₱5.99</span>
            </div>
            <div class="flex justify-between text-lg font-bold mb-4">   
                <span>Total:</span>
                <span id="cartTotal">₱5.99</span>
            </div>
            <button id="checkoutButton" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-semibold transition duration-300">
                Proceed to Checkout
            </button>
        </div>
    </div>
    
    <!-- Checkout Modal -->
    <div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md modal">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Checkout Information</h3>
                    <button id="closeCheckoutModal" class="text-gray-500 hover:text-gray-700" onclick="closeModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="checkoutForm" class="space-y-4">
                    <div>
                        <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="fullName" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Shipping Address</label>
                        <textarea id="address" required rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" id="phone" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="creditCard" name="paymentMethod" value="creditCard" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="creditCard" class="ml-2 block text-sm text-gray-700">Credit Card</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="paypal" name="paymentMethod" value="paypal" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="paypal" class="ml-2 block text-sm text-gray-700">PayPal</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="bankTransfer" name="paymentMethod" value="bankTransfer" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="bankTransfer" class="ml-2 block text-sm text-gray-700">Bank Transfer</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="cod" name="paymentMethod" value="cod" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="cod" class="ml-2 block text-sm text-gray-700">Cash on Delivery</label>
                            </div>
                        </div>
                    </div>
                    
                    <div id="creditCardFields" class="space-y-4">
                        <div>
                            <label for="cardNumber" class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                            <input type="text" id="cardNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="1234 5678 9012 3456">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="expiryDate" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                <input type="text" id="expiryDate" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="MM/YY">
                            </div>
                            <div>
                                <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                <input type="text" id="cvv" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="123">
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-4 flex justify-between">
                        <button type="button" onclick="closeModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg font-medium transition duration-300 no-print">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition duration-300">
                            Complete Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Order Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md modal">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <i class="fas fa-check text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Order Confirmed!</h3>
                <p class="text-gray-600 mb-6">Thank you for your purchase. Your order has been placed successfully.</p>
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="font-medium">Order ID: <span id="orderIdDisplay" class="text-blue-600">ORD-12345</span></p>
                    <p class="text-sm text-gray-500 mt-1">We've sent a confirmation email to your address</p>
                </div>
                <div class="flex justify-between">
                    <button onclick="printOrder()" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg font-medium transition duration-300 no-print">
                        <i class="fas fa-print mr-2"></i> Print Receipt
                    </button>
                    <button id="closeConfirmationModal" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition duration-300 no-print" onclick="closeModal()">
                        Continue Shopping
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Order Receipt (hidden until needed for printing) -->
    <div id="currentOrder" class="current-order hidden p-6 bg-white max-w-md mx-auto">
        <!-- This will be populated with order details when printing -->
    </div>
    
    <!-- Overlay for cart drawer -->
    <div id="cartOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleCart()"></div>
    
    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden z-50">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span id="toastMessage">Product added to cart!</span>
        </div>
    </div>

    <!-- Product Details Modal -->
    <div id="productDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md modal relative" style="max-height:90vh; overflow-y:auto;">
            <button onclick="closeProductDetailsModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
            <div id="productDetailsContent" class="p-6">
                <!-- Product details will be injected here -->
            </div>
        </div>
    </div>
    
    <script>
        // Product data will be loaded from the server
        let products = [];
        
        // Get the logged-in user's email from PHP session
        const userEmail = <?php echo json_encode($_SESSION['email']); ?>;

        // Use a unique key for each user's orders in localStorage
        const ordersKey = 'customer_orders_' + userEmail;

        // Load orders from localStorage for this user, otherwise use sample data
        let orders = [];
        try {
            const savedOrders = localStorage.getItem(ordersKey);
            if (savedOrders) {
                orders = JSON.parse(savedOrders);
            } else {
                orders = [
                    {
                        id: "ORD-12345",
                        date: "2023-06-15",
                        status: "Delivered",
                        items: [
                            { productId: 1, name: "Wireless Headphones Pro", quantity: 1, price: 149.99 },
                            { productId: 5, name: "Wireless Earbuds", quantity: 1, price: 129.99 }
                        ],
                        total: 279.98
                    },
                    {
                        id: "ORD-12346",
                        date: "2023-06-20",
                        status: "Shipped",
                        items: [
                            { productId: 3, name: "Gaming Laptop", quantity: 1, price: 1599.99 }
                        ],
                        total: 1599.99
                    }
                ];
            }
        } catch (e) {
            orders = [];
        }
        
        // Assign persistent trackingId to each order at load
        orders.forEach(order => {
            order.trackingId = getPersistentTrackingId(order.id);
        });
        
        // Shopping cart
        let cart = [];
        let currentOrder = null;
        
        // DOM elements
        const homeSection = document.getElementById('homeSection');
        const productsSection = document.getElementById('productsSection');
        const ordersSection = document.getElementById('ordersSection');
        const productsContainer = document.getElementById('productsContainer');
        const ordersList = document.getElementById('ordersList');
        const cartDrawer = document.getElementById('cartDrawer');
        const cartOverlay = document.getElementById('cartOverlay');
        const cartItems = document.getElementById('cartItems');
        const cartSubtotal = document.getElementById('cartSubtotal');
        const cartShipping = document.getElementById('cartShipping');
        const cartTotal = document.getElementById('cartTotal');
        const cartButton = document.getElementById('cartButton');
        const mobileCartButton = document.getElementById('mobileCartButton');
        const closeCartButton = document.getElementById('closeCartButton');
        const checkoutButton = document.getElementById('checkoutButton');
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const categoryFilter = document.getElementById('categoryFilter');
        const cartBadge = document.getElementById('cartBadge');
        const mobileCartBadge = document.getElementById('mobileCartBadge');
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toastMessage');
        const checkoutModal = document.getElementById('checkoutModal');
        const closeCheckoutModal = document.getElementById('closeCheckoutModal');
        const checkoutForm = document.getElementById('checkoutForm');
        const confirmationModal = document.getElementById('confirmationModal');
        const closeConfirmationModal = document.getElementById('closeConfirmationModal');
        const orderIdDisplay = document.getElementById('orderIdDisplay');
        const creditCardFields = document.getElementById('creditCardFields');
        const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
        const currentOrderElement = document.getElementById('currentOrder');
        
        // Generate a random tracking ID (e.g., "TRK-ABC1234567")
        function generateTrackingId() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = 'TRK-';
            for (let i = 0; i < 10; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return result;
        }

        // Helper: Get or generate a persistent tracking ID for an order
        function getPersistentTrackingId(orderId) {
            let trackingMap = {};
            try {
                trackingMap = JSON.parse(localStorage.getItem('order_tracking_map')) || {};
            } catch (e) {
                trackingMap = {};
            }
            if (!trackingMap[orderId]) {
                trackingMap[orderId] = generateTrackingId();
                localStorage.setItem('order_tracking_map', JSON.stringify(trackingMap));
            }
            return trackingMap[orderId];
        }

        // Initialize the app
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch products from the server
            fetch('php/get_inventory_items.php')
                .then(response => response.json())
                .then(data => {
                    products = data.map(item => ({
                        id: parseInt(item.id),
                        name: item.name,
                        brand: item.brand || '',
                        price: parseFloat(item.price),
                        category: (item.category || '').toLowerCase(),
                        image: item.image ? ('uploads/' + item.image) : '',
                        description: item.description || '',
                        featured: false
                    }));

                    // Set 1 keyboard, 1 monitor, 1 smartphone as featured (if available)
                    let keyboard = products.find(p => p.category.replace(/\s+/g, '').replace(/s$/, '') === 'keyboard');
                    let monitor = products.find(p => p.category.replace(/\s+/g, '').replace(/s$/, '') === 'monitor');
                    let smartphone = products.find(p => p.category.replace(/\s+/g, '').replace(/s$/, '') === 'smartphone');
                    if (keyboard) keyboard.featured = true;
                    if (monitor) monitor.featured = true;
                    if (smartphone) smartphone.featured = true;

                    loadFeaturedProducts();
                    loadProducts();
                });
            // Load orders
            loadOrders();

            // Payment method change listener
            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    if (this.value === 'creditCard') {
                        creditCardFields.style.display = 'block';
                    } else {
                        creditCardFields.style.display = 'none';
                    }
                });
            });

            // Set credit card fields visibility on load
            const selectedPayment = document.querySelector('input[name="paymentMethod"]:checked');
            if (selectedPayment && selectedPayment.value === 'creditCard') {
                creditCardFields.style.display = 'block';
            } else {
                creditCardFields.style.display = 'none';
            }

            // Check if cart exists in localStorage
            const savedCart = localStorage.getItem('cart');
            if (savedCart) {
                cart = JSON.parse(savedCart);
            }
            updateCartBadge();
            updateCart(); // Ensure cart UI is updated on load

            // Event listeners
            cartButton.addEventListener('click', openCart);
            mobileCartButton.addEventListener('click', openCart);
            closeCartButton.addEventListener('click', closeCart); // Use closeCart instead of toggleCart
            cartOverlay.addEventListener('click', closeCart);     // Use closeCart instead of toggleCart

            // Close cart drawer when navigating to other pages
            document.querySelectorAll('a[onclick], button[onclick]').forEach(el => {
                const fn = el.getAttribute('onclick');
                if (
                    fn && (
                        fn.includes('showHome()') ||
                        fn.includes('showProducts()') ||
                        fn.includes('showOrders()')
                    )
                ) {
                    el.addEventListener('click', closeCart);
                }
            });

            // Add this line to enable the checkout modal when clicking the button
            checkoutButton.addEventListener('click', function(e) {
                e.preventDefault();
                if (cart.length === 0) return;
                // Close cart drawer
                cartDrawer.classList.remove('drawer-open');
                cartDrawer.classList.add('drawer-closed');
                cartOverlay.classList.add('hidden');
                document.body.style.overflow = 'hidden';
                // Show checkout modal
                showCheckoutModal();
            });

            // Fix: Attach form submit event for Complete Order button
            checkoutForm.addEventListener('submit', completeOrder);

            // Category filter event
            categoryFilter.addEventListener('change', filterProducts);
        });

        // Show home section
        function showHome() {
            homeSection.classList.remove('hidden');
            productsSection.classList.add('hidden');
            ordersSection.classList.add('hidden');
            closeMobileMenu();
            setActivePage('home');
        }

        // Show products section
        function showProducts() {
            homeSection.classList.add('hidden');
            productsSection.classList.remove('hidden');
            ordersSection.classList.add('hidden');
            closeMobileMenu();
            setActivePage('products');
        }

        // Show orders section
        function showOrders() {
            homeSection.classList.add('hidden');
            productsSection.classList.add('hidden');
            ordersSection.classList.remove('hidden');
            closeMobileMenu();
            setActivePage('orders');
        }

        // Load featured products
        function loadFeaturedProducts() {
            const featuredContainer = homeSection.querySelector('.grid');
            featuredContainer.innerHTML = '';
            
            const featuredProducts = products.filter(product => product.featured);
            
            featuredProducts.forEach(product => {
                const productCard = createProductCard(product);
                featuredContainer.appendChild(productCard);
            });
        }
        
        // Load all products
        function loadProducts() {
            productsContainer.innerHTML = '';
            
            products.forEach(product => {
                const productCard = createProductCard(product);
                productsContainer.appendChild(productCard);
            });
        }
        
        // Filter products by category (fix for Keyboard)
        function filterProducts() {
            const categoryValue = categoryFilter.value;
            if (categoryValue === 'all') {
                loadProducts();
                return;
            }
            // Map select value to category name (case-insensitive)
            let categoryName = '';
            switch (categoryValue) {
                case '1': categoryName = 'laptops'; break;
                case '2': categoryName = 'smartphone'; break;
                case '3': categoryName = 'mouse'; break;
                case '4': categoryName = 'keyboard'; break;
                case '5': categoryName = 'monitor'; break; // fix: singular
                default: categoryName = categoryValue.toLowerCase();
            }

            productsContainer.innerHTML = '';
            // Compare category ignoring case, whitespace, and plural/singular
            const filteredProducts = products.filter(product => {
                if (!product.category) return false;
                let prodCat = product.category.replace(/\s+/g, '').toLowerCase();
                // Accept both singular and plural for monitor/monitors, keyboard/keyboards, etc.
                if (prodCat.endsWith('s')) prodCat = prodCat.slice(0, -1);
                let catName = categoryName;
                if (catName.endsWith('s')) catName = catName.slice(0, -1);
                return prodCat === catName;
            });
            filteredProducts.forEach(product => {
                const productCard = createProductCard(product);
                productsContainer.appendChild(productCard);
            });
        }
        
        // Create product card element
        function createProductCard(product) {
            const card = document.createElement('div');
            card.className = 'product-card bg-white rounded-lg shadow-md overflow-hidden transition duration-300 cursor-pointer';
            card.tabIndex = 0;
            card.setAttribute('role', 'button');
            card.setAttribute('aria-label', product.name);

            // Show brand under the title
            card.innerHTML = `
                <div class="h-48 overflow-hidden">
                    <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">${product.name}</h3>
                    <p class="text-gray-400 text-sm mb-2">${product.brand}</p>
                    <div class="flex justify-between items-center mt-4">
                        <span class="font-bold text-blue-600">₱${product.price.toFixed(2)}</span>
                        <button onclick="event.stopPropagation(); addToCart(${product.id})" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm transition duration-300">
                            <i class="fas fa-cart-plus mr-1"></i> Add to Cart
                        </button>
                    </div>
                </div>
            `;

            // Show details modal on click
            card.addEventListener('click', function() {
                showProductDetailsModal(product);
            });

            // Also allow keyboard accessibility
            card.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    showProductDetailsModal(product);
                }
            });

            return card;
        }

        // Show product details modal
        function showProductDetailsModal(product) {
            const modal = document.getElementById('productDetailsModal');
            const content = document.getElementById('productDetailsContent');
            // Show the brand (from product.brand) in the modal
            content.innerHTML = `
                <div class="flex flex-col items-center">
                    <img src="${product.image}" alt="${product.name}" class="w-40 h-40 object-cover rounded mb-4">
                    <h2 class="text-2xl font-bold mb-2">${product.name}</h2>
                    <div class="mb-2"><span class="font-semibold">Brand:</span> ${product.brand ? product.brand : '<em>Unknown</em>'}</div>
                    <div class="mb-2"><span class="font-semibold">Category:</span> ${product.category ? product.category : ''}</div>
                    <div class="mb-2"><span class="font-semibold">Price:</span> ₱${product.price.toFixed(2)}</div>
                    <div class="mb-2"><span class="font-semibold">Description:</span> ${product.description ? product.description : '<em>No description</em>'}</div>
                    <button onclick="addToCart(${product.id})" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300">
                        <i class="fas fa-cart-plus mr-1"></i> Add to Cart
                    </button>
                </div>
            `;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close product details modal
        function closeProductDetailsModal() {
            document.getElementById('productDetailsModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Load orders
        function loadOrders() {
            ordersList.innerHTML = '';
            if (orders.length === 0) {
                ordersList.innerHTML = '<div class="p-4 text-center text-gray-500">You don\'t have any orders yet.</div>';
                return;
            }
            orders.forEach((order, idx) => {
                // Always use persistent trackingId
                order.trackingId = getPersistentTrackingId(order.id);
                const orderElement = document.createElement('div');
                orderElement.className = 'p-4';
                orderElement.innerHTML = `
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h4 class="font-semibold">Order #${order.id}</h4>
                            <p class="text-sm text-gray-500">Placed on ${order.date}</p>
                            <p class="text-xs text-blue-400 mt-1">Tracking ID: <span class="font-mono">${order.trackingId}</span></p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full ${
                            order.status === 'Delivered' ? 'bg-green-100 text-green-800' : 
                            order.status === 'Shipped' ? 'bg-blue-100 text-blue-800' : 
                            order.status === 'Cancelled' ? 'bg-red-500 text-white' :
                            'bg-yellow-100 text-yellow-800'
                        }">${order.status}</span>
                    </div>
                    <div class="border-l-2 border-blue-200 pl-3 my-2">
                        ${order.items.map(item => `
                            <div class="flex justify-between text-sm mb-1">
                                <span>${item.name} × ${item.quantity}</span>
                                <span>₱${(item.price * item.quantity).toFixed(2)}</span>
                            </div>
                        `).join('')}
                    </div>
                    <div class="flex justify-between mt-3 pt-2 border-t">
                        <span class="font-medium">Total:</span>
                        <span class="font-bold">₱${order.total.toFixed(2)}</span>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button class="order-received-btn bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm font-medium transition duration-200"
                            data-idx="${idx}" ${order.status === 'Delivered' || order.status === 'Cancelled' ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : ''}>
                            Order Received
                        </button>
                        <button class="cancel-order-btn bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm font-medium transition duration-200"
                            data-idx="${idx}" ${order.status === 'Delivered' || order.status === 'Cancelled' ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : ''}>
                            Cancel Order
                        </button>
                    </div>
                `;
                ordersList.appendChild(orderElement);
            });

            // Add event listeners for the buttons
            ordersList.querySelectorAll('.order-received-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const idx = parseInt(this.getAttribute('data-idx'));
                    if (orders[idx].status !== 'Delivered' && orders[idx].status !== 'Cancelled') {
                        orders[idx].status = 'Delivered';
                        localStorage.setItem(ordersKey, JSON.stringify(orders));
                        loadOrders();
                        showToast('Order marked as received.');
                    }
                });
            });
            ordersList.querySelectorAll('.cancel-order-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const idx = parseInt(this.getAttribute('data-idx'));
                    if (orders[idx].status !== 'Delivered' && orders[idx].status !== 'Cancelled') {
                        orders[idx].status = 'Cancelled';
                        localStorage.setItem(ordersKey, JSON.stringify(orders));
                        loadOrders();
                        showToast('Order cancelled.');
                    }
                });
            });
        }
        
        // Add product to cart
        function addToCart(productId) {
            const product = products.find(p => p.id === productId);

            if (!product) return;

            // Check if product is already in cart
            const existingItem = cart.find(item => item.id === productId);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    quantity: 1
                });
            }

            // Save cart to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Update cart badge
            updateCartBadge();

            // Show toast notification
            showToast(`${product.name} added to cart`);

            // Only update cart display, do not open/toggle the cart drawer
            updateCart();
        }
        
        // Update cart display
        function updateCart() {
            cartItems.innerHTML = '';
            
            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="py-8 text-center text-gray-500">
                        <i class="fas fa-shopping-cart text-4xl mb-4 text-gray-300"></i>
                        <p>Your cart is empty</p>
                    </div>
                `;
                
                // Disable checkout button
                checkoutButton.disabled = true;
                checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                cart.forEach(item => {
                    const cartItem = document.createElement('div');
                    cartItem.className = 'py-4 flex';
                    
                    cartItem.innerHTML = `
                        <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden">
                            <img src="${item.image}" alt="${item.name}" class="h-full w-full object-cover">
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex justify-between">
                                <h4 class="text-sm font-medium">${item.name}</h4>
                                <p class="text-sm font-medium">₱${(item.price * item.quantity).toFixed(2)}</p>
                            </div>
                            <div class="flex justify-between mt-1 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" class="text-gray-500 hover:text-blue-600 px-2">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="mx-2">${item.quantity}</span>
                                    <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" class="text-gray-500 hover:text-blue-600 px-2">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <button onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    cartItems.appendChild(cartItem);
                });
                
                // Calculate totals
                const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const shipping = subtotal > 100 ? 0 : 5.99;
                const total = subtotal + shipping;
                
                cartSubtotal.textContent = `₱${subtotal.toFixed(2)}`;
                cartShipping.textContent = `₱${shipping.toFixed(2)}`;
                cartTotal.textContent = `₱${total.toFixed(2)}`;
                
                // Enable checkout button
                checkoutButton.disabled = false;
                checkoutButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
        
        // Update product quantity in cart
        function updateQuantity(productId, newQuantity) {
            if (newQuantity < 1) {
                removeFromCart(productId);
                return;
            }
            
            const item = cart.find(item => item.id === productId);
            
            if (item) {
                item.quantity = newQuantity;
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCart();
                updateCartBadge();
            }
        }
        
        // Remove product from cart
        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCart();
            updateCartBadge();
            
            // Show toast notification
            const product = products.find(p => p.id === productId);
            if (product) {
                showToast(`${product.name} removed from cart`);
            }
        }
        
        // Update cart badge
        function updateCartBadge() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            
            cartBadge.textContent = totalItems;
            mobileCartBadge.textContent = totalItems;
            
            if (totalItems > 0) {
                cartBadge.classList.add('badge-pulse');
                mobileCartBadge.classList.add('badge-pulse');
                
                // Remove pulse animation after 1.5s
                setTimeout(() => {
                    cartBadge.classList.remove('badge-pulse');
                    mobileCartBadge.classList.remove('badge-pulse');
                }, 1500);
            }
        }
        
        // Toggle cart drawer
        function toggleCart() {
            if (cartDrawer.classList.contains('drawer-closed')) {
                cartDrawer.classList.remove('drawer-closed');
                cartDrawer.classList.add('drawer-open');
                cartOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                updateCart();
            } else {
                cartDrawer.classList.remove('drawer-open');
                cartDrawer.classList.add('drawer-closed');
                cartOverlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }
        
        // Close cart drawer
        function closeCart() {
            cartDrawer.classList.remove('drawer-open');
            cartDrawer.classList.add('drawer-closed');
            cartOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Add this function to always open the cart drawer
        function openCart() {
            cartDrawer.classList.remove('drawer-closed');
            cartDrawer.classList.add('drawer-open');
            cartOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            updateCart();
        }

        // Show checkout modal
        function showCheckoutModal() {
            if (cart.length === 0) return;
            checkoutModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close modal
        function closeModal() {
            checkoutModal.classList.add('hidden');
            confirmationModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Complete order
        function completeOrder(e) {
            e.preventDefault();

            // Get form values
            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const address = document.getElementById('address').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

            // Validate form (simple validation for demo)
            if (!fullName || !email || !address || !phone) {
                showToast('Please fill in all required fields');
                return;
            }

            // Calculate totals
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const shipping = subtotal > 100 ? 0 : 5.99;
            const total = subtotal + shipping;

            // Create a new order
            const orderId = `ORD-${Math.floor(Math.random() * 100000)}`;
            const orderDate = new Date().toISOString().split('T')[0];

            currentOrder = {
                id: orderId,
                date: orderDate,
                status: paymentMethod === 'cod' ? 'Pending (Cash on Delivery)' : 'Processing',
                items: cart.map(item => ({
                    productId: item.id,
                    name: item.name,
                    quantity: item.quantity,
                    price: item.price
                })),
                total: total,
                customer: {
                    name: fullName,
                    email: email,
                    address: address,
                    phone: phone
                },
                paymentMethod: paymentMethod === 'cod' ? 'Cash on Delivery' : 
                  paymentMethod === 'creditCard' ? 'Credit Card' :
                  paymentMethod === 'paypal' ? 'PayPal' : 'Bank Transfer',
                trackingId: getPersistentTrackingId(orderId)
            };

            orders.unshift(currentOrder);
            // Save updated orders to localStorage for this user
            localStorage.setItem(ordersKey, JSON.stringify(orders));

            // --- Record order in database ---
            // Log for debugging
            console.log('Order items sent to backend:', currentOrder.items);

            fetch('php/orders.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    order_id: orderId,
                    name: fullName,
                    email: email,
                    shipping_address: address,
                    phone: phone,
                    order_date: orderDate,
                    items: currentOrder.items, // send full items array
                    order_total: total,
                    payment_method: currentOrder.paymentMethod
                })
            }).catch(error => console.error('Error saving order:', error));
            // --- End record order ---

            // --- Update sales for each product ---
            cart.forEach(cartItem => {
                fetch('php/update_sales.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: cartItem.id, quantity: cartItem.quantity })
                }).catch(error => console.error('Error updating sales:', error));
            });
            // --- End update sales ---

            // --- Update weekly profits ---
            fetch('php/update_profits.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ profit: subtotal })
            }).catch(error => console.error('Error updating profits:', error));
            // --- End update weekly profits ---

            // Clear cart
            cart = [];
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartBadge();
            updateCart();

            // Close checkout modal
            checkoutModal.classList.add('hidden');

            // Show confirmation modal
            orderIdDisplay.textContent = orderId;
            confirmationModal.classList.remove('hidden');

            // Reset form
            checkoutForm.reset();

            // Close cart drawer
            cartDrawer.classList.remove('drawer-open');
            cartDrawer.classList.add('drawer-closed');
            cartOverlay.classList.add('hidden');

            // Refresh orders section if visible
            loadOrders();
        }

        // Print order receipt
        function printOrder() {
            if (!currentOrder) return;
            
            // Populate the current order element with receipt content
            currentOrderElement.innerHTML = `
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold">Nexus Gadgets</h2>
                    <p class="text-gray-600">123 Tech Street, Silicon Valley</p>
                    <p class="text-gray-600">www.nexusgadgets.com</p>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold border-b pb-2 mb-2">Order Receipt</h3>
                    <div class="flex justify-between mb-1">
                        <span class="font-medium">Order ID:</span>
                        <span>${currentOrder.id}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="font-medium">Date:</span>
                        <span>${currentOrder.date}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="font-medium">Status:</span>
                        <span>${currentOrder.status}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="font-medium">Payment Method:</span>
                        <span>${currentOrder.paymentMethod}</span>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold border-b pb-2 mb-2">Customer Information</h3>
                    <p class="mb-1">${currentOrder.customer.name}</p>
                    <p class="mb-1">${currentOrder.customer.email}</p>
                    <p class="mb-1">${currentOrder.customer.phone}</p>
                    <p class="text-sm text-gray-600">${currentOrder.customer.address}</p>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold border-b pb-2 mb-2">Order Items</h3>
                    <div class="space-y-2">
                        ${currentOrder.items.map(item => `
                            <div class="flex justify-between">
                                <span>${item.name} × ${item.quantity}</span>
                                <span>₱${(item.price * item.quantity).toFixed(2)}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
                
                <div class="border-t pt-4">
                    <div class="flex justify-between mb-1">
                        <span class="font-medium">Subtotal:</span>
                        <span>₱${(currentOrder.total - (currentOrder.total > 100 ? 0 : 5.99)).toFixed(2)}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="font-medium">Shipping:</span>
                        <span>₱${(currentOrder.total > 100 ? 0 : 5.99).toFixed(2)}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total:</span>
                        <span>₱${currentOrder.total.toFixed(2)}</span>
                    </div>
                </div>
                
                <div class="mt-8 text-center text-sm text-gray-500">
                    <p>Thank you for shopping with us!</p>
                    <p>For any inquiries, please contact support@nexusgadgets.com</p>
                </div>
            `;
            
            // Show the current order element
            currentOrderElement.classList.remove('hidden');
            
            // Print the receipt
            window.print();
            
            // Hide the current order element after printing
            setTimeout(() => {
                currentOrderElement.classList.add('hidden');
            }, 100);
        }

        // Toggle mobile menu
        function toggleMobileMenu() {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
            }
        }
        
        // Close mobile menu
        function closeMobileMenu() {
            mobileMenu.classList.add('hidden');
        }
        
        // Show toast notification
        function showToast(message) {
            toastMessage.textContent = message;
            toast.classList.remove('hidden');
            
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
        
        // Logout
        function logout() {
            // Use POST to logout.php for real logout, with a logout field
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'php/logout.php';
            // Add a hidden input named 'logout'
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'logout';
            input.value = '1';
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

        // Save and restore active page on refresh
        function setActivePage(page) {
            // Remove active class from all nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('nav-link-active');
            });
            // Add active class to current page's nav links
            document.querySelectorAll(`.nav-link[data-page="${page}"]`).forEach(link => {
                link.classList.add('nav-link-active');
            });
            // Save to localStorage
            localStorage.setItem('customer_active_page', page);
        }

        function showHome() {
            homeSection.classList.remove('hidden');
            productsSection.classList.add('hidden');
            ordersSection.classList.add('hidden');
            closeMobileMenu();
            setActivePage('home');
        }

        function showProducts() {
            homeSection.classList.add('hidden');
            productsSection.classList.remove('hidden');
            ordersSection.classList.add('hidden');
            closeMobileMenu();
            setActivePage('products');
        }

        function showOrders() {
            homeSection.classList.add('hidden');
            productsSection.classList.add('hidden');
            ordersSection.classList.remove('hidden');
            closeMobileMenu();
            setActivePage('orders');
        }

        // Set active page on page load (restore from localStorage)
        document.addEventListener('DOMContentLoaded', function() {
            // ...existing DOMContentLoaded code...
            const savedPage = localStorage.getItem('customer_active_page') || 'home';
            // Reset category filter to 'all' on every load
            if (categoryFilter) categoryFilter.value = 'all';
            if (savedPage === 'products') {
                showProducts();
            } else if (savedPage === 'orders') {
                showOrders();
            } else {
                showHome();
            }
        });

        // Also save orders to localStorage after any DOMContentLoaded initialization (to ensure sample orders are saved if not present)
        document.addEventListener('DOMContentLoaded', function() {
            // ...existing code...
            localStorage.setItem(ordersKey, JSON.stringify(orders));
            // ...existing code...
        });
    </script>
</body>
</html>