<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>NexusGadgets POS</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        @font-face {
            font-family: 'SuperDario';
            src: url('uploads/Valorax-lg25V.otf') format('truetype'); /* Update the path to your font file */
        }

        .superdario-font {
            font-family: 'SuperDario', sans-serif;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0a192f 0%, #172a45 100%);
            color: white;
            min-height: 100vh;
            margin: 0;
            padding: 0 18px; /* Add a little space left and right */
            width: 100vw;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(23, 42, 69, 0.5);
        }
        ::-webkit-scrollbar-thumb {
            background: #6366f1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #4f46e5;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: rgba(10, 25, 47, 0.7);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 50;
            border-radius: 0 0 10px 10px;
            backdrop-filter: blur(5px);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            color: #6366f1;
            font-size: 1.5rem;
            text-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.25rem;
            background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: rgba(23, 42, 69, 0.8);
            color: white;
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            width: 300px;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .search-bar:focus-within {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
        }

        .search-bar input {
            border: none;
            outline: none;
            background: transparent;
            color: white;
            padding: 0.25rem;
            font-size: 0.875rem;
            width: 100%;
        }

        .search-bar input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .action-buttons {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cart-badge {
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            background: rgba(23, 42, 69, 0.8);
            transition: all 0.2s;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .cart-badge:hover {
            background: rgba(99, 102, 241, 0.2);
        }

        .cart-count {
            position: absolute;
            top: -0.25rem;
            right: -0.25rem;
            background: #6366f1;
            color: white;
            border-radius: 50%;
            width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .main-container {
            display: grid;
            grid-template-columns: 1fr 320px;
            height: calc(100vh - 72px);
            width: 100%;
            min-width: 0;
        }

        .products-section {
            padding: 1.5rem 0; /* Remove left/right padding, handled by body */
            overflow-y: auto;
        }

        .order-section {
            border-left: 1px solid rgba(99, 102, 241, 0.2);
            background: rgba(23, 42, 69, 0.7);
            display: flex;
            flex-direction: column;
            height: 100%;
            backdrop-filter: blur(5px);
        }

        .categories {
            display: flex;
            gap: 0.75rem;
            overflow-x: auto;
            padding: 0.75rem 0;
            margin-bottom: 1.5rem;
            scrollbar-width: none;
        }

        .categories::-webkit-scrollbar {
            display: none;
        }

        .category {
            background: linear-gradient(135deg, #1e4b8e 0%, #0a192f 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            white-space: nowrap;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid rgba(99, 102, 241, 0.2);
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .category.active {
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
            color: white;
            font-weight: 600;
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
        }

        .category:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .product-card {
            background: linear-gradient(135deg, #172a45 0%, #0a192f 100%);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .product-image {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-bottom: 1px solid rgba(99, 102, 241, 0.1);
        }

        .product-details {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-name {
            font-size: 0.875rem;
            color: #ccd6f6;
            margin-bottom: 0.5rem;
            font-weight: 500;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            font-size: 1rem;
            font-weight: 600;
            color: #6366f1;
            margin-top: auto;
        }

        .add-btn {
            width: 100%;
            padding: 0.5rem;
            background: linear-gradient(135deg, #1e4b8e 0%, #6366f1 100%);
            color: white;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            margin-top: 0.75rem;
            transition: all 0.2s;
        }

        .add-btn:hover {
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
        }

        .add-btn:active {
            background: linear-gradient(135deg, #4338ca 0%, #1e4b8e 100%);
        }

        .order-header {
            padding: 1.25rem;
            border-bottom: 1px solid rgba(99, 102, 241, 0.2);
        }

        .order-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #ccd6f6;
        }

        /* --- SCROLLABLE ORDER ITEMS --- */
        .order-items {
            flex: 1 1 0%;
            overflow-y: auto;
            padding: 1rem;
            scroll-behavior: smooth;
            max-height: 55vh; /* Adjust as needed for your layout */
        }
        .order-items::-webkit-scrollbar {
            width: 8px;
        }
        .order-items::-webkit-scrollbar-thumb {
            background: #6366f1;
            border-radius: 4px;
        }
        /* --- END SCROLLABLE ORDER ITEMS --- */

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
            background: rgba(23, 42, 69, 0.5);
            border-radius: 0.5rem;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .order-item-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }

        .order-item-image {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .order-item-details {
            display: flex;
            flex-direction: column;
        }

        .order-item-name {
            font-size: 0.875rem;
            color: #ccd6f6;
            font-weight: 500;
        }

        .order-item-price {
            font-size: 0.75rem;
            color: #6366f1;
        }

        .order-item-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .qty-btn {
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 0.375rem;
            background: #1e4b8e;
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .qty-btn:hover {
            background: #6366f1;
        }

        .qty-btn:active {
            background: #4338ca;
        }

        .order-item-qty {
            margin: 0 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            min-width: 1rem;
            text-align: center;
            color: white;
        }

        .remove-btn {
            background: none;
            border: none;
            color: #ff6b6b;
            cursor: pointer;
            font-size: 1rem;
            width: 1.75rem;
            height: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }

        .remove-btn:hover {
            background: rgba(255, 107, 107, 0.1);
        }

        .order-summary {
            padding: 1.25rem;
            border-top: 1px solid rgba(99, 102, 241, 0.2);
            background: rgba(10, 25, 47, 0.7);
        }

        .order-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
            color: #ccd6f6;
        }

        .order-total {
            font-weight: 600;
            font-size: 1rem;
            color: #6366f1;
        }

        .checkout-btn {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            margin-top: 1rem;
            transition: all 0.2s;
        }

        .checkout-btn:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #1e4b8e 100%);
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
        }

        .checkout-btn:active {
            background: linear-gradient(135deg, #4338ca 0%, #1e4b8e 100%);
        }

        .empty-cart {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #94a3b8;
            padding: 2rem;
            text-align: center;
        }

        .empty-cart-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: rgba(99, 102, 241, 0.5);
        }

        @media (max-width: 1024px) {
            .main-container {
                grid-template-columns: 1fr;
            }

            .order-section {
                position: fixed;
                top: 72px;
                right: 0;
                width: 100%;
                max-width: 380px;
                height: calc(100vh - 72px);
                transform: translateX(100%);
                transition: transform 0.3s ease;
                z-index: 40;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
            }

            .order-section.active {
                transform: translateX(0);
            }

            .overlay {
                position: fixed;
                top: 72px;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 30;
                display: none;
            }

            .overlay.active {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }

            .logo-text {
                display: none;
            }

            .search-bar {
                width: 200px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            }
        }

        @media (max-width: 640px) {
            .search-bar {
                display: none;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
        }

        .barcode-bar.expanded {
            width: 350px !important;
            z-index: 10;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.3);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="py-3"> <!-- Removed container mx-auto px-4 -->
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="#" class="flex items-center">
                    <img src="images/NEXUS GADGETS.png" alt="NEXUS GADGETS Logo" class="w-24 h-24 mr-6">
                    <span class="text-2xl font-bold text-white superdario-font">
    NEXUS <span class="text-indigo-400 superdario-font">Gadget</span>
</span>
                </a>
            </div>
            <div class="search-container">
                <div class="search-bar">
                    <i class="fas fa-search mr-2 text-blue-300"></i>
                    <input type="text" placeholder="Search products..." id="search-input" oninput="searchItems()">
                </div>
                <div class="search-bar barcode-bar" id="barcode-bar" style="width:180px; transition:width 0.3s;">
                    <i class="fas fa-barcode mr-2 text-blue-300"></i>
                    <input type="text" placeholder="Scan barcode..." id="barcode-input" onkeydown="barcodeScanHandler(event)">
                </div>
                <div class="action-buttons">
                    <div class="cart-badge" id="cart-toggle" onclick="toggleOrderSection()">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="cart-count" id="cart-count">0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <div class="main-container" style="width:100vw; min-width:0;"> <!-- Add style for full width -->
        <!-- Products Section -->
        <div class="products-section">
            <div class="categories">
                <div class="category active" onclick="filterItems('All', event)">All</div>
                <div class="category" onclick="filterItems('Keyboards', event)">Keyboards</div>
                <div class="category" onclick="filterItems('Monitors', event)">Monitors</div>
                <div class="category" onclick="filterItems('Mouse', event)">Mouse</div>
                <div class="category" onclick="filterItems('Laptops', event)">Laptops</div>
                <div class="category" onclick="filterItems('Smartphones', event)">Smartphones</div>
            </div>
            <div class="products-grid" id="products-grid">
                <!-- Products will be loaded dynamically -->
            </div>
        </div>
        <!-- Order Section -->
        <div class="order-section" id="order-section">
            <div class="order-header">
                <h2 class="order-title">Current Order</h2>
            </div>
            <div class="order-items" id="order-items">
                <!-- Order items will be loaded dynamically -->
                <div class="empty-cart">
                    <i class="fas fa-shopping-basket empty-cart-icon"></i>
                    <p>Your cart is empty</p>
                    <p class="text-sm mt-2">Add products to get started</p>
                </div>
            </div>
            <div class="order-summary" id="order-summary" style="display: none;">
                <div class="order-row">
                    <span>Subtotal</span>
                    <span id="order-subtotal">₱0.00</span>
                </div>
                <div class="order-row">
                    <span>Tax (12%)</span>
                    <span id="order-tax">₱0.00</span>
                </div>
                <div class="order-row order-total">
                    <span>Total</span>
                    <span id="order-total">₱0.00</span>
                </div>
                <button class="checkout-btn" onclick="placeOrder()">
                    <i class="fas fa-credit-card mr-2"></i> Checkout
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Payment Method Modal -->
    <div id="payment-modal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:100; background:rgba(0,0,0,0.6); align-items:center; justify-content:center;">
        <div style="background:#172a45; padding:2rem; border-radius:0.75rem; min-width:300px; box-shadow:0 8px 32px rgba(0,0,0,0.3); color:white; text-align:center;">
            <h2 style="font-size:1.25rem; font-weight:600; margin-bottom:1rem;">Select Payment Method</h2>
            <div style="display:flex; flex-direction:column; gap:1rem;">
                <button onclick="selectPayment('Cash')" class="checkout-btn">Cash</button>
                <button onclick="selectPayment('Card')" class="checkout-btn">Card</button>
                <button onclick="selectPayment('E-wallet')" class="checkout-btn">E-wallet</button>
            </div>
            <button style="margin-top:2rem; color:#94a3b8; background:none; border:none;" onclick="closePaymentModal()">Cancel</button>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div id="receipt-modal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:101; background:rgba(0,0,0,0.6); align-items:center; justify-content:center;">
        <div style="background:#fff; color:#172a45; border-radius:0.75rem; min-width:320px; box-shadow:0 8px 32px rgba(0,0,0,0.3); padding:2rem; text-align:left; font-family:monospace; position:relative;">
            <div id="receipt-content">
                <!-- Content will be filled by JS -->
            </div>
            <div style="display:flex; gap:1rem; justify-content:center; margin-top:2rem;">
                <button onclick="printReceipt()" style="background:#6366f1; color:white; border:none; border-radius:0.5rem; padding:0.5rem 1.5rem; font-weight:600; cursor:pointer;">
                    <i class="fas fa-print"></i> Print
                </button>
                <button onclick="closeReceiptModal()" style="background:#e5e7eb; color:#172a45; border:none; border-radius:0.5rem; padding:0.5rem 1.5rem; font-weight:600; cursor:pointer;">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let cart = [];
        let products = [
            { id: 1, name: "Mechanical Keyboard (RGB)", price: 2499, stock: 10, category: "Keyboards", image: "https://images.unsplash.com/photo-1587829741301-dc798b83add3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&h=300&q=80" },
            { id: 2, name: "Gaming Mouse (Wireless)", price: 1599, stock: 15, category: "Mouse", image: "https://images.unsplash.com/photo-1527814050087-3793815479db?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&h=300&q=80" },
            { id: 3, name: "27\" IPS Monitor (4K)", price: 15999, stock: 5, category: "Monitors", image: "https://images.unsplash.com/photo-1546538475-4d557ebe27a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&h=300&q=80" },
            { id: 4, name: "Gaming Laptop (RTX 3060)", price: 65999, stock: 3, category: "Laptops", image: "https://images.unsplash.com/photo-1593642632823-8f785ba67e45?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&h=300&q=80" },
            { id: 5, name: "Flagship Smartphone (128GB)", price: 39999, stock: 8, category: "Smartphones", image: "https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&h=300&q=80" },
            { id: 6, name: "Wireless Earbuds", price: 3499, stock: 12, category: "Accessories", image: "https://images.unsplash.com/photo-1590658268037-6bf12165a8df?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&h=300&q=80" },
            { id: 7, name: "Ergonomic Keyboard", price: 2999, stock: 7, category: "Keyboards", image: "https://images.unsplash.com/photo-1583445013765-46c20c4a39b9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&h=300&q=80" },
            { id: 8, name: "Ultrawide Monitor", price: 22999, stock: 4, category: "Monitors", image: "https://images.unsplash.com/photo-1551645120-d70bfe84c826?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&h=300&q=80" }
        ];

        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
            setupEventListeners();
            const savedCart = localStorage.getItem('nexusCart');
            if (savedCart) {
                cart = JSON.parse(savedCart);
                updateCartDisplay();
            }
            const barcodeBar = document.getElementById('barcode-bar');
            const barcodeInput = document.getElementById('barcode-input');
            barcodeBar.addEventListener('click', function() {
                barcodeBar.classList.add('expanded');
                barcodeInput.focus();
            });
            barcodeInput.addEventListener('blur', function() {
                barcodeBar.classList.remove('expanded');
            });
        });

        function setupEventListeners() {
            document.getElementById('cart-toggle').addEventListener('click', function() {
                toggleOrderSection();
            });
            document.getElementById('overlay').addEventListener('click', function() {
                document.getElementById('order-section').classList.remove('active');
                this.classList.remove('active');
            });
        }

        function toggleOrderSection() {
            const orderSection = document.getElementById('order-section');
            const overlay = document.getElementById('overlay');
            orderSection.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        function loadProducts() {
            const grid = document.getElementById('products-grid');
            grid.innerHTML = '';
            products.forEach(product => {
                const card = document.createElement('div');
                card.className = 'product-card';
                card.setAttribute('data-name', product.name);
                card.setAttribute('data-category', product.category);
                card.innerHTML = `
                    <img src="${product.image}" alt="${product.name}" class="product-image">
                    <div class="product-details">
                        <div class="product-name">${product.name}</div>
                        <div class="product-price">₱${product.price.toLocaleString('en-US', {minimumFractionDigits: 2})}</div>
                        <button class="add-btn" onclick="addToCart(${product.id})">
                            <i class="fas fa-plus mr-1"></i> Add
                        </button>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;
            const existingItem = cart.find(item => item.id === productId);
            if (existingItem) {
                if (existingItem.quantity < product.stock) {
                    existingItem.quantity++;
                } else {
                    showAlert(`Cannot add more than ${product.stock} of this item.`);
                    return;
                }
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    quantity: 1,
                    maxQuantity: product.stock
                });
            }
            updateCartDisplay();
            showAlert(`${product.name} added to cart`);
        }

        function removeFromCart(index, quantity = 1) {
            if (cart[index].quantity > quantity) {
                cart[index].quantity -= quantity;
            } else {
                cart.splice(index, 1);
            }
            updateCartDisplay();
        }

        function updateCartDisplay() {
            const itemsContainer = document.getElementById('order-items');
            const summaryContainer = document.getElementById('order-summary');
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cart-count').textContent = count;
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const tax = subtotal * 0.12;
            const total = subtotal + tax;
            localStorage.setItem('nexusCart', JSON.stringify(cart));
            if (cart.length === 0) {
                itemsContainer.innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-basket empty-cart-icon"></i>
                        <p>Your cart is empty</p>
                        <p class="text-sm mt-2">Add products to get started</p>
                    </div>
                `;
                summaryContainer.style.display = 'none';
                return;
            }
            summaryContainer.style.display = 'block';
            itemsContainer.innerHTML = '';
            cart.forEach((item, index) => {
                const itemElement = document.createElement('div');
                itemElement.className = 'order-item';
                itemElement.innerHTML = `
                    <div class="order-item-info">
                        <img src="${item.image}" alt="${item.name}" class="order-item-image">
                        <div class="order-item-details">
                            <div class="order-item-name">${item.name}</div>
                            <div class="order-item-price">₱${item.price.toFixed(2)}</div>
                        </div>
                    </div>
                    <div class="order-item-controls">
                        <button class="qty-btn" onclick="removeFromCart(${index})">-</button>
                        <div class="order-item-qty">${item.quantity}</div>
                        <button class="qty-btn" onclick="addToCart(${item.id})">+</button>
                        <button class="remove-btn" onclick="removeFromCart(${index}, ${item.quantity})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                itemsContainer.appendChild(itemElement);
            });
            document.getElementById('order-subtotal').textContent = `₱${subtotal.toFixed(2)}`;
            document.getElementById('order-tax').textContent = `₱${tax.toFixed(2)}`;
            document.getElementById('order-total').textContent = `₱${total.toFixed(2)}`;
        }

        function filterItems(category, event) {
            const items = document.querySelectorAll('.product-card');
            items.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                if (category === 'All' || itemCategory === category) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
            document.querySelectorAll('.category').forEach(cat => {
                cat.classList.remove('active');
            });
            if (event && event.target) {
                event.target.classList.add('active');
            }
        }

        function searchItems() {
            const query = document.getElementById('search-input').value.toLowerCase();
            const items = document.querySelectorAll('.product-card');
            items.forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                if (name.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function barcodeScanHandler(event) {
            if (event.key === 'Enter') {
                const barcode = event.target.value.trim();
                if (!barcode) return;
                const productId = parseInt(barcode, 10);
                const product = products.find(p => p.id === productId);
                if (product) {
                    addToCart(productId);
                    showAlert(`${product.name} added via barcode`, 'success');
                } else {
                    showAlert('Product not found for barcode: ' + barcode, 'info');
                }
                event.target.value = '';
            }
        }

        // Modified placeOrder to show payment modal
        function placeOrder() {
            if (cart.length === 0) {
                showAlert('Your cart is empty!');
                return;
            }
            // Show payment modal instead of processing order immediately
            document.getElementById('payment-modal').style.display = 'flex';
        }

        // Called when user chooses payment method
        function selectPayment(method) {
            document.getElementById('payment-modal').style.display = 'none';

            // Prepare receipt content
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const tax = subtotal * 0.12;
            const total = subtotal + tax;
            const now = new Date();
            let receiptHtml = `
                <h2 style="text-align:center;">NexusGadgets POS</h2>
                <hr>
                <div style="font-size:0.95rem;">Date: ${now.toLocaleString()}</div>
                <div style="font-size:0.95rem;">Payment: <b>${method}</b></div>
                <hr>
                <table style="width:100%; font-size:0.95rem; margin:1rem 0;">
                    <tr>
                        <th style="text-align:left;">Item</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:right;">Price</th>
                    </tr>
                    ${cart.map(item => `
                        <tr>
                            <td>${item.name}</td>
                            <td style="text-align:center;">${item.quantity}</td>
                            <td style="text-align:right;">₱${(item.price * item.quantity).toFixed(2)}</td>
                        </tr>
                    `).join('')}
                </table>
                <hr>
                <div style="display:flex; justify-content:space-between;">
                    <span>Subtotal</span><span>₱${subtotal.toFixed(2)}</span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span>Tax (12%)</span><span>₱${tax.toFixed(2)}</span>
                </div>
                <div style="display:flex; justify-content:space-between; font-weight:700;">
                    <span>Total</span><span>₱${total.toFixed(2)}</span>
                </div>
                <hr>
                <div style="text-align:center; margin-top:1rem;">Thank you!</div>
            `;
            document.getElementById('receipt-content').innerHTML = receiptHtml;

            // Update stock
            cart.forEach(cartItem => {
                const product = products.find(p => p.id === cartItem.id);
                if (product) {
                    product.stock -= cartItem.quantity;
                }
            });

            // Show receipt
            document.getElementById('receipt-modal').style.display = 'flex';

            // Clear cart & update
            cart = [];
            updateCartDisplay();

            // Optionally close order-section/overlay if open
            document.getElementById('order-section').classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
        }

        function closePaymentModal() {
            document.getElementById('payment-modal').style.display = 'none';
        }

        function closeReceiptModal() {
            document.getElementById('receipt-modal').style.display = 'none';
        }

        function printReceipt() {
            const printContents = document.getElementById('receipt-content').innerHTML;
            const w = window.open('', '', 'width=400,height=600');
            w.document.write('<html><head><title>Receipt</title>');
            w.document.write('<style>body{font-family:monospace; color:#172a45;} h2{text-align:center;} table{width:100%; border-collapse:collapse;} th,td{padding:4px;}</style>');
            w.document.write('</head><body>');
            w.document.write(printContents);
            w.document.write('</body></html>');
            w.document.close();
            w.focus();
            w.print();
            w.close();
        }

        function showAlert(message, type = 'info') {
            const existingAlert = document.querySelector('.alert-message');
            if (existingAlert) existingAlert.remove();
            const alert = document.createElement('div');
            alert.className = `alert-message fixed bottom-4 right-4 px-4 py-3 rounded-md shadow-lg text-white ${
                type === 'success' ? 'bg-green-500' : 'bg-blue-500'
            }`;
            alert.textContent = message;
            document.body.appendChild(alert);
            setTimeout(() => {
                alert.remove();
            }, 3000);
        }
    </script>
</body>
</html>