<?php 
session_start();

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
        if ($rank === "staff") {
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/defaultpanel.css">
    <title>NexusGadgets POS</title>
</head>
<body>
    <!-- Header -->
    <div class="py-3"> <!-- Removed container mx-auto px-4 -->
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
                    <a href="#" class="flex items-center">
                        <img src="images/NEXUS GADGETS.png" alt="NEXUS GADGETS Logo" class="w-24 h-24 mr-6">
                        <span class="text-3xl font-bold superdario-font tracking-wide">
                            NEXUS <span class="text-indigo-400 superdario-font tracking-wide">GADGETS</span>
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
                    <!-- Logout Button -->
                    <button id="logout-btn" onclick="logoutUser()" title="Logout" style="margin-left: 1rem; background: none; border: none; cursor: pointer;">
                        <i class="fas fa-sign-out-alt text-white text-xl"></i>
                    </button>
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
                <button onclick="showEwalletModal()" class="checkout-btn">E-wallet</button>
            </div>
            <button style="margin-top:2rem; color:#94a3b8; background:none; border:none;" onclick="closePaymentModal()">Cancel</button>
        </div>
    </div>

    <!-- E-wallet Modal -->
    <div id="ewallet-modal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:101; background:rgba(0,0,0,0.6); align-items:center; justify-content:center;">
        <div style="background:#172a45; padding:2rem; border-radius:0.75rem; min-width:300px; box-shadow:0 8px 32px rgba(0,0,0,0.3); color:white; text-align:center;">
            <h2 style="font-size:1.25rem; font-weight:600; margin-bottom:1rem;">Select E-wallet</h2>
            <div style="display:flex; flex-direction:column; gap:1rem;">
                <button onclick="selectPayment('PayMaya')" class="checkout-btn">PayMaya</button>
                <button onclick="selectPayment('GCash')" class="checkout-btn">GCash</button>
            </div>
            <button style="margin-top:2rem; color:#94a3b8; background:none; border:none;" onclick="closeEwalletModal()">Cancel</button>
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

    <!-- Cash Input Modal -->
    <div id="cash-modal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:102; background:rgba(0,0,0,0.6); align-items:center; justify-content:center;">
        <div style="background:#172a45; padding:2rem; border-radius:0.75rem; min-width:300px; box-shadow:0 8px 32px rgba(0,0,0,0.3); color:white; text-align:center;">
            <h2 style="font-size:1.25rem; font-weight:600; margin-bottom:1rem;">Enter Cash Amount</h2>
            <div id="cash-total-display" style="margin-bottom:1rem; font-size:1.5rem; color:#6366f1;"></div>
            <div id="cash-modal-alert" style="display:none; color:#f87171; font-size:0.875rem; margin-bottom:1rem;"></div>
            <input type="number" id="cash-input" step="0.01" style="width:100%; padding:0.5rem; border-radius:0.375rem; margin-bottom:1rem; background:#1f3556; color:white; border:1px solid #6366f1;" placeholder="Enter amount">
            <div style="display:flex; flex-direction:column; gap:1rem;">
                <button onclick="processCashPayment()" class="checkout-btn">Submit</button>
                <button onclick="closeCashModal()" style="color:#94a3b8; background:none; border:none;">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let cart = [];
        let products = [];

        document.addEventListener('DOMContentLoaded', function() {
            fetchInventoryItems(); // Replace loadProducts() with fetchInventoryItems()
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

        function fetchInventoryItems() {
            fetch('php/get_inventory_items.php')
                .then(response => response.json())
                .then(data => {
                    products = data;
                    loadProducts();
                })
                .catch(error => {
                    console.error('Error fetching inventory:', error);
                    showAlert('Failed to load inventory items', 'error');
                });
        }

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
                    <img src="uploads/${product.image}" alt="${product.name}" class="product-image">
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

        // Update addToCart to work with database fields
        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;
            const existingItem = cart.find(item => item.id === productId);
            if (existingItem) {
                if (existingItem.quantity < product.quantity) {
                    existingItem.quantity++;
                } else {
                    showAlert(`Cannot add more than ${product.quantity} of this item.`);
                    return;
                }
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: parseFloat(product.price),
                    image: product.image,
                    quantity: 1,
                    maxQuantity: product.quantity
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

        // Update updateCartDisplay to show total price per item
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
            itemsContainer.innerHTML = ''; // Clear previous items

            cart.forEach((item, index) => {
                const itemElement = document.createElement('div');
                itemElement.className = 'order-item';
                itemElement.innerHTML = `
                    <div class="order-item-info">
                        <img src="uploads/${item.image}" alt="${item.name}" class="order-item-image">
                        <div class="order-item-details">
                            <div class="order-item-name">${item.name}</div>
                            <div class="order-item-price">₱${(item.price * item.quantity).toFixed(2)}</div>
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
            document.getElementById('ewallet-modal').style.display = 'none'; // Ensure e-wallet modal is hidden

            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const tax = subtotal * 0.12;
            const total = subtotal + tax;

            if (method === 'Cash') {
                document.getElementById('cash-total-display').textContent = `Total: ₱${total.toFixed(2)}`;
                document.getElementById('cash-modal').style.display = 'flex';
                document.getElementById('cash-input').value = '';
                return;
            }

            if (method === 'PayMaya' || method === 'GCash') {
                // Hide PayMaya and GCash buttons
                const ewalletButtons = document.querySelectorAll('#ewallet-modal .checkout-btn');
                ewalletButtons.forEach(button => button.style.display = 'none');
                showAlert(`${method} selected. Puchase complete. Thank you!`, 'success');
            }

            generateReceipt(method);
        }

        function processCashPayment() {
            const cashInput = document.getElementById('cash-input');
            const cashAmount = parseFloat(cashInput.value);
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0) * 1.12; // Including tax

            const alertContainer = document.getElementById('cash-modal-alert');
            if (isNaN(cashAmount) || cashAmount < total) {
                alertContainer.textContent = 'Insufficient amount!';
                alertContainer.style.display = 'block';
                return;
            }

            alertContainer.style.display = 'none';
            document.getElementById('cash-modal').style.display = 'none';
            showAlert('Purchase complete. Thank you!', 'success'); // Add success alert
            generateReceipt('Cash', cashAmount);
        }

        function closeCashModal() {
            document.getElementById('cash-modal').style.display = 'none';
        }

        function generateReceipt(method, cashAmount = null) {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const tax = subtotal * 0.12;
            const total = subtotal + tax;
            const now = new Date();
            const change = cashAmount ? cashAmount - total : 0;

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
                ${
                    method === 'Cash'
                    ? `<div style="display:flex; justify-content:space-between;">
                            <span>Cash</span><span>₱${cashAmount.toFixed(2)}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between;">
                            <span>Change</span><span>₱${change.toFixed(2)}</span>
                        </div>`
                    : ''
                }
                <hr>
                <div style="text-align:center; margin-top:1rem;">Thank you!</div>
            `;
            document.getElementById('receipt-content').innerHTML = receiptHtml;

            // Record transaction in the database
            const purchaseList = cart.map(item => `${item.name} (x${item.quantity})`).join(', ');
            fetch('php/transactions.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    purchaseList: purchaseList,
                    subtotalAmount: parseFloat(subtotal.toFixed(2)),
                    totalAmount: parseFloat(total.toFixed(2)),
                    paymentMethod: method,
                    cashAmount: parseFloat((method === 'Cash' ? cashAmount : total).toFixed(2)),
                    changeAmount: parseFloat((method === 'Cash' ? change : 0).toFixed(2))
                })
            }).catch(error => console.error('Error recording transaction:', error));

            // Update product sales in the database
            cart.forEach(cartItem => {
                fetch('php/update_sales.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: cartItem.id, quantity: cartItem.quantity })
                }).catch(error => console.error('Error updating sales:', error));
            });

            // Update weekly profits
            fetch('php/update_profits.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ profit: subtotal })
            }).catch(error => console.error('Error updating profits:', error));

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

        function showEwalletModal() {
            document.getElementById('payment-modal').style.display = 'none';
            document.getElementById('ewallet-modal').style.display = 'flex';
        }

        function closeEwalletModal() {
            document.getElementById('ewallet-modal').style.display = 'none';
        }

        // Logout function
        function logoutUser() {
            // Optionally clear localStorage or session data here
            localStorage.removeItem('nexusCart');
            window.location.href = 'php/logout.php'; // Redirect to your logout handler
        }
    </script>
</body>
</html>