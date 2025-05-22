<?php 
session_start();


if (isset($_session))



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/defaultpanel.css">
    <title>NexusGadgets POS</title>
    <style>
        /* Hide all views initially to prevent flashing */
        .main-content, .cart-section, .receipt-section, .inventory-section {
            display: none;
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
            <!-- Items will be loaded dynamically -->
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
                <button class="checkout-btn" onclick="placeOrder()">Place Order</button>
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

        // Restore the last view from localStorage on page load
        document.addEventListener('DOMContentLoaded', function() {
            const lastView = localStorage.getItem('currentView') || 'dashboard';
            switchView(lastView);
            updateCartDisplay();
            loadItemsGrid(); // Load items from the database
            
            // Load sample receipts data
            loadReceipts();
        });

        // Switch between views
        function switchView(view) {
            // Hide all views
            document.querySelectorAll('.main-content, .cart-section, .receipt-section, .inventory-section').forEach(section => {
                section.style.display = 'none';
            });

            // Show the selected view
            document.getElementById(view + '-content').style.display = 'block';

            // Update active sidebar button
            document.querySelectorAll('.sidebar-icon').forEach(button => {
                button.classList.remove('active');
            });
            document.getElementById(view + '-button').classList.add('active');

            // Save the current view to localStorage
            currentView = view;
            localStorage.setItem('currentView', view);

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
        function placeOrder() {
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
            const receiptContent = document.querySelector('.receipt-container').innerHTML; // Select only the receipt details
            const newWindow = window.open('', '_blank');
            newWindow.document.write(`
                <html>
                <head>
                    <title>Print Receipt</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 20px;
                        }
                        .receipt-container {
                            max-width: 600px;
                            margin: auto;
                        }
                        .receipt-header, .receipt-details, .receipt-items, .receipt-totals, .receipt-footer {
                            margin-bottom: 20px;
                        }
                        .receipt-header h2 {
                            text-align: center;
                        }
                        .receipt-totals {
                            font-weight: bold;
                        }
                    </style>
                </head>
                <body>
                    <div class="receipt-container">
                        ${receiptContent}
                    </div>
                </body>
                </html>
            `);
            newWindow.document.close();
            newWindow.print();
            newWindow.close();
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
            if (barcode.length > 0) {
                fetch('php/barcode_scan.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'barcode=' + encodeURIComponent(barcode)
                })
                .then(response => response.json())
                .then(product => {
                    if (product && product.name && product.price && product.image && product.quantity) {
                        addToCart(
                            product.name.replace(/'/g, "\\'"),
                            parseFloat(product.price),
                            product.image,
                            parseInt(product.quantity)
                        );
                    } else {
                        alert('Product not found for barcode: ' + barcode);
                    }
                })
                .catch(() => {
                    alert('Error scanning barcode.');
                })
                .finally(() => {
                    document.getElementById('barcode-input').value = '';
                    toggleBarcodeInput();
                });
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

        // Fetch and render items from the database
        function loadItemsGrid(category = 'All') {
            const url = category && category !== 'All'
                ? `php/get_inventory_items.php?inventory_category=${encodeURIComponent(category)}`
                : 'php/get_inventory_items.php';

            fetch(url)
                .then(response => response.json())
                .then(items => {
                    const grid = document.getElementById('items-grid');
                    grid.innerHTML = '';
                    if (!Array.isArray(items) || items.length === 0) {
                        grid.innerHTML = '<div style="padding:2rem;">No products found.</div>';
                        return;
                    }
                    items.forEach(item => {
                        const card = document.createElement('div');
                        card.className = 'item-card';
                        card.setAttribute('data-name', item.name);
                        card.setAttribute('data-category', item.category);

                        card.innerHTML = `
                            <img src="${item.image || 'https://via.placeholder.com/300x200?text=No+Image'}" alt="${item.name}" class="item-image">
                            <div class="item-details">
                                <div class="item-name">${item.name}</div>
                                <div class="item-price">₱${parseFloat(item.price).toLocaleString(undefined, {minimumFractionDigits: 2})}</div>
                                <button class="add-btn" onclick="addToCart('${item.name.replace(/'/g, "\\'")}', ${parseFloat(item.price)}, '${item.image}', ${parseInt(item.quantity)})">
                                    Add to Cart
                                </button>
                            </div>
                        `;
                        grid.appendChild(card);
                    });
                })
                .catch(() => {
                    document.getElementById('items-grid').innerHTML = '<div style="padding:2rem;">Failed to load products.</div>';
                });
        }
    </script>
</body>
</html>