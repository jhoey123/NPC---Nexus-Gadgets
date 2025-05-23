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
        if ($rank === "staff") {
            header("Location: defaultpanel.php");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }
}

$totalSales = getSales();
$todaysOrders = getTodaysOrders();
$weeklyProfits = getWeeklyProfits();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/adminpanel.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    </style>
    <title>NexusGadgets Admin POS</title>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-icon logo">
            <img src="images/NEXUS GADGETS.png" alt="Logo" width="24" height="24">
        </div>
        <div class="sidebar-icon active" id="dashboard-button" onclick="switchView('dashboard')">
            <i class="fas fa-tachometer-alt"></i>
            <span class="sidebar-text">Dashboard</span>
        </div>
        <div class="sidebar-icon" id="upload-button" onclick="switchView('upload')">
            <i class="fas fa-upload"></i>
            <span class="sidebar-text">Upload</span>
        </div>
        <div class="sidebar-icon" id="inventory-button" onclick="switchView('inventory')">
            <i class="fas fa-boxes"></i>
            <span class="sidebar-text">Inventory</span>
        </div>
        <div class="sidebar-icon" id="employee-button" onclick="switchView('employee')">
            <i class="fas fa-users"></i>
            <span class="sidebar-text">Users</span>
        </div>
        <div class="sidebar-icon" id="transaction-button" onclick="switchView('transaction')">
            <i class="fas fa-receipt"></i>
            <span class="sidebar-text">Transactions</span>
        </div>
        <div style="flex: 1;"></div>
        <div class="sidebar-icon" id="logout-button" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i>
            <span class="sidebar-text">Logout</span>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="main-content" id="dashboard-content" style="display:none;">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Admin POS Dashboard</h1>
                <div class="date-display">Today, <span id="current-date"></span></div>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-title">Total Sales</div>
                <div class="stat-value" id="total-sales">
                    ₱<?php echo number_format($totalSales, 2); ?>
                </div>
                <div class="stat-change up">
                    <i class="fas fa-arrow-up"></i> <span id="sales-change">12%</span> from yesterday
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Today's Orders</div>
                <div class="stat-value" id="today-orders">
                    <?php echo $todaysOrders; ?>
                </div>
                <div class="stat-change up">
                    <i class="fas fa-arrow-up"></i> <span id="orders-change">8%</span> from yesterday
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-title">New Customers</div>
                <div class="stat-value" id="new-customers">15</div>
                <div class="stat-change down">
                    <i class="fas fa-arrow-down"></i> <span id="customers-change">3%</span> from yesterday
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Conversion Rate</div>
                <div class="stat-value" id="conversion-rate">3.2%</div>
                <div class="stat-change up">
                    <i class="fas fa-arrow-up"></i> <span id="conversion-change">0.5%</span> from yesterday
                </div>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">Sales Overview</div>
                    <div class="chart-period">Last 7 Days</div>
                </div>
                <div class="chart-placeholder">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">Order Overview</div>
                    <div class="chart-period">Today</div>
                </div>
                <div class="chart-placeholder">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>

        <div class="products-container">
            <div class="product-list">
                <div class="product-list-header">
                    <div class="product-list-title">Top Selling Products</div>
                        <select id="top-products-period" class="bg-[#0a192f] border border-[#1e2d3d] rounded px-2 py-1 text-sm text-[#e6f1ff] focus:outline-none focus:border-[#6366f1]" onchange="updateTopProducts()">
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="year">This Year</option>
                    </select>
                </div>
                <div id="top-products-list">
                    <!-- Top products will be populated here by JavaScript -->
                </div>
            </div>
            <div class="product-list">
                <div class="product-list-header">
                    <div class="product-list-title">Purchase Analytics</div>
                </div>
                <div id="purchase-analytics">
                    <!-- Purchase analytics will be populated here by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Content -->
    <div class="upload-content" id="upload-content" style="display:none;">
        <div class="upload-container">
            <div class="upload-header">
                <h2 class="upload-title">Add New Product</h2>
                <p class="upload-subtitle">Fill in the details below to add a new product to inventory</p>
            </div>
            
            <form class="upload-form" id="product-form" action="php/upload.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="product-name">Product Name</label>
                    <input type="text" id="product-name" name="product_name" placeholder="Enter product name" required>
                </div>
                
                <div class="form-group">
                    <label for="product-brand">Brand</label>
                    <input type="text" id="product-brand" name="product_brand" placeholder="Enter brand name" required>
                </div>
                
                <div class="form-group">
                    <label for="product-price">Price</label>
                    <input type="number" id="product-price" name="product_price" placeholder="Enter price" min="0" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="product-quantity">Quantity</label>
                    <input type="number" id="product-quantity" name="product_quantity" placeholder="Enter quantity" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="product-category">Category</label>
                    <select id="product-category" name="product_category" required>
                        <option value="">Select category</option>
                        <option value="1">Laptops</option>
                        <option value="2">Smartphones</option>
                        <option value="3">Mouse</option>
                        <option value="4">Keyboards</option>
                        <option value="5">Monitors</option>
                    </select>
                </div>
                
                <div class="form-group full-width">
                    <label for="product-description">Description</label>
                    <textarea id="product-description" name="product_description" rows="3" placeholder="Enter product description"></textarea>
                </div>
                
                <div class="form-group full-width">
                    <label>Product Image</label>
                    <div class="file-upload" id="file-upload-container">
                        <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                        <div class="file-upload-text">
                            Drag & drop your image here or <span>browse</span><br>
                            Supports: JPG, PNG (Max 5MB)
                        </div>
                        <input type="file" id="product-image" name="product_image" accept="image/*" required>
                    </div>
                </div>
                
                <button type="submit" class="upload-btn">
                    <i class="fas fa-plus-circle" style="margin-right: 8px;"></i> Add Product
                </button>
            </form>
        </div>
    </div>

    <!-- Inventory Content -->
    <div class="inventory-content" id="inventory-content" style="display:none;">
        <div class="inventory-header">
            <h2 class="inventory-title">Inventory Management</h2>
            <p class="inventory-subtitle">View and manage your product inventory</p>
        </div>
        
        <div class="inventory-actions">
            <div class="inventory-search">
                <i class="fas fa-search"></i>
                <input type="text" id="inventory-search" placeholder="Search products..." oninput="searchProducts()">
            </div>
        
        </div>
        
        <div class="inventory-table">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="inventory-table-body">
                    <!-- Inventory items will be populated here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

        <!-- Edit Product Modal -->
    <div class="modal" id="edit-product-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Edit Product</div>
                <button class="modal-close" onclick="closeEditProductModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="edit-product-form" action="php/update_product.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="edit-product-id" name="product_id">
                    <div class="form-group">
                        <label for="edit-product-name">Product Name</label>
                        <input type="text" id="edit-product-name" name="product_name" placeholder="Enter product name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-product-category">Category</label>
                        <select id="edit-product-category" name="product_category" required>
                            <option value="">Select category</option>
                            <option value="laptops">Laptops</option>
                            <option value="smartphones">Smartphones</option>
                            <option value="keyboards">Keyboards</option>
                            <option value="mice">Mouse</option> 
                            <option value="monitors">Monitors</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-product-price">Price</label>
                        <input type="number" id="edit-product-price" name="product_price" placeholder="Enter price" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-product-quantity">Quantity</label>
                        <input type="number" id="edit-product-quantity" name="product_quantity" placeholder="Enter quantity" min="0" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="edit-product-image">Product Image</label>
                        <input type="file" id="edit-product-image" name="product_image" accept="image/*">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" onclick="closeEditProductModal()">Cancel</button>
                <button class="modal-btn modal-btn-primary" onclick="submitEditProductForm()">Update Product</button>
            </div>
        </div>
    </div>

    <!-- Delete Product Modal -->
    <div class="modal" id="delete-product-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Delete Product</div>
                <button class="modal-close" onclick="closeDeleteProductModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this product?</p>
                <p class="mt-2 text-sm text-8892b0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" onclick="closeDeleteProductModal()">Cancel</button>
                <button class="modal-btn modal-btn-primary" onclick="deleteProduct()">Delete</button>
            </div>
        </div>
    </div>


    <!-- User Management Content -->
    <div class="employee-content" id="employee-content" style="display:none;">
        <div class="employee-header">
            <h2 class="employee-title">User Management</h2>
            <p class="employee-subtitle">View and manage all user accounts (Admin, Staff, User)</p>
        </div>
        
        <div class="employee-actions">
            <div class="employee-search">
                <i class="fas fa-search"></i>
                <input type="text" id="employee-search" placeholder="Search users..." oninput="searchEmployees()">
            </div>
            <button class="add-employee-btn" onclick="showAddEmployeeModal()">
                <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Add User
            </button>
        </div>
        
        <div class="employee-table">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Date of Birth</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="employee-table-body">
                    <!-- Users will be populated here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>



    <!-- Add Employee Modal -->
    <div class="modal" id="add-employee-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Add New User</div>
                <button class="modal-close" onclick="closeAddEmployeeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="modal-employee-form">
                    <div class="form-group">
                        <label for="modal-employee-fname">First Name</label>
                        <input type="text" id="modal-employee-fname" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-employee-lname">Last Name</label>
                        <input type="text" id="modal-employee-lname" placeholder="Enter last name" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-employee-email">Email</label>
                        <input type="email" id="modal-employee-email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-employee-dob">Date of Birth</label>
                        <input type="date" id="modal-employee-dob" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-employee-phone">Phone</label>
                        <input type="tel" id="modal-employee-phone" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-employee-role">Role</label>
                        <select id="modal-employee-role" required>
                            <option value="Admin">Admin</option>
                            <option value="Staff">Staff</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modal-employee-status">Status</label>
                        <select id="modal-employee-status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" onclick="closeAddEmployeeModal()">Cancel</button>
                <button class="modal-btn modal-btn-primary" onclick="addEmployeeFromModal()">Add User</button>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" id="edit-employee-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Edit User</div>
                <button class="modal-close" onclick="closeEditEmployeeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="edit-employee-form">
                    <input type="hidden" id="edit-employee-id">
                    <div class="form-group">
                        <label for="edit-employee-fname">First Name</label>
                        <input type="text" id="edit-employee-fname" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-employee-lname">Last Name</label>
                        <input type="text" id="edit-employee-lname" placeholder="Enter last name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-employee-email">Email</label>
                        <input type="email" id="edit-employee-email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-employee-dob">Date of Birth</label>
                        <input type="date" id="edit-employee-dob" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-employee-phone">Phone</label>
                        <input type="tel" id="edit-employee-phone" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-employee-role">Role</label>
                        <select id="edit-employee-role" required>
                            <option value="Admin">Admin</option>
                            <option value="Staff">Staff</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-employee-status">Status</label>
                        <select id="edit-employee-status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" onclick="closeEditEmployeeModal()">Cancel</button>
                <button class="modal-btn modal-btn-primary" onclick="updateEmployee()">Update User</button>
            </div>
        </div>
    </div>

    <!-- Delete Employee Confirmation Modal -->
    <div class="modal" id="delete-confirm-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Confirm Delete</div>
                <button class="modal-close" onclick="closeDeleteConfirmModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this <span id="delete-item-type"></span>?</p>
                <p class="mt-2 text-sm text-8892b0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" onclick="closeDeleteConfirmModal()">Cancel</button>
                <button class="modal-btn modal-btn-primary" id="confirm-delete-btn" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>

    <!-- Transaction Content -->
    <div class="transaction-content" id="transaction-content" style="display:none;">
        <div class="transaction-header">
            <h2 class="transaction-title">Transaction Records</h2>
            <p class="transaction-subtitle">View and record all purchase transactions</p>
        </div>
        <div class="transaction-actions">
            <!-- Removed Add Transaction button as transactions are now recorded automatically -->
        </div>
        <div class="transaction-table">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Customer Name</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="transaction-table-body">
                    <!-- Transactions will be populated here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Transaction Modal -->
    <div class="modal" id="add-transaction-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Add Transaction</div>
                <button class="modal-close" onclick="closeAddTransactionModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="transaction-form">
                    <div class="form-group">
                        <label for="transaction-date">Date</label>
                        <input type="date" id="transaction-date" required>
                    </div>
                    <div class="form-group">
                        <label for="transaction-customer">Customer Name</label>
                        <input type="text" id="transaction-customer" placeholder="Enter customer name" required>
                    </div>
                    <div class="form-group">
                        <label for="transaction-item">Item</label>
                        <input type="text" id="transaction-item" placeholder="Enter item name" required>
                    </div>
                    <div class="form-group">
                        <label for="transaction-price">Price</label>
                        <input type="number" id="transaction-price" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="transaction-quantity">Quantity</label>
                        <input type="number" id="transaction-quantity" min="1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" onclick="closeAddTransactionModal()">Cancel</button>
                <button class="modal-btn modal-btn-primary" onclick="addTransactionFromModal()">Add Transaction</button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toast-message">Operation completed successfully</span>
    </div>

    <script>
        // Data storage
        let products = [];
        let employees = [];
        let salesData = [];
        let transactions = [];

        function renderTransactionTable() {
            const tbody = document.getElementById('transaction-table-body');
            tbody.innerHTML = '';
            transactions.forEach(tx => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${tx.date}</td>
                    <td>${tx.customer}</td>
                    <td>${tx.item}</td>
                    <td>₱${parseFloat(tx.price).toFixed(2)}</td>
                    <td>${tx.quantity}</td>
                    <td>₱${(tx.price * tx.quantity).toFixed(2)}</td>
                `;
                tbody.appendChild(row);
            });
        }

        function showAddTransactionModal() {
            document.getElementById('add-transaction-modal').style.display = 'flex';
        }

        function closeAddTransactionModal() {
            document.getElementById('add-transaction-modal').style.display = 'none';
            document.getElementById('transaction-form').reset();
        }

        function addTransactionFromModal() {
            const date = document.getElementById('transaction-date').value;
            const customer = document.getElementById('transaction-customer').value;
            const item = document.getElementById('transaction-item').value;
            const price = parseFloat(document.getElementById('transaction-price').value);
            const quantity = parseInt(document.getElementById('transaction-quantity').value);

            if (!date || !customer || !item || isNaN(price) || isNaN(quantity)) {
                showToast('Please fill all fields', 'error');
                return;
            }

            transactions.push({ date, customer, item, price, quantity });
            renderTransactionTable();
            closeAddTransactionModal();
            showToast('Transaction added successfully');
        }

        // Inject PHP weekly profits into JS
        const weeklyProfits = <?php echo json_encode($weeklyProfits); ?>;
        // Generate labels for the last 7 days (Mon-Sun)
        const weeklyLabels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Initialize the application
        document.addEventListener('DOMContentLoaded', () => {
            // Set current date
            const now = new Date();
            document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', { 
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' 
            });

            // Load sample data
            loadSampleData();
            
            // Initialize charts
            initCharts();
            
            // Set default view or restore last view
            const savedView = localStorage.getItem('adminpanel_active_view') || 'dashboard';
            switchView(savedView);
            
            // Set up drag and drop for file upload
            setupDragAndDrop();
            
            // Update dashboard stats
            updateDashboardStats();
            
            // Populate top products
            updateTopProducts();
            
            // Populate purchase analytics
            updatePurchaseAnalytics();
            
            // Render inventory table
            renderInventoryTable();
            
            // Render employee table
            renderEmployeeTable();

            // Render transaction table
            renderTransactionTable();
        });

        // Load sample data
        function loadSampleData() {
            // Sample products
            products = [

            ];

            // Sample employees
            employees = [

            ];

            // Sample sales data
            const today = new Date();
            const lastWeek = new Date(today);
            lastWeek.setDate(today.getDate() - 7);
            
            salesData = [];
            for (let i = 0; i < 7; i++) {
                const date = new Date(lastWeek);
                date.setDate(lastWeek.getDate() + i);
                
                salesData.push({
                    date: date,
                    sales: Math.floor(Math.random() * 5000) + 1000,
                    orders: Math.floor(Math.random() * 30) + 10,
                    customers: Math.floor(Math.random() * 15) + 5
                });
            }
        }

        // Initialize charts
        function initCharts() {
            // Sales chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: weeklyLabels,
                    datasets: [{
                        label: 'Sales',
                        data: weeklyProfits,
                        backgroundColor: 'rgba(85, 96, 255, 0.2)',
                        borderColor: '#6366f1',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(30, 45, 61, 0.5)'
                            },
                            ticks: {
                                color: '#8892b0'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(30, 45, 61, 0.5)'
                            },
                            ticks: {
                                color: '#8892b0'
                            }
                        }
                    }
                }
            });

            // Orders chart
            const ordersCtx = document.getElementById('ordersChart').getContext('2d');
            const ordersChart = new Chart(ordersCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'Processing', 'Cancelled'],
                    datasets: [{
                        data: [65, 20, 15],
                        backgroundColor: [
                            '#6366f1',
                            '#00bfff',
                            '#ff5555'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: '#e6f1ff'
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        }

        // View switching function
        function switchView(view) {
            document.getElementById('dashboard-content').style.display = 'none';
            document.getElementById('upload-content').style.display = 'none';
            document.getElementById('inventory-content').style.display = 'none';
            document.getElementById('employee-content').style.display = 'none';
            document.getElementById('transaction-content').style.display = 'none'; // Add this line

            document.getElementById(`${view}-content`).style.display = 'block';

            document.querySelectorAll('.sidebar-icon').forEach(icon => {
                icon.classList.remove('active');
            });

            document.getElementById(`${view}-button`).classList.add('active');

            // Save current view to localStorage
            localStorage.setItem('adminpanel_active_view', view);
        }

        // Update dashboard stats
        function updateDashboardStats() {
            const newCustomers = salesData[salesData.length - 1].customers;
            const conversionRate = (Math.random() * 5).toFixed(1);

            document.getElementById('new-customers').textContent = newCustomers;
            document.getElementById('conversion-rate').textContent = `${conversionRate}%`;

            // Random changes
            document.getElementById('sales-change').textContent = `${Math.floor(Math.random() * 15) + 5}%`;
            document.getElementById('orders-change').textContent = `${Math.floor(Math.random() * 10) + 5}%`;
            document.getElementById('customers-change').textContent = `${Math.floor(Math.random() * 10) + 5}%`;
            document.getElementById('conversion-change').textContent = `${(Math.random() * 1).toFixed(1)}%`;
        }

        // Update top products
        function updateTopProducts() {
            const period = document.getElementById('top-products-period').value;
            let topProducts = [];
            
            // Generate sample data based on period
            if (period === 'week') {
                topProducts = [
                    { name: 'Nexus Pro Keyboard', sales: 1250 },
                    { name: 'Ultra HD Monitor', sales: 980 },
                    { name: 'Gaming Mouse X1', sales: 750 },
                    { name: 'Wireless Earbuds', sales: 620 },
                    { name: 'Laptop Stand', sales: 480 }
                ];
            } else if (period === 'month') {
                topProducts = [
                    { name: 'Ultra HD Monitor', sales: 4500 },
                    { name: 'Nexus Pro Keyboard', sales: 3800 },
                    { name: 'Gaming Laptop', sales: 3200 },
                    { name: 'Wireless Earbuds', sales: 2800 },
                    { name: 'Smartphone X', sales: 2500 }
                ];
            } else { // year
                topProducts = [
                    { name: 'Gaming Laptop', sales: 32000 },
                    { name: 'Smartphone X', sales: 28500 },
                    { name: 'Ultra HD Monitor', sales: 26500 },
                    { name: 'Nexus Pro Keyboard', sales: 24000 },
                    { name: 'Wireless Earbuds', sales: 22000 }
                ];
            }
            
            const topProductsList = document.getElementById('top-products-list');
            topProductsList.innerHTML = '';
            
            topProducts.forEach((product, index) => {
                const item = document.createElement('div');
                item.className = 'product-item';
                
                item.innerHTML = `
                    <div class="product-rank">${index + 1}</div>
                    <div class="product-info">
                        <div class="product-name">${product.name}</div>
                        <div class="product-sales"><span class="product-sales-value">₱${product.sales.toLocaleString()}</span> in sales</div>
                    </div>
                `;
                
                topProductsList.appendChild(item);
            });
        }

        // Update purchase analytics
        function updatePurchaseAnalytics() {
            const analytics = [
                { icon: 'shopping-cart', name: 'Average Order Value', value: '₱89.50' },
                { icon: 'user-clock', name: 'Repeat Purchase Rate', value: '32%' },
                { icon: 'box-open', name: 'Most Purchased Category', value: 'Keyboards' },
                { icon: 'clock', name: 'Peak Shopping Time', value: '9:00 AM - 5:00 PM' },
                { icon: 'map-marker-alt', name: 'Top Location', value: 'Sabang Danao' }
            ];
            
            const analyticsContainer = document.getElementById('purchase-analytics');
            analyticsContainer.innerHTML = '';
            
            analytics.forEach(item => {
                const element = document.createElement('div');
                element.className = 'product-item';
                
                element.innerHTML = `
                    <div class="product-rank">
                        <i class="fas fa-${item.icon}"></i>
                    </div>
                    <div class="product-info">
                        <div class="product-name">${item.name}</div>
                        <div class="product-sales"><span class="product-sales-value">${item.value}</span></div>
                    </div>
                `;
                
                analyticsContainer.appendChild(element);
            });
        }

        // Setup drag and drop for file upload
        function setupDragAndDrop() {
            const fileUploadContainer = document.getElementById('file-upload-container');
            
            fileUploadContainer.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadContainer.style.borderColor = '#64ffda';
                fileUploadContainer.style.backgroundColor = '#0a192f';
            });
            
            fileUploadContainer.addEventListener('dragleave', () => {
                fileUploadContainer.style.borderColor = '#1e2d3d';
                fileUploadContainer.style.backgroundColor = '#0a192f';
            });
            
            fileUploadContainer.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUploadContainer.style.borderColor = '#1e2d3d';
                fileUploadContainer.style.backgroundColor = '#0a192f';
                
                if (e.dataTransfer.files.length) {
                    handleFileSelect({ target: { files: e.dataTransfer.files } });
                }
            });
        }

        // Handle file selection
        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            if (!file.type.match('image.*')) {
                showToast('Please select an image file', 'error');
                return;
            }
            
            if (file.size > 5 * 1024 * 1024) {
                showToast('File size should be less than 5MB', 'error');
                return;
            }
            
            selectedFile = file;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('file-preview').style.display = 'flex';
                document.getElementById('file-upload-container').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        // Remove selected image
        function removeImage() {
            selectedFile = null;
            document.getElementById('product-image').value = '';
            document.getElementById('file-preview').style.display = 'none';
            document.getElementById('file-upload-container').style.display = 'flex';
        }

        // Add product from form
        function addProduct(event) {
            event.preventDefault();
            
            const name = document.getElementById('product-name').value;
            const brand = document.getElementById('product-brand').value;
            const price = parseFloat(document.getElementById('product-price').value);
            const quantity = parseInt(document.getElementById('product-quantity').value);
            const category = document.getElementById('product-category').value;
            const description = document.getElementById('product-description').value;
            
            const newProduct = {
                id: products.length > 0 ? Math.max(...products.map(p => p.id)) + 1 : 1,
                name,
                brand,
                price,
                quantity,
                category,
                description,
                image: selectedFile ? URL.createObjectURL(selectedFile) : 'https://via.placeholder.com/50'
            };
            
            products.push(newProduct);
            renderInventoryTable();
            
            // Reset form
            document.getElementById('product-form').reset();
            if (selectedFile) {
                removeImage();
            }
            
            showToast('Product added successfully');
            closeAddProductModal();
        }

        // Add product from modal
        function addProductFromModal() {
            const name = document.getElementById('modal-product-name').value;
            const category = document.getElementById('modal-product-category').value;
            const price = parseFloat(document.getElementById('modal-product-price').value);
            const quantity = parseInt(document.getElementById('modal-product-quantity').value);
            const description = document.getElementById('modal-product-description').value;
            
            if (!name || !category || isNaN(price) || isNaN(quantity)) {
                showToast('Please fill all fields', 'error');
                return;
            }
            
            const newProduct = {
                id: products.length > 0 ? Math.max(...products.map(p => p.id)) + 1 : 1,
                name,
                brand: 'Nexus',
                price,
                quantity,
                category,
                description,
                image: selectedFile ? URL.createObjectURL(selectedFile) : 'https://via.placeholder.com/50'
            };
            
            products.push(newProduct);
            renderInventoryTable();
            
            // Reset form
            document.getElementById('modal-product-form').reset();
            
            showToast('Product added successfully');
            closeAddProductModal();
        }

        // Add employee from modal
        function addEmployeeFromModal() {
            const fname = document.getElementById('modal-employee-fname').value;
            const lname = document.getElementById('modal-employee-lname').value;
            const email = document.getElementById('modal-employee-email').value;
            const dob = document.getElementById('modal-employee-dob').value;
            const phone = document.getElementById('modal-employee-phone').value;
            const role = document.getElementById('modal-employee-role').value;
            const status = document.getElementById('modal-employee-status').value;
            
            if (!fname || !lname || !email || !dob || !phone || !role || !status) {
                showToast('Please fill all fields', 'error');
                return;
            }

            fetch('php/add_employee.php', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/x-www-form-urlencoded' 
                },
                body: `employee_fname=${encodeURIComponent(fname)}&employee_lname=${encodeURIComponent(lname)}&employee_email=${encodeURIComponent(email)}&employee_dob=${encodeURIComponent(dob)}&employee_phone=${encodeURIComponent(phone)}&employee_role=${role}&employee_status=${status}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Employee added successfully');
                    renderEmployeeTable();
                    closeAddEmployeeModal();
                    document.getElementById('modal-employee-form').reset();
                } else {
                    showToast(data.message || 'Failed to add employee', 'error');
                }
            })
            .catch(error => {
                showToast('Error adding employee', 'error');
                console.error('Error:', error);
            });
        }

        // Fetch inventory items from the server and render the table
        function renderInventoryTable() {
            fetch('php/get_inventory_items.php')
                .then(response => response.json())
                .then(products => {
                    const tbody = document.getElementById('inventory-table-body');
                    tbody.innerHTML = '';
                    products.forEach(product => {
                        // Determine status
                        let statusClass, statusText;
                        if (product.quantity > 10) {
                            statusClass = 'status-in-stock';
                            statusText = 'In Stock';
                        } else if (product.quantity > 0) {
                            statusClass = 'status-low-stock';
                            statusText = 'Low Stock';
                        } else {
                            statusClass = 'status-out-of-stock';
                            statusText = 'Out of Stock';
                        }

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>
                                <div style="display: flex; align-items: center;">
                                    <img src="${product.image}" alt="Product" class="product-image">
                                    <div style="margin-left: 10px;">
                                        <div>${product.name}</div>
                                        <div style="font-size: 12px; color: #8892b0;">${product.brand}</div>
                                    </div>
                                </div>
                            </td>
                            <td>${product.category}</td>
                            <td>₱${parseFloat(product.price).toFixed(2)}</td>
                            <td>${product.quantity}</td>
                            <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                            <td>
                                <button class="action-btn edit-btn" data-product='${JSON.stringify(product).replace(/'/g, "&apos;")}'><i class="fas fa-edit"></i></button>
                                <button class="action-btn delete-btn" onclick="openDeleteProductModal(${product.id})"><i class="fas fa-trash"></i></button>
                            </td>
                        `;
                        tbody.appendChild(row);

                        // Attach event listener for edit button
                        const editBtn = row.querySelector('.edit-btn');
                        editBtn.addEventListener('click', function() {
                            const prod = JSON.parse(this.getAttribute('data-product').replace(/&apos;/g, "'"));
                            openEditProductModal(prod);
                        });
                    });
                })
                .catch(() => {
                    document.getElementById('inventory-table-body').innerHTML = '<tr><td colspan="6">Failed to load inventory.</td></tr>';
                });
        }

        // Render employee table
        function renderEmployeeTable() {
            fetch('php/get_users.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const tbody = document.getElementById('employee-table-body');
                        tbody.innerHTML = '';
                        data.users.forEach(user => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${user.first_name} ${user.last_name}</td>
                                <td>${user.email}</td>
                                <td>${user.dob}</td>
                                <td>${user.phone}</td>
                                <td>${user.role}</td>
                                <td><span class="status-badge status-${user.status}">${user.status.charAt(0).toUpperCase() + user.status.slice(1)}</span></td>
                                <td>
                                    <button class="action-btn edit-btn" onclick="showEditEmployeeModal(${user.id})"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn" onclick="showDeleteConfirmModal(${user.id}, 'user')"><i class="fas fa-trash"></i></button>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    } else {
                        document.getElementById('employee-table-body').innerHTML = '<tr><td colspan="7">Failed to load users.</td></tr>';
                    }
                })
                .catch(() => {
                    document.getElementById('employee-table-body').innerHTML = '<tr><td colspan="7">Failed to load users.</td></tr>';
                });
        }

        // Render transaction table
        function renderTransactionTable() {
            const tbody = document.getElementById('transaction-table-body');
            tbody.innerHTML = '';
            transactions.forEach(tx => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${tx.date}</td>
                    <td>${tx.customer}</td>
                    <td>${tx.item}</td>
                    <td>₱${parseFloat(tx.price).toFixed(2)}</td>
                    <td>${tx.quantity}</td>
                    <td>₱${(tx.price * tx.quantity).toFixed(2)}</td>
                `;
                tbody.appendChild(row);
            });
        }

        // View switching function
        function switchView(view) {
            document.getElementById('dashboard-content').style.display = 'none';
            document.getElementById('upload-content').style.display = 'none';
            document.getElementById('inventory-content').style.display = 'none';
            document.getElementById('employee-content').style.display = 'none';
            document.getElementById('transaction-content').style.display = 'none'; // Add this line

            document.getElementById(`${view}-content`).style.display = 'block';

            document.querySelectorAll('.sidebar-icon').forEach(icon => {
                icon.classList.remove('active');
            });

            document.getElementById(`${view}-button`).classList.add('active');

            // Save current view to localStorage
            localStorage.setItem('adminpanel_active_view', view);
        }

        // Update dashboard stats
        function updateDashboardStats() {
            const newCustomers = salesData[salesData.length - 1].customers;
            const conversionRate = (Math.random() * 5).toFixed(1);

            document.getElementById('new-customers').textContent = newCustomers;
            document.getElementById('conversion-rate').textContent = `${conversionRate}%`;

            // Random changes
            document.getElementById('sales-change').textContent = `${Math.floor(Math.random() * 15) + 5}%`;
            document.getElementById('orders-change').textContent = `${Math.floor(Math.random() * 10) + 5}%`;
            document.getElementById('customers-change').textContent = `${Math.floor(Math.random() * 10) + 5}%`;
            document.getElementById('conversion-change').textContent = `${(Math.random() * 1).toFixed(1)}%`;
        }

        // Update top products
        function updateTopProducts() {
            const period = document.getElementById('top-products-period').value;
            let topProducts = [];
            
            // Generate sample data based on period
            if (period === 'week') {
                topProducts = [
                    { name: 'Nexus Pro Keyboard', sales: 1250 },
                    { name: 'Ultra HD Monitor', sales: 980 },
                    { name: 'Gaming Mouse X1', sales: 750 },
                    { name: 'Wireless Earbuds', sales: 620 },
                    { name: 'Laptop Stand', sales: 480 }
                ];
            } else if (period === 'month') {
                topProducts = [
                    { name: 'Ultra HD Monitor', sales: 4500 },
                    { name: 'Nexus Pro Keyboard', sales: 3800 },
                    { name: 'Gaming Laptop', sales: 3200 },
                    { name: 'Wireless Earbuds', sales: 2800 },
                    { name: 'Smartphone X', sales: 2500 }
                ];
            } else { // year
                topProducts = [
                    { name: 'Gaming Laptop', sales: 32000 },
                    { name: 'Smartphone X', sales: 28500 },
                    { name: 'Ultra HD Monitor', sales: 26500 },
                    { name: 'Nexus Pro Keyboard', sales: 24000 },
                    { name: 'Wireless Earbuds', sales: 22000 }
                ];
            }
            
            const topProductsList = document.getElementById('top-products-list');
            topProductsList.innerHTML = '';
            
            topProducts.forEach((product, index) => {
                const item = document.createElement('div');
                item.className = 'product-item';
                
                item.innerHTML = `
                    <div class="product-rank">${index + 1}</div>
                    <div class="product-info">
                        <div class="product-name">${product.name}</div>
                        <div class="product-sales"><span class="product-sales-value">₱${product.sales.toLocaleString()}</span> in sales</div>
                    </div>
                `;
                
                topProductsList.appendChild(item);
            });
        }

        // Update purchase analytics
        function updatePurchaseAnalytics() {
            const analytics = [
                { icon: 'shopping-cart', name: 'Average Order Value', value: '₱89.50' },
                { icon: 'user-clock', name: 'Repeat Purchase Rate', value: '32%' },
                { icon: 'box-open', name: 'Most Purchased Category', value: 'Keyboards' },
                { icon: 'clock', name: 'Peak Shopping Time', value: '9:00 AM - 5:00 PM' },
                { icon: 'map-marker-alt', name: 'Top Location', value: 'Sabang Dano' }
            ];
            
            const analyticsContainer = document.getElementById('purchase-analytics');
            analyticsContainer.innerHTML = '';
            
            analytics.forEach(item => {
                const element = document.createElement('div');
                element.className = 'product-item';
                
                element.innerHTML = `
                    <div class="product-rank">
                        <i class="fas fa-${item.icon}"></i>
                    </div>
                    <div class="product-info">
                        <div class="product-name">${item.name}</div>
                        <div class="product-sales"><span class="product-sales-value">${item.value}</span></div>
                    </div>
                `;
                
                analyticsContainer.appendChild(element);
            });
        }

        // Setup drag and drop for file upload
        function setupDragAndDrop() {
            const fileUploadContainer = document.getElementById('file-upload-container');
            
            fileUploadContainer.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadContainer.style.borderColor = '#64ffda';
                fileUploadContainer.style.backgroundColor = '#0a192f';
            });
            
            fileUploadContainer.addEventListener('dragleave', () => {
                fileUploadContainer.style.borderColor = '#1e2d3d';
                fileUploadContainer.style.backgroundColor = '#0a192f';
            });
            
            fileUploadContainer.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUploadContainer.style.borderColor = '#1e2d3d';
                fileUploadContainer.style.backgroundColor = '#0a192f';
                
                if (e.dataTransfer.files.length) {
                    handleFileSelect({ target: { files: e.dataTransfer.files } });
                }
            });
        }

        // Handle file selection
        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            if (!file.type.match('image.*')) {
                showToast('Please select an image file', 'error');
                return;
            }
            
            if (file.size > 5 * 1024 * 1024) {
                showToast('File size should be less than 5MB', 'error');
                return;
            }
            
            selectedFile = file;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('file-preview').style.display = 'flex';
                document.getElementById('file-upload-container').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        // Remove selected image
        function removeImage() {
            selectedFile = null;
            document.getElementById('product-image').value = '';
            document.getElementById('file-preview').style.display = 'none';
            document.getElementById('file-upload-container').style.display = 'flex';
        }

        // Add product from form
        function addProduct(event) {
            event.preventDefault();
            
            const name = document.getElementById('product-name').value;
            const brand = document.getElementById('product-brand').value;
            const price = parseFloat(document.getElementById('product-price').value);
            const quantity = parseInt(document.getElementById('product-quantity').value);
            const category = document.getElementById('product-category').value;
            const description = document.getElementById('product-description').value;
            
            const newProduct = {
                id: products.length > 0 ? Math.max(...products.map(p => p.id)) + 1 : 1,
                name,
                brand,
                price,
                quantity,
                category,
                description,
                image: selectedFile ? URL.createObjectURL(selectedFile) : 'https://via.placeholder.com/50'
            };
            
            products.push(newProduct);
            renderInventoryTable();
            
            // Reset form
            document.getElementById('product-form').reset();
            if (selectedFile) {
                removeImage();
            }
            
            showToast('Product added successfully');
            closeAddProductModal();
        }

        // Add product from modal
        function addProductFromModal() {
            const name = document.getElementById('modal-product-name').value;
            const category = document.getElementById('modal-product-category').value;
            const price = parseFloat(document.getElementById('modal-product-price').value);
            const quantity = parseInt(document.getElementById('modal-product-quantity').value);
            const description = document.getElementById('modal-product-description').value;
            
            if (!name || !category || isNaN(price) || isNaN(quantity)) {
                showToast('Please fill all fields', 'error');
                return;
            }
            
            const newProduct = {
                id: products.length > 0 ? Math.max(...products.map(p => p.id)) + 1 : 1,
                name,
                brand: 'Nexus',
                price,
                quantity,
                category,
                description,
                image: selectedFile ? URL.createObjectURL(selectedFile) : 'https://via.placeholder.com/50'
            };
            
            products.push(newProduct);
            renderInventoryTable();
            
            // Reset form
            document.getElementById('modal-product-form').reset();
            
            showToast('Product added successfully');
            closeAddProductModal();
        }

        // Add employee from modal
        function addEmployeeFromModal() {
            const fname = document.getElementById('modal-employee-fname').value;
            const lname = document.getElementById('modal-employee-lname').value;
            const email = document.getElementById('modal-employee-email').value;
            const dob = document.getElementById('modal-employee-dob').value;
            const phone = document.getElementById('modal-employee-phone').value;
            const role = document.getElementById('modal-employee-role').value;
            const status = document.getElementById('modal-employee-status').value;
            
            if (!fname || !lname || !email || !dob || !phone || !role || !status) {
                showToast('Please fill all fields', 'error');
                return;
            }

            fetch('php/add_employee.php', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/x-www-form-urlencoded' 
                },
                body: `employee_fname=${encodeURIComponent(fname)}&employee_lname=${encodeURIComponent(lname)}&employee_email=${encodeURIComponent(email)}&employee_dob=${encodeURIComponent(dob)}&employee_phone=${encodeURIComponent(phone)}&employee_role=${role}&employee_status=${status}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Employee added successfully');
                    renderEmployeeTable();
                    closeAddEmployeeModal();
                    document.getElementById('modal-employee-form').reset();
                } else {
                    showToast(data.message || 'Failed to add employee', 'error');
                }
            })
            .catch(error => {
                showToast('Error adding employee', 'error');
                console.error('Error:', error);
            });
        }

        // Fetch inventory items from the server and render the table
        function renderInventoryTable() {
            fetch('php/get_inventory_items.php')
                .then(response => response.json())
                .then(products => {
                    const tbody = document.getElementById('inventory-table-body');
                    tbody.innerHTML = '';
                    products.forEach(product => {
                        // Determine status
                        let statusClass, statusText;
                        if (product.quantity > 10) {
                            statusClass = 'status-in-stock';
                            statusText = 'In Stock';
                        } else if (product.quantity > 0) {
                            statusClass = 'status-low-stock';
                            statusText = 'Low Stock';
                        } else {
                            statusClass = 'status-out-of-stock';
                            statusText = 'Out of Stock';
                        }

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>
                                <div style="display: flex; align-items: center;">
                                    <img src="${product.image}" alt="Product" class="product-image">
                                    <div style="margin-left: 10px;">
                                        <div>${product.name}</div>
                                        <div style="font-size: 12px; color: #8892b0;">${product.brand}</div>
                                    </div>
                                </div>
                            </td>
                            <td>${product.category}</td>
                            <td>₱${parseFloat(product.price).toFixed(2)}</td>
                            <td>${product.quantity}</td>
                            <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                            <td>
                                <button class="action-btn edit-btn" data-product='${JSON.stringify(product).replace(/'/g, "&apos;")}'><i class="fas fa-edit"></i></button>
                                <button class="action-btn delete-btn" onclick="openDeleteProductModal(${product.id})"><i class="fas fa-trash"></i></button>
                            </td>
                        `;
                        tbody.appendChild(row);

                        // Attach event listener for edit button
                        const editBtn = row.querySelector('.edit-btn');
                        editBtn.addEventListener('click', function() {
                            const prod = JSON.parse(this.getAttribute('data-product').replace(/&apos;/g, "'"));
                            openEditProductModal(prod);
                        });
                    });
                })
                .catch(() => {
                    document.getElementById('inventory-table-body').innerHTML = '<tr><td colspan="6">Failed to load inventory.</td></tr>';
                });
        }

        // Render employee table
        function renderEmployeeTable() {
            fetch('php/get_users.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const tbody = document.getElementById('employee-table-body');
                        tbody.innerHTML = '';
                        data.users.forEach(user => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${user.first_name} ${user.last_name}</td>
                                <td>${user.email}</td>
                                <td>${user.dob}</td>
                                <td>${user.phone}</td>
                                <td>${user.role}</td>
                                <td><span class="status-badge status-${user.status}">${user.status.charAt(0).toUpperCase() + user.status.slice(1)}</span></td>
                                <td>
                                    <button class="action-btn edit-btn" onclick="showEditEmployeeModal(${user.id})"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn" onclick="showDeleteConfirmModal(${user.id}, 'user')"><i class="fas fa-trash"></i></button>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    } else {
                        document.getElementById('employee-table-body').innerHTML = '<tr><td colspan="7">Failed to load users.</td></tr>';
                    }
                })
                .catch(() => {
                    document.getElementById('employee-table-body').innerHTML = '<tr><td colspan="7">Failed to load users.</td></tr>';
                });
        }

        // Render transaction table
        function renderTransactionTable() {
            const tbody = document.getElementById('transaction-table-body');
            tbody.innerHTML = '';
            transactions.forEach(tx => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${tx.date}</td>
                    <td>${tx.customer}</td>
                    <td>${tx.item}</td>
                    <td>₱${parseFloat(tx.price).toFixed(2)}</td>
                    <td>${tx.quantity}</td>
                    <td>₱${(tx.price * tx.quantity).toFixed(2)}</td>
                `;
                tbody.appendChild(row);
            });
        }

        // Use this function to open the modal and populate fields
        function openEditProductModal(product) {
            document.getElementById('edit-product-id').value = product.id;
            document.getElementById('edit-product-name').value = product.name;
            document.getElementById('edit-product-category').value = product.category;
            document.getElementById('edit-product-price').value = product.price;
            document.getElementById('edit-product-quantity').value = product.quantity;
            currentEditId = product.id;
            currentEditType = 'product';
            document.getElementById('edit-product-modal').style.display = 'flex';
        }

        // Close add product modal
        function closeAddProductModal() {
            document.getElementById('add-product-modal').style.display = 'none';
        }

        // Close edit product modal
        function closeEditProductModal() {
            document.getElementById('edit-product-modal').style.display = 'none';
        }

        // Update product
        function submitEditProductForm() {
            const form = document.getElementById('edit-product-form');
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Product updated successfully');
                    renderInventoryTable();
                    closeEditProductModal();
                } else {
                    showToast(data.message || 'Failed to update product', 'error');
                }
            })
            .catch(() => {
                showToast('Failed to update product', 'error');
            });
        }

        // Show add employee modal
        function showAddEmployeeModal() {
            // Only allow Admin to add Staff
            const userRole = "<?php echo isset($rank) ? $rank : ''; ?>";
            const roleSelect = document.getElementById('modal-employee-role');
            if (userRole.toLowerCase() !== 'admin') {
                // If not admin, disable Staff option
                for (let i = 0; i < roleSelect.options.length; i++) {
                    if (roleSelect.options[i].value === 'Staff') {
                        roleSelect.options[i].disabled = true;
                    }
                }
            } else {
                // If admin, enable all options
                for (let i = 0; i < roleSelect.options.length; i++) {
                    roleSelect.options[i].disabled = false;
                }
            }
            document.getElementById('add-employee-modal').style.display = 'flex';
        }

        // Close add employee modal
        function closeAddEmployeeModal() {
            document.getElementById('add-employee-modal').style.display = 'none';
        }

        // Show edit employee modal
        function showEditEmployeeModal(id) {
            // Get employee data from the most recent API response
            fetch('php/get_employees.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const employee = data.employees.find(e => e.employee_id === id);
                        if (!employee) {
                            showToast('Employee not found', 'error');
                            return;
                        }

                        // Populate the modal fields
                        document.getElementById('edit-employee-id').value = employee.employee_id;
                        document.getElementById('edit-employee-fname').value = employee.employee_fname;
                        document.getElementById('edit-employee-lname').value = employee.employee_lname;
                        document.getElementById('edit-employee-dob').value = employee.employee_dob;
                        document.getElementById('edit-employee-phone').value = employee.phone;
                        document.getElementById('edit-employee-role').value = employee.role;
                        document.getElementById('edit-employee-status').value = 'active'; // Default to active

                        // Show the modal
                        document.getElementById('edit-employee-modal').style.display = 'flex';
                    } else {
                        showToast('Failed to fetch employee data', 'error');
                    }
                })
                .catch(() => {
                    showToast('Failed to fetch employee data', 'error');
                });
        }

        // Close edit employee modal
        function closeEditEmployeeModal() {
            document.getElementById('edit-employee-modal').style.display = 'none';
        }

        // Logout function
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

        // Update employee
        function updateEmployee() {
            const employeeId = document.getElementById('edit-employee-id').value;
            const employeeFname = document.getElementById('edit-employee-fname').value;
            const employeeLname = document.getElementById('edit-employee-lname').value;
            const employeeDob = document.getElementById('edit-employee-dob').value;
            const employeePhone = document.getElementById('edit-employee-phone').value;
            const employeeRole = document.getElementById('edit-employee-role').value;
            const employeeStatus = document.getElementById('edit-employee-status').value;

            // Send data to server
            fetch('php/edit_employee.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `employee_id=${employeeId}&employee_fname=${encodeURIComponent(employeeFname)}&employee_lname=${encodeURIComponent(employeeLname)}&employee_dob=${encodeURIComponent(employeeDob)}&employee_phone=${encodeURIComponent(employeePhone)}&employee_role=${employeeRole}&employee_status=${employeeStatus}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Employee updated successfully');
                    renderEmployeeTable(); // Refresh the table
                    closeEditEmployeeModal();
                } else {
                    showToast(data.message || 'Failed to update employee', 'error');
                }
            })
            .catch(error => {
                showToast('Error updating employee', 'error');
                console.error('Error:', error);
            });
        }

        // Show delete confirmation modal
        function showDeleteConfirmModal(id, type) {
            currentDeleteId = id;
            currentDeleteType = type;
            
            const itemType = type === 'product' ? 'product' : 'employee';
            document.getElementById('delete-item-type').textContent = itemType;
            document.getElementById('delete-confirm-modal').style.display = 'flex';
        }
            
        // Close delete confirmation modal
        function closeDeleteConfirmModal() {
            document.getElementById('delete-confirm-modal').style.display = 'none';
        }
            
        // Confirm delete
        function confirmDelete() {
            if (currentDeleteType === 'product') {
                products = products.filter(p => p.id !== currentDeleteId);
                renderInventoryTable();
                showToast('Item deleted successfully');
                closeDeleteConfirmModal();
            } else if (currentDeleteType === 'employee') {
                // Call PHP to delete employee from database
                fetch('php/delete_employee.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `employee_id=${currentDeleteId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Employee deleted successfully');
                        renderEmployeeTable();
                    } else {
                        showToast(data.message || 'Failed to delete employee', 'error');
                    }
                    closeDeleteConfirmModal();
                })
                .catch(() => {
                    showToast('Failed to delete employee', 'error');
                    closeDeleteConfirmModal();
                });
            }
        }

        // Delete product
        function openDeleteProductModal(productId) {
            currentDeleteProductId = productId;
            document.getElementById('delete-product-modal').style.display = 'flex';
        }

        function closeDeleteProductModal() {
            currentDeleteProductId = null;
            document.getElementById('delete-product-modal').style.display = 'none';
        }

        function deleteProduct() {
            if (!currentDeleteProductId) return;

            fetch('php/delete_product.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `product_id=${currentDeleteProductId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Product deleted successfully');
                    renderInventoryTable(); // Refresh inventory table
                } else {
                    showToast(data.message, 'error');
                }
                closeDeleteProductModal();
            })
            .catch(() => {
                showToast('Failed to delete product', 'error');
                closeDeleteProductModal();
            });
        }
            
        // Show toast notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            
            toastMessage.textContent = message;
            toast.style.borderLeftColor = type === 'success' ? '#64ffda' : '#ff5555';
            toast.style.transform = 'translateY(0)';
            toast.style.opacity = '1';
            
            setTimeout(() => {
                toast.style.transform = 'translateY(100px)';
                toast.style.opacity = '0';
            }, 3000);
        }
    </script>
</body>
</html>