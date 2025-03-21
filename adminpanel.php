<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminpanel.css">
    <title>Dessert Ordering System</title>
    <style>
        .sidebar-icon.logo img {
            border-radius: 50%;
        }
    </style>
</head>
<body>
    
    <div class="sidebar">
        <div class="sidebar-icon logo">
            <img src="images/logo.png" alt="Logo" width="24" height="24">
            <span class="sidebar-text">Logo</span>
        </div>
        <div class="sidebar-icon active" id="dashboard-button" onclick="switchView('dashboard')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span class="sidebar-text">Dashboard</span>
        </div>
        <div class="sidebar-icon" id="upload-button" onclick="switchView('upload')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            <span class="sidebar-text">Upload</span>
        </div>
        <div class="sidebar-icon" id="products-button" onclick="switchView('products')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            <span class="sidebar-text">Products</span>
        </div>
        <div style="flex: 1;"></div>
        <div class="sidebar-icon" id="settings-button" onclick="switchView('settings')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            <span class="sidebar-text">Settings</span>
        </div>
        <div class="sidebar-icon" id="logout-button" onclick="switchView('logout')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            <span class="sidebar-text">Logout</span>
        </div>
    </div>

    
    <div class="main-content" id="dashboard-content">
        <div class="header">
            <div class="header-titles">
                <div class="items-label">Items</div>
                <h1>Gadgets</h1>
            </div>
            <div class="search-container">
                <div class="search-bar" id="search-bar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="Search..." id="search-input" oninput="searchItems()">
                </div>
                <div class="barcode-scanner" id="barcode-scanner">
                    <div class="barcode-icon-wrapper" onclick="toggleBarcodeInput()">
                        <svg id="barcode-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin: auto;"><path d="M2 2h20v20H2z"/><path d="M7 2v20M17 2v20M12 2v20M2 7h20M2 17h20"/></svg>
                    </div>
                    <input type="text" placeholder="Scan barcode..." id="barcode-input" oninput="scanBarcode()" style="display: none;">
                </div>
            </div>
        </div>

        <div class="categories">
            <?php
            $categories = ["Keyboards", "Monitors", "Mice", "Laptops", "Smartphones"];
            $currentCategory = isset($_GET['category']) ? $_GET['category'] : 'Keyboards';
            foreach ($categories as $category) {
                $activeClass = $category === $currentCategory ? 'active' : '';
                echo "<div class='category $activeClass' onclick=\"filterItems('$category')\">$category</div>";
            }
            ?>
        </div>

        <div class="items-grid" id="items-grid">
            <?php
            include "php/conn_db.php";

            $sql = "SELECT c.Category_name, c.Category_desc, p.Product_name, p.Product_brand, p.Product_price, p.Product_desc AS image, p.Product_quantity 
                    FROM categories c 
                    LEFT JOIN products p ON c.Category_id = p.Category_id 
                    WHERE c.Category_name = ? AND p.Product_name IS NOT NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $currentCategory);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='item-card hidden' data-name='{$row['Product_name']}'>
                        <img src='{$row['image']}' alt='{$row['Product_name']}' class='item-image'>
                        <div class='item-details'>
                            <div class='item-name'>{$row['Product_name']}</div>
                            <div class='item-price'>₱" . number_format($row['Product_price'], 2) . "</div>
                            <button class='add-btn' onclick=\"addToCart('{$row['Product_name']}', {$row['Product_price']}, '{$row['image']}', {$row['Product_quantity']})\">ADD</button>
                        </div>
                    </div>";
                }
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>

        
        <div class="cart-container">
            <div class="cart-header">
                <h2>Current Order</h2>
            </div>
            <div class="cart-user">
                <div class="cart-user-avatar">EW</div>
                <div>Emma Wang</div>
            </div>
            <div class="cart-items" id="cart-items">
            </div>
            <div class="cart-summary">
                <div class="cart-row">
                    <div>Subtotal</div>
                    <div id="subtotal">₱0.00</div>
                </div>
                <div class="cart-row">
                    <div>Discount</div>
                    <div id="discount">₱0.00</div>
                </div>
                <div class="cart-row">
                    <div>Service Charge</div>
                    <div id="service-charge">20%</div>
                </div>
                <div class="cart-row">
                    <div>Tax</div>
                    <div id="tax">₱0.00</div>
                </div>
                <div class="cart-row cart-total">
                    <div>Total</div>
                    <div id="total">₱0.00</div>
                </div>
            </div>
            <button class="checkout-btn">Continue</button>
        </div>
    </div>

    
    <div class="upload-content" id="upload-content" style="display: none;">
        <h1>Upload Section</h1>
    </div>

    
    <div class="products-content" id="products-content" style="display: none;">
        <h1>Products Section</h1>
    </div>

    
    <div class="settings-content" id="settings-content" style="display: none;">
        <h1>Settings Section</h1>
    </div>


    <div class="logout-content" id="logout-content" style="display: none;">
        <h1>Logout Section</h1>
    </div>

    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const serviceChargePercentage = 0.20;
        const taxRate = 0.05;

        function addToCart(name, price, image, maxQuantity) {
            const existingItem = cart.find(item => item.name === name && item.price === price);
            
            if (existingItem) {
                if (existingItem.quantity < maxQuantity) {
                    existingItem.quantity += 1;
                } else {
                    alert('Cannot add more than available quantity');
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
            
            updateCart();
        }

        function removeFromCart(index) {
            if (cart[index].quantity > 1) {
                cart[index].quantity -= 1;
            } else {
                cart.splice(index, 1);
            }
            
            updateCart();
        }

        function updateCart() {
            const cartItemsContainer = document.getElementById('cart-items');
            cartItemsContainer.innerHTML = '';
            
            let subtotal = 0;
            
            cart.forEach((item, index) => {
                subtotal += item.price * item.quantity;
                
                const cartItemElement = document.createElement('div');
                cartItemElement.className = 'cart-item';
                cartItemElement.innerHTML = `
                    <div class="cart-item-info">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                        <div class="cart-item-details">
                            <div class="cart-item-name">${item.name}</div>
                            <div class="cart-item-price">₱${item.price.toFixed(2)}</div>
                        </div>
                    </div>
                    <div class="cart-item-quantity">
                        <button class="qty-btn" onclick="removeFromCart(${index})">-</button>
                        <div class="cart-item-qty">${item.quantity}</div>
                        <button class="qty-btn" onclick="addToCart('${item.name}', ${item.price}, '${item.image}', ${item.maxQuantity})">+</button>
                    </div>
                `;
                
                cartItemsContainer.appendChild(cartItemElement);
            });
            
            const discount = 0;
            const serviceCharge = subtotal * serviceChargePercentage;
            const tax = subtotal * taxRate;
            const total = subtotal + serviceCharge + tax - discount;
            
            document.getElementById('subtotal').textContent = `₱${subtotal.toFixed(2)}`;
            document.getElementById('discount').textContent = `₱${discount.toFixed(2)}`;
            document.getElementById('tax').textContent = `₱${tax.toFixed(2)}`;
            document.getElementById('total').textContent = `₱${total.toFixed(2)}`;

            localStorage.setItem('cart', JSON.stringify(cart)); // Save cart to local storage
        }

        function filterItems(category) {
            const items = document.querySelectorAll('.item-card');
            items.forEach(item => {
                item.classList.add('hidden'); // Add hidden class for smooth transition
            });

            setTimeout(() => {
                window.location.href = `?category=${category}`;
            }, 100); // Shorter delay to allow transition to complete
        }

        document.addEventListener('DOMContentLoaded', () => {
            const items = document.querySelectorAll('.item-card');
            setTimeout(() => {
                items.forEach(item => {
                    item.classList.remove('hidden'); // Remove hidden class after delay
                });
            }, 100); // Shorter delay to allow transition to complete

            updateCart(); // Update cart on page load
        });

        function searchItems() {
            const query = document.getElementById('search-input').value.toLowerCase();
            const items = document.querySelectorAll('.item-card');
            
            items.forEach(item => {
                const itemName = item.getAttribute('data-name').toLowerCase();
                if (itemName.includes(query)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function scanBarcode() {
            const barcode = document.getElementById('barcode-input').value;
            console.log('Scanned barcode:', barcode);
        }

        function toggleBarcodeInput() {
            const barcodeScanner = document.getElementById('barcode-scanner');
            const searchBar = document.getElementById('search-bar');
            const barcodeInput = document.getElementById('barcode-input');
            const barcodeIconWrapper = document.querySelector('.barcode-icon-wrapper');

            if (barcodeInput.style.display === 'none') {
                barcodeInput.style.display = 'block';
                barcodeScanner.classList.add('expanded');
                barcodeInput.focus();
            } else {
                barcodeInput.style.display = 'none';
                barcodeScanner.classList.remove('expanded');
            }
        }

        function switchView(view) {
            // Hide all content sections
            document.getElementById('dashboard-content').style.display = 'none';
            document.getElementById('upload-content').style.display = 'none';
            document.getElementById('products-content').style.display = 'none';
            document.getElementById('settings-content').style.display = 'none';
            document.getElementById('logout-content').style.display = 'none';

            // Show the selected content section
            document.getElementById(`${view}-content`).style.display = 'block';

            // Remove active class from all sidebar icons
            document.querySelectorAll('.sidebar-icon').forEach(icon => {
                icon.classList.remove('active');
            });

            // Add active class to the selected sidebar icon
            document.getElementById(`${view}-button`).classList.add('active');

            // Update the URL to remove the category parameter
            const url = new URL(window.location.href);
            url.searchParams.delete('category');
            window.history.pushState({}, '', url);
        }

        
        document.querySelectorAll('.category').forEach(category => {
            category.addEventListener('click', function() {
                document.querySelector('.category.active').classList.remove('active');
                this.classList.add('active');
                filterItems(this.textContent);
            });
        });
    </script>
</body>
</html>
