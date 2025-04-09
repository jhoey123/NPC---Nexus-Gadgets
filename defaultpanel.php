<?php

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: logintab.php");
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
    <title>NexusGadgets POS</title>
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
        <div class="sidebar-icon" id="inventory-button" onclick="switchView('inventory')">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3z"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
        <span class="sidebar-text">Inventory</span>
    </div>
        <div style="flex: 1;"></div>
        <div class="sidebar-icon" id="cart-button" onclick="switchView('cart')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            <span class="sidebar-text">Cart</span>
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
    
    </div>
    <div class="cart-details" id="cart-details">
        <div class="cart-items" id="cart-items"></div>
        
    </div>
    <div class="cart-summary">
        <div class="cart-row cart-total">
            <div>Total</div>
            <div id="total">₱0.00</div>
        </div>
        <button class="checkout-btn" onclick="switchView('cart')">Continue</button>
        
    </div>
    
    </div>
    </div>  
    </div>

    
    <div class="cart-content" id="cart-content" style="display: none;">
    <div class="header-titles"> <h1>Your Cart</h1></div>
    <div class="cart-containe">
            <div class="cart-items-container" id="cart-items-container">
                <!-- Individual cart items will be dynamically added here -->
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
                        <div id="service-charge">5%</div>
                    </div>
                    <div class="cart-row">
                        <div>Tax</div>
                        <div id="tax">₱0.00</div>
                    </div>
                </div>
                <div class="confirmation-container">
                <button class="checko-btn" onclick="showPaymentModal()">Checkout</button>
                <button class="checko-btn" onclick="switchView('dashboard')">Go back</button>
            </div>
        </div>
        <!-- Payment Modal -->
<div id="payment-modal" class="modal" style="display: none;">
<div class="modal-content">
        <h2>Payment Options</h2>
        <div class="out-btn">
            <button class="payment-btn" onclick="processPayment('cash')">Cash</button>
            <button class="payment-btn" onclick="processPayment('card')">Card</button>
            <button class="close-btn" onclick="closePaymentModal()">Cancel</button>
        </div>
    </div>
