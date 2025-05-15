<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>NexusGadgets POS</title>
    <style>
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
            cursor: default;
        }

        /* Sidebar styles */
        .sidebar {
            width: 80px;
            background: linear-gradient(180deg, #0a192f 0%, #172a45 100%);
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            transition: width 0.5s;
            position: fixed;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            border-right: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar:hover {
            width: 220px;
        }

        .sidebar-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            cursor: pointer;
            color: #FFFFFF;
            transition: all 0.3s;
            text-align: center;
        }

        .sidebar-icon.logo {
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: auto;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .sidebar-icon.logo img {
            width: 50px;
            height: 50px;
            margin: 0 auto;
            display: block;
        }

        .sidebar-icon.logo::after {
            content: "NEXUS";
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 8px;
            font-size: 12px;
            color: #6366f1;
            font-weight: bold;
        }

        .sidebar:hover .sidebar-icon {
            width: 85%;
            justify-content: flex-start;
            padding: 10px 20px;
            margin-bottom: 10px;
            gap: 15px;
        }

        .sidebar-icon.active {
            background-color: #1e4b8e;
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.3);
        }

        .sidebar-icon:hover:not(.active) {
            background-color: rgba(99, 102, 241, 0.1);
        }

        .sidebar-text {
            display: none;
            font-size: 14px;
            color: #FFFFFF;
        }

        .sidebar:hover .sidebar-text {
            display: inline;
        }

        /* Main content styles */
        .main-content {
            margin-left: 80px;
            padding: 20px;
            transition: margin-left 0.5s;
        }

        .sidebar:hover ~ .main-content {
            margin-left: 220px;
        }

        /* Header styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(10, 25, 47, 0.7);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header-titles {
            display: flex;
            flex-direction: column;
        }

        .header-titles h1 {
            font-size: 28px;
            color: #6366f1;
            text-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
            margin-bottom: 5px;
        }

        .header-titles .items-label {
            color: #ccd6f6;
            font-size: 16px;
        }

        /* Cart badge */
        .cart-badge {
            position: relative;
            margin-left: 20px;
            cursor: pointer;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #6366f1;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        /* Search and barcode styles */
        .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .search-bar, .barcode-scanner {
            display: flex;
            align-items: center;
            background: rgba(23, 42, 69, 0.8);
            color: white;
            border-radius: 25px;
            padding: 0 15px;
            height: 45px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .search-bar {
            width: 300px;
        }

        .barcode-scanner {
            width: 45px;
            overflow: hidden;
            transition: width 0.3s;
            cursor: pointer;
            justify-content: center;
        }

        .barcode-scanner.expanded {
            width: 300px;
        }

        .search-bar input, .barcode-scanner input {
            border: none;
            outline: none;
            background: transparent;
            color: white;
            padding: 0 10px;
            font-size: 14px;
            width: 100%;
        }

        .search-bar input::placeholder, .barcode-scanner input::placeholder {
            color: rgba(255,255,255,0.5);
        }

        /* Categories styles */
        .categories {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 15px 0;
            scrollbar-width: none;
        }

        .categories::-webkit-scrollbar {
            display: none;
        }

        .category {
            background: linear-gradient(135deg, #1e4b8e 0%, #0a192f 100%);
            color: #FFFFFF;
            padding: 10px 20px;
            border-radius: 20px;
            white-space: nowrap;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.2);
            transition: all 0.3s;
        }

        .category.active {
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
            color: white;
            font-weight: bold;
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
            transform: translateY(-2px);
        }

        .category:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        }

        /* Items grid styles */
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            padding: 10px;
        }

        .item-card {
            background: linear-gradient(135deg, #172a45 0%, #0a192f 100%);
            color: #FFFFFF;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            height: 320px;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.3);
        }

        .item-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid rgba(99, 102, 241, 0.1);
        }

        .item-details {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .item-name {
            font-size: 16px;
            margin-bottom: 10px;
            color: #ccd6f6;
        }

        .item-price {
            font-size: 18px;
            font-weight: bold;
            color: #6366f1;
            margin-top: auto;
        }

        .add-btn {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, #1e4b8e 0%, #6366f1 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
            transition: all 0.3s;
        }

        .add-btn:hover {
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
        }

        /* Cart Section */
        .cart-section {
            display: none;
            margin-left: 80px;
            padding: 20px;
            transition: margin-left 0.5s;
        }

        .sidebar:hover ~ .cart-section {
            margin-left: 220px;
        }

        .cart-container {
            background: linear-gradient(135deg, #172a45 0%, #0a192f 100%);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(99, 102, 241, 0.2);
        }

        .cart-title {
            font-size: 24px;
            color: #6366f1;
        }

        .back-btn {
            padding: 8px 15px;
            background: linear-gradient(135deg, #1e4b8e 0%, #6366f1 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
        }

        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 15px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: rgba(23, 42, 69, 0.5);
            border-radius: 8px;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .cart-item-info {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }

        .cart-item-details {
            display: flex;
            flex-direction: column;
        }

        .cart-item-name {
            font-size: 16px;
            color: #ccd6f6;
            margin-bottom: 5px;
        }

        .cart-item-price {
            font-size: 14px;
            color: #6366f1;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .qty-btn {
            width: 25px;
            height: 25px;
            border-radius: 5px;
            background: #1e4b8e;
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn:hover {
            background: #6366f1;
        }

        .cart-item-qty {
            margin: 0 5px;
            font-size: 14px;
        }

        .remove-btn {
            background: none;
            border: none;
            color: #ff6b6b;
            cursor: pointer;
            font-size: 16px;
        }

        .cart-summary {
            padding: 15px;
            border-top: 1px solid rgba(99, 102, 241, 0.2);
        }

        .cart-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .cart-total {
            font-weight: bold;
            font-size: 16px;
            color: #6366f1;
        }

        .checkout-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #6366f1 0%, #1e4b8e 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s;
        }

        .checkout-btn:hover {
            background: linear-gradient(135deg, #1e4b8e 0%, #6366f1 100%);
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
        }

        /* Receipt Section */
        .receipt-section {
            display: none;
            margin-left: 80px;
            padding: 20px;
            transition: margin-left 0.5s;
        }

        .sidebar:hover ~ .receipt-section {
            margin-left: 220px;
        }

        .receipt-container {
            background: white;
            color: #0a192f;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #0a192f;
        }

        .receipt-header h2 {
            color: #1e4b8e;
            font-size: 24px;
        }

        .receipt-details {
            margin-bottom: 15px;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
        }

        .receipt-items {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .receipt-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            padding: 5px 0;
            border-bottom: 1px dashed #eee;
        }

        .receipt-totals {
            border-top: 1px dashed #0a192f;
            padding-top: 10px;
            margin-bottom: 15px;
        }

        .receipt-total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .receipt-total {
            font-weight: bold;
            color: #6366f1;
        }

        .receipt-footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 20px;
        }

        .receipt-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .receipt-btn {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .print-btn {
            background: #6366f1;
            color: white;
        }

        .close-receipt-btn {
            background: #ff6b6b;
            color: white;
        }

        /* Inventory styles */
        .inventory-section {
            display: none;
            margin-left: 80px;
            padding: 20px;
            transition: margin-left 0.5s;
        }

        .sidebar:hover ~ .inventory-section {
            margin-left: 220px;
        }

        .inventory-container {
            background: linear-gradient(135deg, #172a45 0%, #0a192f 100%);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .inventory-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(99, 102, 241, 0.2);
        }

        .inventory-title {
            font-size: 24px;
            color: #6366f1;
        }

        .inventory-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .inventory-item {
            background: linear-gradient(135deg, #172a45 0%, #0a192f 100%);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .inventory-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
        }

        .inventory-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .inventory-details {
            padding: 15px;
        }

        .inventory-name {
            font-size: 16px;
            margin-bottom: 10px;
            color: #ccd6f6;
        }

        .inventory-price {
            font-size: 18px;
            font-weight: bold;
            color: #6366f1;
            margin-bottom: 5px;
        }

        .inventory-stock {
            font-size: 14px;
            color: #ccd6f6;
            margin-bottom: 10px;
        }

        .inventory-category {
            font-size: 14px;
            color: #ccd6f6;
            margin-bottom: 15px;
            padding: 5px 10px;
            background: rgba(30, 75, 142, 0.5);
            border-radius: 5px;
            display: inline-block;
        }

        .inventory-actions {
            display: flex;
            gap: 10px;
        }

        .edit-btn {
            flex: 1;
            padding: 8px;
            background: linear-gradient(135deg, #1e4b8e 0%, #6366f1 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .delete-btn {
            flex: 1;
            padding: 8px;
            background: linear-gradient(135deg, #8e1e1e 0%, #ff6b6b 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        /* Edit Modal */
        .edit-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1001;
            display: none;
        }

        .edit-content {
            background: white;
            color: #0a192f;
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.5);
        }

        .edit-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .edit-title {
            font-size: 20px;
            color: #1e4b8e;
        }

        .close-edit {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #ff6b6b;
        }

        .edit-form-group {
            margin-bottom: 15px;
        }

        .edit-form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .edit-form-group input, .edit-form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .edit-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .save-btn {
            padding: 8px 15px;
            background: #6366f1;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .cancel-btn {
            padding: 8px 15px;
            background: #ff6b6b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .items-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }
            
            .sidebar:hover {
                width: 200px;
            }
            
            .main-content, .cart-section, .receipt-section, .inventory-section {
                margin-left: 60px;
            }
            
            .sidebar:hover ~ .main-content,
            .sidebar:hover ~ .cart-section,
            .sidebar:hover ~ .receipt-section,
            .sidebar:hover ~ .inventory-section {
                margin-left: 200px;
            }
            
            .search-bar {
                width: 200px;
            }
        }

        @media (max-width: 576px) {
            .header {
                flex-direction: column;
                gap: 15px;
            }
            
            .search-container {
                width: 100%;
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-bar {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-icon logo">
             <img src="images/NEXUS GADGETS.png" alt="Logo">
        </div>

        <div class="sidebar-icon active" id="dashboard-button" onclick="switchView('dashboard')">
            <i class="fas fa-tachometer-alt"></i>
            <span class="sidebar-text">Dashboard</span>
        </div>
        <div class="sidebar-icon" id="inventory-button" onclick="switchView('inventory')">
            <i class="fas fa-boxes"></i>
            <span class="sidebar-text">Inventory</span>
        </div>
        <div class="sidebar-icon" id="cart-button" onclick="switchView('cart')">
            <i class="fas fa-shopping-cart"></i>
            <span class="sidebar-text">Cart</span>
        </div>
        <div class="sidebar-icon" id="receipts-button" onclick="switchView('receipts')">
            <i class="fas fa-receipt"></i>
            <span class="sidebar-text">Receipts</span>
        </div>
        <div style="flex: 1;"></div>
        <div class="sidebar-icon" id="logout-button" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i>
            <span class="sidebar-text">Logout</span>
        </div>
    </div>

    <!-- Dashboard View -->
    <div class="main-content" id="dashboard-content">
        <div class="header">
            <div class="header-titles">
                <div class="items-label">WELCOME</div>
                <h1>Nexus Gadgets POS</h1>
            </div>
            <div class="search-container">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search products..." id="search-input" oninput="searchItems()">
                </div>
                <div class="barcode-scanner" id="barcode-scanner" onclick="toggleBarcodeInput()">
                    <i class="fas fa-barcode"></i>
                    <input type="text" placeholder="Scan barcode..." id="barcode-input" oninput="scanBarcode()" style="display: none;">
                </div>
                <div class="cart-badge" onclick="switchView('cart')">
                    <i class="fas fa-shopping-cart" style="font-size: 20px;"></i>
                    <div class="cart-count" id="cart-count">0</div>
                </div>
            </div>
        </div>

        <div class="categories">
            <div class="category active" onclick="filterItems('All')">All</div>
            <div class="category" onclick="filterItems('Keyboards')">Keyboards</div>
            <div class="category" onclick="filterItems('Monitors')">Monitors</div>
            <div class="category" onclick="filterItems('Mouse')">Mouse</div>
            <div class="category" onclick="filterItems('Laptops')">Laptops</div>
            <div class="category" onclick="filterItems('Smartphones')">Smartphones</div>
        </div>

        <div class="items-grid" id="items-grid">
            <!-- Sample product items -->
            <div class="item-card" data-name="Mechanical Keyboard" data-category="Keyboards">
                <img src="https://via.placeholder.com/300x200?text=Keyboard" alt="Mechanical Keyboard" class="item-image">
                <div class="item-details">
                    <div class="item-name">Mechanical Keyboard (RGB)</div>
                    <div class="item-price">₱2,499.00</div>
                    <button class="add-btn" onclick="addToCart('Mechanical Keyboard (RGB)', 2499, 'https://via.placeholder.com/300x200?text=Keyboard', 10)">
                        Add to Cart
                    </button>
                </div>
            </div>
            <div class="item-card" data-name="Gaming Mouse" data-category="Mouse">
                <img src="https://via.placeholder.com/300x200?text=Gaming+Mouse" alt="Gaming Mouse" class="item-image">
                <div class="item-details">
                    <div class="item-name">Gaming Mouse (Wireless)</div>
                    <div class="item-price">₱1,599.00</div>
                    <button class="add-btn" onclick="addToCart('Gaming Mouse (Wireless)', 1599, 'https://via.placeholder.com/300x200?text=Gaming+Mouse', 15)">
                        Add to Cart
                    </button>
                </div>
            </div>
            <div class="item-card" data-name="27\" Monitor" data-category="Monitors">
                <img src="https://via.placeholder.com/300x200?text=Monitor" alt="27\" Monitor" class="item-image">
                <div class="item-details">
                    <div class="item-name">27" IPS Monitor (4K)</div>
                    <div class="item-price">₱15,999.00</div>
                    <button class="add-btn" onclick="addToCart('27\" IPS Monitor (4K)', 15999, 'https://via.placeholder.com/300x200?text=Monitor', 5)">
                        Add to Cart
                    </button>
                </div>
            </div>
            <div class="item-card" data-name="Gaming Laptop" data-category="Laptops">
                <img src="https://via.placeholder.com/300x200?text=Laptop" alt="Gaming Laptop" class="item-image">
                <div class="item-details">
                    <div class="item-name">Gaming Laptop (RTX 3060)</div>
                    <div class="item-price">₱65,999.00</div>
                    <button class="add-btn" onclick="addToCart('Gaming Laptop (RTX 3060)', 65999, 'https://via.placeholder.com/300x200?text=Laptop', 3)">
                        Add to Cart
                    </button>
                </div>
            </div>
            <div class="item-card" data-name="Smartphone" data-category="Smartphones">
                <img src="https://via.placeholder.com/300x200?text=Smartphone" alt="Smartphone" class="item-image">
                <div class="item-details">
                    <div class="item-name">Flagship Smartphone (128GB)</div>
                    <div class="item-price">₱39,999.00</div>
                    <button class="add-btn" onclick="addToCart('Flagship Smartphone (128GB)', 39999, 'https://via.placeholder.com/300x200?text=Smartphone', 8)">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Section -->
    <div class="cart-section" id="cart-content">
        <div class="cart-container">
            <div class="cart-header">
                <h2 class="cart-title">Shopping Cart</h2>
                <button class="back-btn" onclick="switchView('dashboard')">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </button>
            </div>
            
            <div class="cart-items" id="cart-items">
                <!-- Cart items will be added here dynamically -->
            </div>
            
            <div class="cart-summary">
                <div class="cart-row">
                    <span>Subtotal:</span>
                    <span id="cart-subtotal">₱0.00</span>
                </div>
                <div class="cart-row">
                    <span>Tax (12%):</span>
                    <span id="cart-tax">₱0.00</span>
                </div>
                <div class="cart-row cart-total">
                    <span>Total:</span>
                    <span id="cart-total">₱0.00</span>
                </div>
                <button class="checkout-btn" onclick="generateReceipt()">Generate Receipt</button>
            </div>
        </div>
    </div>

    <!-- Receipt Section -->
    <div class="receipt-section" id="receipts-content">
        <div class="receipt-container">
            <div class="receipt-header">
                <h2>Receipt Details</h2>
                <p>Transaction #: <span id="receipt-number">TRX-123456</span></p>
            </div>
            
            <div class="receipt-details">
                <div>
                    <p><strong>Date:</strong> <span id="receipt-date">June 15, 2023 14:30</span></p>
                    <p><strong>Cashier:</strong> <span id="receipt-cashier">John Doe</span></p>
                </div>
                <div>
                    <p><strong>Customer:</strong> <span id="receipt-customer">Walk-in Customer</span></p>
                    <p><strong>Payment Method:</strong> <span id="receipt-payment">Cash</span></p>
                </div>
            </div>
            
            <div class="receipt-items" id="receipt-items-list">
                <!-- Receipt items will be added here dynamically -->
            </div>
            
            <div class="receipt-totals">
                <div class="receipt-total-row">
                    <span>Subtotal:</span>
                    <span id="receipt-subtotal">₱0.00</span>
                </div>
                <div class="receipt-total-row">
                    <span>Tax (12%):</span>
                    <span id="receipt-tax">₱0.00</span>
                </div>
                <div class="receipt-total-row receipt-total">
                    <span>TOTAL:</span>
                    <span id="receipt-total">₱0.00</span>
                </div>
            </div>

            <div class="receipt-footer">
                <p>Thank you for shopping with us!</p>
                <p>Please come again</p>
            </div>
        </div>
        <div class="receipt-actions">
            <button class="receipt-btn print-btn" onclick="printReceipt()">
                <i class="fas fa-print"></i> Print Receipt
            </button>
            <button class="receipt-btn close-receipt-btn" onclick="switchView('dashboard')">
                <i class="fas fa-times"></i> Close
            </button>
        </div>
    </div>

    <!-- Inventory View -->
    <div class="inventory-section" id="inventory-content">
        <div class="inventory-container">
            <div class="inventory-header">
                <h2 class="inventory-title">Inventory Management</h2>
                <button class="back-btn" onclick="switchView('dashboard')">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </button>
            </div>
            
            <div class="categories">
                <div class="category active" onclick="filterInventoryItems('All')">All</div>
                <div class="category" onclick="filterInventoryItems('Keyboards')">Keyboards</div>
                <div class="category" onclick="filterInventoryItems('Monitors')">Monitors</div>
                <div class="category" onclick="filterInventoryItems('Mouse')">Mouse</div>
                <div class="category" onclick="filterInventoryItems('Laptops')">Laptops</div>
                <div class="category" onclick="filterInventoryItems('Smartphones')">Smartphones</div>
            </div>
            
            <div class="inventory-grid" id="inventory-grid">
                <!-- Inventory items will be loaded here -->
                <div class="inventory-item" data-id="1" data-category="Keyboards">
                    <img src="https://via.placeholder.com/300x200?text=Keyboard" alt="Mechanical Keyboard" class="inventory-image">
                    <div class="inventory-details">
                        <div class="inventory-name">Mechanical Keyboard (RGB)</div>
                        <div class="inventory-price">₱2,499.00</div>
                        <div class="inventory-stock">Stock: <span class="stock-count">10</span></div>
                        <div class="inventory-category">Keyboards</div>
                        <div class="inventory-actions">
                            <button class="edit-btn" onclick="showEditModal(1)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="delete-btn" onclick="deleteProduct(1)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>

                <div class="inventory-item" data-id="2" data-category="Mouse">
                    <img src="https://via.placeholder.com/300x200?text=Gaming+Mouse" alt="Gaming Mouse" class="inventory-image">
                    <div class="inventory-details">
                        <div class="inventory-name">Gaming Mouse (Wireless)</div>
                        <div class="inventory-price">₱1,599.00</div>
                        <div class="inventory-stock">Stock: <span class="stock-count">15</span></div>
                        <div class="inventory-category">Mouse</div>
                        <div class="inventory-actions">
                            <button class="edit-btn" onclick="showEditModal(2)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="delete-btn" onclick="deleteProduct(2)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>

                <div class="inventory-item" data-id="3" data-category="Monitors">
                    <img src="https://via.placeholder.com/300x200?text=Monitor" alt="27\" Monitor" class="inventory-image">
                    <div class="inventory-details">
                        <div class="inventory-name">27" IPS Monitor (4K)</div>
                        <div class="inventory-price">₱15,999.00</div>
                        <div class="inventory-stock">Stock: <span class="stock-count">5</span></div>
                        <div class="inventory-category">Monitors</div>
                        <div class="inventory-actions">
                            <button class="edit-btn" onclick="showEditModal(3)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="delete-btn" onclick="deleteProduct(3)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>

                <div class="inventory-item" data-id="4" data-category="Laptops">
                    <img src="https://via.placeholder.com/300x200?text=Laptop" alt="Gaming Laptop" class="inventory-image">
                    <div class="inventory-details">
                        <div class="inventory-name">Gaming Laptop (RTX 3060)</div>
                        <div class="inventory-price">₱65,999.00</div>
                        <div class="inventory-stock">Stock: <span class="stock-count">3</span></div>
                        <div class="inventory-category">Laptops</div>
                        <div class="inventory-actions">
                            <button class="edit-btn" onclick="showEditModal(4)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="delete-btn" onclick="deleteProduct(4)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>

                <div class="inventory-item" data-id="5" data-category="Smartphones">
                    <img src="https://via.placeholder.com/300x200?text=Smartphone" alt="Smartphone" class="inventory-image">
                    <div class="inventory-details">
                        <div class="inventory-name">Flagship Smartphone (128GB)</div>
                        <div class="inventory-price">₱39,999.00</div>
                        <div class="inventory-stock">Stock: <span class="stock-count">8</span></div>
                        <div class="inventory-category">Smartphones</div>
                        <div class="inventory-actions">
                            <button class="edit-btn" onclick="showEditModal(5)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="delete-btn" onclick="deleteProduct(5)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="edit-modal" id="edit-modal">
        <div class="edit-content">
            <div class="edit-header">
                <h3 class="edit-title">Edit Product</h3>
                <button class="close-edit" onclick="closeEditModal()">&times;</button>
            </div>
            <div class="edit-form-group">
                <label for="edit-name">Product Name</label>
                <input type="text" id="edit-name" value="Mechanical Keyboard (RGB)">
            </div>
            <div class="edit-form-group">
                <label for="edit-price">Price</label>
                <input type="number" id="edit-price" value="2499">
            </div>
            <div class="edit-form-group">
                <label for="edit-stock">Stock Quantity</label>
                <input type="number" id="edit-stock" value="10">
            </div>
            <div class="edit-form-group">
                <label for="edit-category">Category</label>
                <select id="edit-category">
                    <option value="Keyboards">Keyboards</option>
                    <option value="Mouse">Mouse</option>
                    <option value="Monitors">Monitors</option>
                    <option value="Laptops">Laptops</option>
                    <option value="Smartphones">Smartphones</option>
                </select>
            </div>
            <div class="edit-form-group">
                <label for="edit-image">Image URL</label>
                <input type="text" id="edit-image" value="https://via.placeholder.com/300x200?text=Keyboard">
            </div>
            <div class="edit-actions">
                <button class="cancel-btn" onclick="closeEditModal()">Cancel</button>
                <button class="save-btn" onclick="saveProduct()">Save Changes</button>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let cart = [];
        let currentView = 'dashboard';
        let receipts = [];
        let products = [
            { id: 1, name: "Mechanical Keyboard (RGB)", price: 2499, stock: 10, category: "Keyboards", image: "https://via.placeholder.com/300x200?text=Keyboard" },
            { id: 2, name: "Gaming Mouse (Wireless)", price: 1599, stock: 15, category: "Mouse", image: "https://via.placeholder.com/300x200?text=Gaming+Mouse" },
            { id: 3, name: "27\" IPS Monitor (4K)", price: 15999, stock: 5, category: "Monitors", image: "https://via.placeholder.com/300x200?text=Monitor" },
            { id: 4, name: "Gaming Laptop (RTX 3060)", price: 65999, stock: 3, category: "Laptops", image: "https://via.placeholder.com/300x200?text=Laptop" },
            { id: 5, name: "Flagship Smartphone (128GB)", price: 39999, stock: 8, category: "Smartphones", image: "https://via.placeholder.com/300x200?text=Smartphone" }
        ];
        let currentEditId = null;

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            updateCartDisplay();
            switchView('dashboard');
            
            // Load sample receipts data
            loadReceipts();
        });

        // Switch between views
        function switchView(view) {
            document.getElementById(currentView + '-content').style.display = 'none';
            document.getElementById(view + '-content').style.display = 'block';
            document.getElementById(currentView + '-button').classList.remove('active');
            document.getElementById(view + '-button').classList.add('active');
            currentView = view;
            
            // Update cart display when switching to cart view
            if (view === 'cart') {
                updateCartDisplay(true);
            }
        }

        // Cart functions
        function addToCart(name, price, image, maxQuantity) {
            const existingItem = cart.find(item => item.name === name);
            if (existingItem) {
                if (existingItem.quantity < maxQuantity) {
                    existingItem.quantity++;
                } else {
                    alert(`Cannot add more than ${maxQuantity} of this item.`);
                    return;
                }
            } else {
                cart.push({
                    name,
                    price,
                    image,
                    quantity: 1,
                    maxQuantity
                });
            }

            updateCartDisplay();
            updateCartCount();
        }

        function removeFromCart(index, quantity = 1) {
            if (cart[index].quantity > quantity) {
                cart[index].quantity -= quantity;
            } else {
                cart.splice(index, 1);
            }
            updateCartDisplay();
            updateCartCount();
        }

        function updateCartDisplay(isCartView = false) {
            // Update cart items list
            const itemsContainer = document.getElementById('cart-items');
            itemsContainer.innerHTML = '';
            
            let subtotal = 0;
            
            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                
                const itemElement = document.createElement('div');
                itemElement.className = 'cart-item';
                itemElement.innerHTML = `
                    <div class="cart-item-info">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                        <div class="cart-item-details">
                            <div class="cart-item-name">${item.name}</div>
                            <div class="cart-item-price">₱${item.price.toFixed(2)}</div>
                        </div>
                    </div>
                    <div class="cart-item-controls">
                        <button class="qty-btn" onclick="event.stopPropagation(); removeFromCart(${index})">-</button>
                        <div class="cart-item-qty">${item.quantity}</div>
                        <button class="qty-btn" onclick="event.stopPropagation(); addToCart('${item.name}', ${item.price}, '${item.image}', ${item.maxQuantity})">+</button>
                        <button class="remove-btn" onclick="event.stopPropagation(); removeFromCart(${index}, ${item.quantity})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                
                itemsContainer.appendChild(itemElement);
            });
            
            // Update totals
            const tax = subtotal * 0.12;
            const total = subtotal + tax;
            
            document.getElementById('cart-subtotal').textContent = `₱${subtotal.toFixed(2)}`;
            document.getElementById('cart-tax').textContent = `₱${tax.toFixed(2)}`;
            document.getElementById('cart-total').textContent = `₱${total.toFixed(2)}`;
            
            // Save to localStorage
            localStorage.setItem('nexusCart', JSON.stringify(cart));
        }
        
        function updateCartCount() {
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cart-count').textContent = count;
        }
        
        // Receipt functions
        function generateReceipt() {
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            
            // Calculate totals
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const tax = subtotal * 0.12;
            const total = subtotal + tax;
            
            // Update product stock
            cart.forEach(cartItem => {
                const product = products.find(p => p.name === cartItem.name);
                if (product) {
                    product.stock -= cartItem.quantity;
                    updateProductStockInUI(product.id, product.stock);
                }
            });
            
            // Create receipt object
            const receipt = {
                id: 'TRX-' + Math.floor(Math.random() * 1000000),
                date: new Date(),
                items: [...cart],
                subtotal,
                tax,
                total,
                cashier: 'John Doe',
                customer: 'Walk-in Customer',
                paymentMethod: 'Cash'
            };
            
            // Add to receipts
            receipts.push(receipt);
            localStorage.setItem('nexusReceipts', JSON.stringify(receipts));
            
            // Clear cart
            cart = [];
            updateCartDisplay(true);
            updateCartCount();
            
            // Show receipt
            displayReceipt(receipt);
            switchView('receipts');
        }
        
        function displayReceipt(receipt) {
            document.getElementById('receipt-number').textContent = receipt.id;
            document.getElementById('receipt-date').textContent = receipt.date.toLocaleDateString() + ' ' + receipt.date.toLocaleTimeString();
            document.getElementById('receipt-cashier').textContent = receipt.cashier;
            document.getElementById('receipt-customer').textContent = receipt.customer;
            document.getElementById('receipt-payment').textContent = receipt.paymentMethod;
            
            const receiptItemsList = document.getElementById('receipt-items-list');
            receiptItemsList.innerHTML = '';
            
            receipt.items.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = 'receipt-item';
                itemElement.innerHTML = `
                    <div>${item.quantity} x ${item.name}</div>
                    <div>₱${(item.price * item.quantity).toFixed(2)}</div>
                `;
                receiptItemsList.appendChild(itemElement);
            });
            
            document.getElementById('receipt-subtotal').textContent = `₱${receipt.subtotal.toFixed(2)}`;
            document.getElementById('receipt-tax').textContent = `₱${receipt.tax.toFixed(2)}`;
            document.getElementById('receipt-total').textContent = `₱${receipt.total.toFixed(2)}`;
        }
        
        function loadReceipts() {
            // In a real application, this would fetch from a database
            receipts = [
                {
                    id: 'TRX-123456',
                    date: new Date('2023-06-15T14:30:00'),
                    items: [
                        { name: 'Mechanical Keyboard (RGB)', price: 2499, quantity: 1 },
                        { name: 'Gaming Mouse (Wireless)', price: 1599, quantity: 2 }
                    ],
                    subtotal: 5697,
                    tax: 683.64,
                    total: 6380.64,
                    cashier: 'John Doe',
                    customer: 'Walk-in Customer',
                    paymentMethod: 'Cash'
                }
            ];
            
            localStorage.setItem('nexusReceipts', JSON.stringify(receipts));
        }
        
        function printReceipt() {
            // In a real application, this would print the receipt
            const printContent = document.getElementById('receipts-content').innerHTML;
            const originalContent = document.body.innerHTML;
            
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            
            // Restore view
            switchView('receipts');
        }
        
        // Inventory functions
        function showEditModal(id) {
            const product = products.find(p => p.id === id);
            if (!product) return;
            
            currentEditId = id;
            document.getElementById('edit-name').value = product.name;
            document.getElementById('edit-price').value = product.price;
            document.getElementById('edit-stock').value = product.stock;
            document.getElementById('edit-category').value = product.category;
            document.getElementById('edit-image').value = product.image;
            
            document.getElementById('edit-modal').style.display = 'flex';
        }
        
        function closeEditModal() {
            document.getElementById('edit-modal').style.display = 'none';
            currentEditId = null;
        }
        
        function saveProduct() {
            if (currentEditId === null) return;
            
            const product = products.find(p => p.id === currentEditId);
            if (!product) return;
            
            // Update product data
            product.name = document.getElementById('edit-name').value;
            product.price = parseInt(document.getElementById('edit-price').value);
            product.stock = parseInt(document.getElementById('edit-stock').value);
            product.category = document.getElementById('edit-category').value;
            product.image = document.getElementById('edit-image').value;
            
            // Update UI
            const productElement = document.querySelector(`.inventory-item[data-id="${currentEditId}"]`);
            if (productElement) {
                productElement.querySelector('.inventory-name').textContent = product.name;
                productElement.querySelector('.inventory-price').textContent = `₱${product.price.toFixed(2)}`;
                productElement.querySelector('.stock-count').textContent = product.stock;
                productElement.querySelector('.inventory-category').textContent = product.category;
                productElement.setAttribute('data-category', product.category);
                productElement.querySelector('.inventory-image').src = product.image;
            }
            
            // Also update the product in the dashboard if it exists
            const dashboardItem = document.querySelector(`.item-card[data-name="${product.name}"]`);
            if (dashboardItem) {
                dashboardItem.setAttribute('data-category', product.category);
                dashboardItem.querySelector('.item-name').textContent = product.name;
                dashboardItem.querySelector('.item-price').textContent = `₱${product.price.toFixed(2)}`;
                dashboardItem.querySelector('.item-image').src = product.image;
            }
            
            alert('Product changes saved!');
            closeEditModal();
        }

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                // Remove from products array
                products = products.filter(p => p.id !== id);
                
                // Remove from UI
                const productElement = document.querySelector(`.inventory-item[data-id="${id}"]`);
                if (productElement) {
                    productElement.remove();
                }
                
                // Also remove from dashboard if it exists
                const product = products.find(p => p.id === id);
                if (product) {
                    const dashboardItem = document.querySelector(`.item-card[data-name="${product.name}"]`);
                    if (dashboardItem) {
                        dashboardItem.remove();
                    }
                }
                
                alert('Product deleted successfully');
            }
        }
        
        function updateProductStockInUI(productId, newStock) {
            const productElement = document.querySelector(`.inventory-item[data-id="${productId}"]`);
            if (productElement) {
                productElement.querySelector('.stock-count').textContent = newStock;
            }
        }
        
        function filterInventoryItems(category) {
            const items = document.querySelectorAll('.inventory-item');
            
            items.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                
                if (category === 'All' || itemCategory === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Update active category
            document.querySelectorAll('.inventory-container .category').forEach(cat => {
                cat.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // Search and barcode functions
        function searchItems() {
            const query = document.getElementById('search-input').value.toLowerCase();
            const items = document.querySelectorAll('.item-card');
            
            items.forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                if (name.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function toggleBarcodeInput() {
            const barcodeScanner = document.getElementById('barcode-scanner');
            const barcodeInput = document.getElementById('barcode-input');
            
            if (barcodeInput.style.display === 'none') {
                barcodeInput.style.display = 'block';
                barcodeScanner.classList.add('expanded');
                barcodeInput.focus();
            } else {
                barcodeInput.style.display = 'none';
                barcodeScanner.classList.remove('expanded');
            }
        }

        function scanBarcode() {
            const barcode = document.getElementById('barcode-input').value;
            
            // In a real application, this would search for the barcode
            if (barcode.length > 0) {
                alert(`Searching for barcode: ${barcode}`);
                document.getElementById('barcode-input').value = '';
                toggleBarcodeInput();
            }
        }

        // Filter items by category
        function filterItems(category) {
            const items = document.querySelectorAll('.item-card');
            
            items.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                
                if (category === 'All' || itemCategory === category) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });

            // Update active category
            document.querySelectorAll('.category').forEach(cat => {
                cat.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // Logout function
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                alert('You have been logged out');
                // In a real application, this would redirect to login page
            }
        }
    </script>
</body>
</html>