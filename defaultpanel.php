<?php

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
} else {
    include "php/conn_db.php";
    $username = $_SESSION['user'];
    $stmt = $conn->prepare("SELECT u.username, r.rank_name FROM users u JOIN ranks r ON u.rank_id = r.rank_id WHERE u.username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_rank = $result->fetch_assoc();
    $conn->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/adminpanel.css">
    <title>Default Panel</title>
</head>
<body>
<div class="sidebar">
        <div class="sidebar-icon logo">
            <img src="images/logo4.webp" alt="Logo" width="24" height="24">
        </div>
        <div class="sidebar-icon active" id="dashboard-button" onclick="switchView('dashboard')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span class="sidebar-text">Dashboard</span>
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
        <div class="sidebar-icon" id="logout-button" onclick="logout()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            <span class="sidebar-text">Logout</span>
        </div>
    </div>
    <div class="main-content" id="dashboard-content">
        <div class="header">
            <div class="header-titles">
                <div class="items-label"><p><b>WELCOME</b></p> </div>
                <h1>Nexus Gadgets</h1>
            </div>
            <div class="search-container">
                <div class="search-bar" id="search-bar">
                    <div class="search-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div> 
                    <input type="text" placeholder="Search..." id="search-input" oninput="searchItems()">
                </div>
                <div class="barcode-scanner" id="barcode-scanner">
                    <div class="barcode-icon-wrapper" onclick="toggleBarcodeInput()">
                        <svg id="barcode-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin: auto;"><path d="M2 2h20v20H2z"/><path d="M7 2v20M17 2v20M12 2v20M2 7h20M2 17h20"/></svg>
                    </div>
                    <input type="text" placeholder="Scan barcode..." id="barcode-input" oninput="scanBarcode()" style="display: none;">
                </div>
            </div>
        </div>

        <div class="categories">
            <?php
            $categories = ["All", "Keyboards", "Monitors", "Mouse", "Laptops", "Smartphones"];
            $currentCategory = isset($_GET['category']) ? $_GET['category'] : 'All';
            foreach ($categories as $category) {
                $activeClass = $category === $currentCategory ? 'active' : '';
                echo "<div class='category $activeClass' onclick=\"filterItems('$category')\">$category</div>";
            }
            ?>
        </div>

        <div class="items-grid" id="items-grid">
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const currentCategory = "<?php echo $currentCategory; ?>";
                    fetch(`php/get_items.php?category=${currentCategory}`)
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('items-grid').innerHTML = data;
                            setTimeout(() => {
                                const newItems = document.querySelectorAll('.item-card');
                                newItems.forEach(item => {
                                    item.classList.remove('hidden');
                                });
                            }, 100);
                        });
                });
            </script>
        </div>

        
        <div class="cart-container" id="cart-container">
            <div class="cart-header">
                <h2>Current Order</h2>
            
            </div>
    <div class="cart-user">
        <div class="cart-user-avatar"><?php echo strtoupper(substr($_SESSION['user'], 0, 1)); ?></div>
        <div class="cart-user-name"><?php echo $_SESSION['user']; ?></div>
        <button class="dropdown-btn" id="dropdown-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                <path d="M3.204 5h9.592L8 10.481 3.204 5z"/>
            </svg>
        </button>
    </div>
    <div class="cart-details" id="cart-details">
        <div class="cart-items" id="cart-items"></div>
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
        </div>
    </div>
    <div class="cart-summary">
        <div class="cart-row cart-total">
            <div>Total</div>
            <div id="total">₱0.00</div>
        </div>
        <button class="checkout-btn"onclick="showPaymentModal()">Continue</button>
        
    </div>
    <!-- Payment Modal -->
    <div id="payment-modal" class="modal" style="display: none;">
    <div class="modal-content">
    <h2>Review Your Order</h2>
        <div id="cart-summary-modal">
            <!-- Cart summary will be dynamically populated here -->
        </div>
        <button class="payment-btn" onclick="processPayment('cash')">Cash</button>
        <button class="payment-btn" onclick="processPayment('card')">Card</button>
        <button class="close-btn" onclick="closePaymentModal()">Cancel</button>
    </div>

    </div>
    </div>  
    </div>
    
    <div class="products-content" id="products-content" style="display: none;">
    <div class="header-titles"> <h1>Products Section</h1></div>
    </div>
    
    <div class="settings-content" id="settings-content" style="display: none;">
    <div class="header-titles"> <h1>Settings Section</h1> </div>
    </div>


    <div class="logout-content" id="logout-content" style="display: none;">
        <h1>Logout Section</h1>
    </div>

    <script>
    function toggleCart() {
        const cartDetails = document.getElementById('cart-details');
        const dropdownBtn = document.getElementById('dropdown-btn');

        if (cartDetails.classList.contains('expanded')) {
            cartDetails.classList.remove('expanded');
            dropdownBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                    <path d="M3.204 5h9.592L8 10.481 3.204 5z"/>
                </svg>
            `;
        } else {
            cartDetails.classList.add('expanded');
            dropdownBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                    <path d="M3.204 11h9.592L8 5.519 3.204 11z"/>
                </svg>
            `;
        }
    }
    document.addEventListener('DOMContentLoaded', () => {
        const cartHeader = document.querySelector('.cart-header');
        const dropdownBtn = document.getElementById('dropdown-btn');

        cartHeader.addEventListener('click', toggleCart);
        dropdownBtn.addEventListener('click', toggleCart);
    });
    </script>
	


    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const serviceChargePercentage = 0.20;
        const taxRate = 0.05;

        // Initialize cart on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateCart();
        });

        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
        }

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
            
            saveCart();
            updateCart();
        }

        function removeFromCart(index) {
            if (cart[index].quantity > 1) {
                cart[index].quantity -= 1;
            } else {
                cart.splice(index, 1);
            }
            
            saveCart();
            updateCart();
        }

        function removeItemFromCart(index) {
            cart.splice(index, 1);
            saveCart();
            updateCart();
        }

        function removeAllFromCart() {
            cart = [];
            saveCart();
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
                        <button class="remove-btn" onclick="removeItemFromCart(${index})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </button>
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
            
            
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = '<div class="empty-cart">Your cart is empty.</div>';
            }
        }

        function filterItems(category) {
            const items = document.querySelectorAll('.item-card');
            items.forEach(item => {
                item.classList.add('hidden');
            });

            // Fetch new items based on the selected category
            fetch(`php/get_items.php?category=${category}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('items-grid').innerHTML = data;
                    setTimeout(() => {
                        const newItems = document.querySelectorAll('.item-card');
                        newItems.forEach(item => {
                            item.classList.remove('hidden');
                        });
                    }, 100);
                });

            
            const url = new URL(window.location.href);
            url.searchParams.set('category', category);
            window.history.pushState({}, '', url);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const section = urlParams.get('section');
            if (section) {
                switchView(section);
            }

            const items = document.querySelectorAll('.item-card');
            setTimeout(() => {
                items.forEach(item => {
                    item.classList.remove('hidden');
                });
            }, 100);
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
            const barcodeInput = document.getElementById('barcode-input');
            const barcode = barcodeInput.value;

           
            if (barcode.length === 12) {
                const formData = new FormData();
                formData.append('barcode', barcode);
                formData.append('submit', true);

                fetch('php/barcode_scan.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data && data.Product_Name) {
                        addToCart(
                            data.Product_Name, 
                            parseFloat(data.Product_Price),
                            data.Product_image_path,
                            parseInt(data.Product_Quantity)
                        );
                        
                        const barcodeScanner = document.getElementById('barcode-scanner');
                        barcodeScanner.classList.add('success');
                        setTimeout(() => {
                            barcodeScanner.classList.remove('success');
                        }, 1000);
                    } else {
                        const barcodeScanner = document.getElementById('barcode-scanner');
                        barcodeScanner.classList.add('error');
                        setTimeout(() => {
                            barcodeScanner.classList.remove('error');
                        }, 1000);
                    }
                    
                    barcodeInput.value = '';
                })
                .catch(error => {
                    console.error('Error:', error);
                    const barcodeScanner = document.getElementById('barcode-scanner');
                    barcodeScanner.classList.add('error');
                    setTimeout(() => {
                        barcodeScanner.classList.remove('error');
                    }, 1000);
                    
                    barcodeInput.value = '';
                });
            }
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
            document.getElementById('dashboard-content').style.display = 'none';
            document.getElementById('upload-content').style.display = 'none';
            document.getElementById('products-content').style.display = 'none';
            document.getElementById('inventory-content').style.display = 'none';
            document.getElementById('settings-content').style.display = 'none';
            document.getElementById('logout-content').style.display = 'none';

            document.getElementById(`${view}-content`).style.display = 'block';

            document.querySelectorAll('.sidebar-icon').forEach(icon => {
                icon.classList.remove('active');
            });

            document.getElementById(`${view}-button`).classList.add('active');

            const url = new URL(window.location.href);
            const currentSuccess = url.searchParams.get('success');
            const currentError = url.searchParams.get('error');
            url.searchParams.delete('category');
            
            if (view === 'upload') {
                if (currentSuccess === 'upload_successful') {
                    url.searchParams.set('success', 'upload_successful');
                }
                if (currentError) {
                    url.searchParams.set('error', currentError);
                }
            } else {
                url.searchParams.delete('success');
                url.searchParams.delete('error');
            }
            
            if (view !== 'dashboard') {
                url.searchParams.set('section', view);
            } else {
                url.searchParams.delete('section');
            }
            window.history.pushState({}, '', url);

            window.scrollTo(0, 0);
        }

        
        document.querySelectorAll('.category').forEach(category => {
            category.addEventListener('click', function() {
                document.querySelector('.category.active').classList.remove('active');
                this.classList.add('active');
                filterItems(this.textContent);
            });
        });

        function logout() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'php/logout.php';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'logout';
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

        function showPaymentModal() {
            const cartSummaryModal = document.getElementById('cart-summary-modal');
        cartSummaryModal.innerHTML = ''; // Clear previous content

        if (cart.length === 0) {
            cartSummaryModal.innerHTML = '<p>Your cart is empty.</p>';
        } else {
            let summaryHTML = '<ul>';
            cart.forEach(item => {
                summaryHTML += `
                    <li>
                        <div><b>${item.name}</b></div>
                        <div>Price: ₱${item.price.toFixed(2)}</div>
                        <div>Quantity: ${item.quantity}</div>
                        <div>Subtotal: ₱${(item.price * item.quantity).toFixed(2)}</div>
                    </li>
                    <hr>
                `;
            });
            summaryHTML += `
                <li>
                    <div><b>Total:</b> ₱${document.getElementById('total').textContent}</div>
                </li>
            `;
            summaryHTML += '</ul>';
            cartSummaryModal.innerHTML = summaryHTML;
        }

        document.getElementById('payment-modal').style.display = 'flex';
    }

    function closePaymentModal() {
        document.getElementById('payment-modal').style.display = 'none';
    }


    function processPayment(method) {
        closePaymentModal();
        alert(`You selected to pay with ${method}.`);
        
    }
	
    </script>
</body>
</html>