</div>
    </div>

    <div class="inventory-content" id="inventory-content" style="display: none;">
    <div class="header-titles"> <h1>Inventory Section</h1> </div>
    <div class="inventory-categories">
        <?php
        $inventoryCategories = ["All", "Laptops", "Smartphones", "Mouse", "Keyboards", "Monitors"];
        $currentInventoryCategory = isset($_GET['inventory_category']) ? $_GET['inventory_category'] : 'All';
        foreach ($inventoryCategories as $category) {
            $activeClass = $category === $currentInventoryCategory ? 'active' : '';
            echo "<button class='inventory-category-btn $activeClass' onclick=\"filterInventoryItems('$category')\">$category</button>";
        }
        ?>
    </div>
        <div class="in-items-grid" id="in-items-grid">       
        <?php
        include "php/conn_db.php"; // Include database connection
        
        $inventoryCategoryFilter = $currentInventoryCategory !== 'All' ? "WHERE Category_id = (SELECT Category_id FROM categories WHERE Category_name = '$currentInventoryCategory')" : '';
        $query = "SELECT * FROM products $inventoryCategoryFilter";
        $result = $conn->query($query);
        
        while ($row = $result->fetch_assoc()): ?>
            <div class="item-card" onclick="showInventoryModal(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                <img src="<?php echo $row['Product_image_path']; ?>" alt="<?php echo $row['Product_name']; ?>" class="item-image">
                <div class="item-details">
                    <h3><?php echo $row['Product_name']; ?></h3>
                    <p><b>Price:</b> ₱<?php echo number_format($row['Product_price'], 2); ?></p>
                    <p><b>Quantity:</b> <span id="quantity-<?php echo $row['Product_id']; ?>"><?php echo $row['Product_quantity']; ?></span></p>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    </div>

    <div class="inventory-modal" id="inventory-modal">
        <div class="inventory-modal-content">
            <h2 id="modal-product-name"></h2>
            <img id="modal-product-image" src="" alt="Product Image">
            <p><b>Brand:</b> <span id="modal-product-brand"></span></p>
            <p><b>Description:</b> <span id="modal-product-desc"></span></p>
            <p><b>Price:</b> ₱<span id="modal-product-price"></span></p>
            <p><b>Quantity:</b> <span id="modal-product-quantity"></span></p>
            <p><b>Category:</b> <span id="modal-product-category"></span></p>
            <input type="hidden" id="modal-product-id">
            <div>
                <button class="edit-modal-btn" onclick="showEditModal()">Edit</button>
                <button class="close-modal-btn" onclick="closeInventoryModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- Add Edit Modal -->
    <div class="edit-inventory-modal" id="edit-inventory-modal">
        <div class="edit-modal-content">
            <h2>Edit Product</h2>
            <form id="edit-product-form" enctype="multipart/form-data">
                <input type="hidden" id="edit-product-id" name="product_id">
                <div class="form-group">
                    <label for="edit-product-name">Product Name:</label>
                    <input type="text" id="edit-product-name" name="product_name" required>
                </div>
                <div class="form-group">
                    <label for="edit-product-desc">Description:</label>
                    <textarea id="edit-product-desc" name="product_desc"></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-product-price">Price:</label>
                    <input type="number" id="edit-product-price" name="product_price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="edit-product-quantity">Quantity:</label>
                    <input type="number" id="edit-product-quantity" name="product_quantity" required>
                </div>
                <div class="form-group">
                    <label for="edit-product-image">New Image (optional):</label>
                    <input type="file" id="edit-product-image" name="product_image" accept="image/*">
                </div>
                <div class="edit-modal-buttons">
                    <button type="submit" class="save-btn">Save Changes</button>
                    <button type="button" class="cancel-btn" onclick="closeEditModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="employee-content" id="employee-content" style="display: none;">
        <div class="header-titles">
            <h1>Employee Section</h1>
        </div>
        <div class="employee-list">
            <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
                <button class="btn btn-primary" onclick="showCreateAccountModal()">Create Account</button>
            </div>
            <?php
            include "php/conn_db.php"; // Include database connection

            $query = "SELECT u.user_id, u.username, e.employee_lname, r.rank_name
                      FROM users u 
                      JOIN employees e ON u.user_id = e.employee_id 
                      JOIN ranks r ON u.rank_id = r.rank_id";
            $result = $conn->query($query);

            if ($result->num_rows > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Last Name</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['employee_lname']); ?></td>
                                <td><?php echo htmlspecialchars($row['rank_name']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No employees found.</p>
            <?php endif;

            $conn->close();
            ?>
        </div>
    </div>

    <!-- Add Create Account Modal -->
    <div class="create-account-modal" id="create-account-modal" style="display: none;">
        <div class="modal-content">
            <h2>Create New Account</h2>
            <form id="create-account-form">
                <div class="form-group">
                    <label for="new-username">Username:</label>
                    <input type="text" id="new-username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="new-password">Password:</label>
                    <input type="password" id="new-password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="employee-select">Select Employee:</label>
                    <select id="employee-select" name="employee_id" required>
                        <?php
                        include "php/conn_db.php";
                        $query = "SELECT employee_id, CONCAT(employee_fname, ' ', employee_lname) as full_name 
                                 FROM employees 
                                 WHERE employee_id NOT IN (SELECT user_id FROM users)";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['employee_id'] . "'>" . $row['full_name'] . "</option>";
                        }
                        $conn->close();
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="rank-select">Select Rank:</label>
                    <select id="rank-select" name="rank_id" required>
                        <option value="2">Staff</option>
                        <option value="1">Admin</option>
                    </select>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn btn-primary">Create Account</button>
                    <button type="button" class="btn btn-secondary" onclick="closeCreateAccountModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="logout-content" id="logout-content" style="display: none;">
        <h1>Logout Section</h1>
    </div>

    <script>
        function showCreateAccountModal() {
        document.getElementById('create-account-modal').style.display = 'flex';
    }

    function closeCreateAccountModal() {
        document.getElementById('create-account-modal').style.display = 'none';
    }

    document.getElementById('create-account-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('php/create_account.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Account created successfully');
                closeCreateAccountModal();
                location.reload();
            } else {
                alert('Error creating account: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error creating account');
        });
    });
    </script>
	

    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const serviceChargePercentage = 0.05;
        const taxRate = 0.01;

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
                const itemSubtotal = item.price * item.quantity;
                subtotal += itemSubtotal;
                
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
            const serviceCharge = subtotal * 0.2; // Example: 20% service charge
            const tax = subtotal * 0.1; // Example: 10% tax
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
            document.getElementById('inventory-content').style.display = 'none';
            document.getElementById('cart-content').style.display = 'none';
            document.getElementById('logout-content').style.display = 'none';
            document.getElementById('employee-content').style.display = 'none';

            document.getElementById(`${view}-content`).style.display = 'block';

            document.querySelectorAll('.sidebar-icon').forEach(icon => {
                icon.classList.remove('active');
            });

            document.getElementById(`${view}-button`).classList.add('active');

            const url = new URL(window.location.href);
            url.searchParams.delete('category');
            url.searchParams.delete('success');
            url.searchParams.delete('error');
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
        document.getElementById('payment-modal').style.display = 'flex';
    }

    function closePaymentModal() {
        document.getElementById('payment-modal').style.display = 'none';
    }


    function processPayment(method) {
        closePaymentModal();
        alert(`You selected to pay with ${method}.`);
         // Generate a 7-digit transaction ID
    const transactionId = Math.random().toString().slice(2, 9);

// Collect purchase list and total amount
const purchaseList = cart.map(item => `${item.name} (x${item.quantity})`).join(', ');
const totalAmount = parseFloat(document.getElementById('total').textContent.replace('₱', ''));

// Prepare data to send to the server
const formData = new FormData();
formData.append('transaction_id', transactionId);
formData.append('purchase_list', purchaseList);
formData.append('total_amount', totalAmount);
formData.append('payment_method', method);

// Send data to the server
fetch('php/history.php', {
    method: 'POST',
    body: formData
})
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reduce inventory quantities
            cart.forEach(item => {
                const updateFormData = new FormData();
                updateFormData.append('product_name', item.name);
                updateFormData.append('quantity_sold', item.quantity);

                fetch('php/update_inventory.php', {
                    method: 'POST',
                    body: updateFormData
                }).catch(error => console.error('Error updating inventory:', error));
            });

            alert(`Transaction successful! Transaction ID: ${transactionId}`);
            removeAllFromCart(); // Clear the cart after successful payment
            closePaymentModal();
        } else {
            alert('Error saving transaction: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing the transaction.');
    });
    }

    function showInventoryModal(product) {
        document.getElementById('modal-product-name').textContent = product.Product_name;
        document.getElementById('modal-product-image').src = product.Product_image_path;
        document.getElementById('modal-product-brand').textContent = product.Product_brand || 'N/A';
        document.getElementById('modal-product-desc').textContent = product.Product_desc || 'No description available.';
        document.getElementById('modal-product-price').textContent = parseFloat(product.Product_price).toFixed(2);
        document.getElementById('modal-product-quantity').textContent = product.Product_quantity;
        const categoryMap = {
            1: "Laptops",
            2: "Smartphones",
            3: "Mouse",
            4: "Keyboards",
            5: "Monitors"
        };
        document.getElementById('modal-product-category').textContent = categoryMap[product.Category_id] || 'Uncategorized';
        document.getElementById('modal-product-id').value = product.Product_id;

        document.getElementById('inventory-modal').style.display = 'flex';
    }

    function closeInventoryModal() {
        document.getElementById('inventory-modal').style.display = 'none';
    }

    function showEditModal() {
        const productId = document.getElementById('modal-product-id').value;
        const productName = document.getElementById('modal-product-name').textContent;
        const productDesc = document.getElementById('modal-product-desc').textContent;
        const productPrice = document.getElementById('modal-product-price').textContent;
        const productQuantity = document.getElementById('modal-product-quantity').textContent;

        document.getElementById('edit-product-id').value = productId;
        document.getElementById('edit-product-name').value = productName;
        document.getElementById('edit-product-desc').value = productDesc;
        document.getElementById('edit-product-price').value = productPrice;
        document.getElementById('edit-product-quantity').value = productQuantity;

        document.getElementById('edit-inventory-modal').style.display = 'flex';
        closeInventoryModal();
    }

    function closeEditModal() {
        document.getElementById('edit-inventory-modal').style.display = 'none';
    }

    document.getElementById('edit-product-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('php/update_product.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Product updated successfully');
                closeEditModal();
                location.reload(); // Refresh the page to show updated data
            } else {
                alert('Error updating product: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating product');
        });
    });

    function filterInventoryItems(category) {
        const itemsGrid = document.getElementById('in-items-grid');
        
        // Start fade out
        itemsGrid.style.opacity = '0';
        
        // Wait for fade out to complete before fetching new items
        setTimeout(() => {
            fetch(`php/get_inventory_items.php?inventory_category=${encodeURIComponent(category)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    itemsGrid.innerHTML = data;
                    // Trigger reflow before starting fade in
                    void itemsGrid.offsetWidth;
                    // Start fade in
                    itemsGrid.style.opacity = '1';
                })
                .catch(error => {
                    console.error('Error:', error);
                    itemsGrid.innerHTML = '<p class="error-message">Error loading items.</p>';
                    itemsGrid.style.opacity = '1';
                });
        }, 300);

        // Update active category button
        document.querySelectorAll('.inventory-category-btn').forEach(btn => {
            btn.classList.toggle('active', btn.textContent.trim() === category);
        });
    }
        function updateCart() {
        const cartItemsContainer = document.getElementById('cart-items-container');
        cartItemsContainer.innerHTML = ''; // Clear previous items
    
        let subtotal = 0;
    
        cart.forEach((item, index) => {
            const itemSubtotal = item.price * item.quantity;
            subtotal += itemSubtotal;
    
            const cartItemElement = document.createElement('div');
            cartItemElement.className = 'cart-item-card';
            cartItemElement.innerHTML = `
                <img src="${item.image}" alt="${item.name}" class="cart-item-image"> <!-- Include item image -->
                <div class="cart-item-details">
                    <h3 class="cart-item-name">${item.name}</h3>
                    <p class="cart-item-price">Price: ₱${item.price.toFixed(2)}</p>
                    <p class="cart-item-quantity">Amount: ${item.quantity}</p>
                    <p class="cart-item-subtotal">Subtotal: ₱${itemSubtotal.toFixed(2)}</p>
                </div>
                <div class="cart-item-actions">
                    <button class="qty-btn" onclick="removeFromCart(${index})">-</button>
                    <button class="qty-btn" onclick="addToCart('${item.name}', ${item.price}, '${item.image}', ${item.maxQuantity})">+</button>
                    <button class="remove-btn" onclick="removeItemFromCart(${index})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </button>
                </div>
            `;
    
            cartItemsContainer.appendChild(cartItemElement);
        });
    
        const discount = 0;
        const serviceCharge = subtotal * 0.2; // Example: 20% service charge
        const tax = subtotal * 0.1; // Example: 10% tax
        const total = subtotal + serviceCharge + tax - discount;
    
        document.getElementById('subtotal').textContent = `₱${subtotal.toFixed(2)}`;
        document.getElementById('discount').textContent = `₱${discount.toFixed(2)}`;
        document.getElementById('service-charge').textContent = `₱${serviceCharge.toFixed(2)}`;
        document.getElementById('tax').textContent = `₱${tax.toFixed(2)}`;
        document.getElementById('total').textContent = `₱${total.toFixed(2)}`;
    
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<div class="empty-cart">Your cart is empty.</div>';
        }
    }
	
    </script>
</body>
</html>