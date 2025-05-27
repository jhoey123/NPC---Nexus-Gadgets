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

$totalSales = getItems_sold();
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
            <span class="sidebar-text">Employees</span>
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
            </div>
            <div class="stat-card">
                <div class="stat-title">Today's Orders</div>
                <div class="stat-value" id="today-orders">
                    <?php echo $todaysOrders; ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-title">New Customers</div>
                <div class="stat-value" id="new-customers">15</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Conversion Rate</div>
                <div class="stat-value" id="conversion-rate">3.2%</div>
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
                        <th>Barcode ID</th>
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
                        <label for="edit-product-brand">Brand</label>
                        <input type="text" id="edit-product-brand" name="product_brand" placeholder="Enter brand name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-product-category">Category</label>
                        <select id="edit-product-category" name="Category_id" required>
                            <option value="">Select category</option>
                            <option value="1">Laptops</option>
                            <option value="2">Smartphones</option>
                            <option value="4">Keyboards</option>
                            <option value="3">Mouse</option> 
                            <option value="5">Monitors</option>
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
            <h2 class="employee-title">Employee Management</h2>
            <p class="employee-subtitle">View and manage all Employee accounts (Admin, Staff, User)</p>
        </div>
        
        <div class="employee-actions">
            <div class="employee-search">
                <i class="fas fa-search"></i>
                <input type="text" id="employee-search" placeholder="Search users..." oninput="searchEmployees()">
            </div>
            <button class="add-employee-btn" onclick="showAddEmployeeModal()">
                <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Add Employee
            </button>
        </div>
        
        <div class="employee-table">
            <table>
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
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
                <div class="modal-title">Add New Employee</div>
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
                <div class="modal-title">Edit Employee</div>
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
                <button class="modal-btn modal-btn-primary" onclick="updateEmployee()">Update Employee</button>
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

    <!-- Create Account Modal -->
    <div class="modal" id="create-account-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Create Account</div>
                <button class="modal-close" onclick="closeCreateAccountModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="create-account-form" action="php/create_account.php" method="POST">
                    <input type="hidden" id="create-account-employee-id" name="employee_id">
                    <div class="form-group">
                        <label for="create-account-username">Username</label>
                        <input type="text" id="create-account-username" name="username" placeholder="Enter username" required>
                    </div>
                    <div class="form-group">
                        <label for="create-account-fname">First Name</label>
                        <input type="text" id="create-account-fname" name="first_name" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group">
                        <label for="create-account-lname">Last Name</label>
                        <input type="text" id="create-account-lname" name="last_name" placeholder="Enter last name" required>
                    </div>
                    <div class="form-group">
                        <label for="create-account-email">Email</label>
                        <input type="email" id="create-account-email" name="email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="create-account-password">Password</label>
                        <input type="password" id="create-account-password" name="password" placeholder="Enter password" required>
                    </div>
                    <div class="form-group">
                        <label for="create-account-confirm-password">Confirm Password</label>
                        <input type="password" id="create-account-confirm-password" name="confirm_password" placeholder="Confirm password" required>
                    </div>
                    <div class="form-group">
                        <label for="create-account-role">Role</label>
                        <select id="create-account-role" name="rank_id" required>
                            <option value="">Select Role</option>
                            <option value="1">Admin</option>
                            <option value="2">Staff</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" onclick="closeCreateAccountModal()">Cancel</button>
                <button class="modal-btn modal-btn-primary" onclick="submitCreateAccountForm()">Create Account</button>
            </div>
        </div>
    </div>

    <!-- Account Details Modal -->
    <div class="modal" id="account-details-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Account Details</div>
                <button class="modal-close" onclick="closeAccountDetailsModal()">&times;</button>
            </div>
            <div class="modal-body" id="account-details-modal-body">
                <!-- Content will be populated dynamically -->
            </div>
        </div>
    </div>

    <!-- Edit Account Modal -->
    <div class="modal" id="edit-account-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Edit Account</div>
                <button class="modal-close" onclick="closeEditAccountModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="edit-account-form">
                    <input type="hidden" id="edit-account-id" name="account_id">
                    <div class="form-group">
                        <label for="edit-account-username">Username</label>
                        <input type="text" id="edit-account-username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-account-email">Email</label>
                        <input type="email" id="edit-account-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-account-password">Password <span style="font-weight:normal">(leave blank to keep current)</span></label>
                        <input type="password" id="edit-account-password" name="password" autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label for="edit-account-role">Role</label>
                        <select id="edit-account-role" name="rank_id" required>
                            <option value="1">Admin</option>
                            <option value="2">Staff</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" onclick="closeEditAccountModal()">Cancel</button>
                <button class="modal-btn modal-btn-primary" onclick="submitEditAccountForm()">Update Account</button>
            </div>
        </div>
    </div>

    <style>
        /* Add these styles to your existing styles */
        .account-details {
            padding: 20px;
        }
        
        .detail-group {
            margin-bottom: 20px;
        }
        
        .detail-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
                color: white;
            font-size: 1.5rem; /* Make section labels bigger */
        }
        
        .detail-group div {
            margin: 8px 0;
            color: white;
        }
        
        .detail-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .modal-btn-danger {
            background-color: #dc2626;
            color: white;
        }
        
        .modal-btn-primary {
            background-color: #6366f1;
            color: white;
        }
    </style>

    <script>
        // Data storage
        let products = [];
        let employees = [];
        let salesData = [];
        let transactions = [];

        // Show toast if redirected with ?success or ?error
        (function() {
            const params = new URLSearchParams(window.location.search);
            if (params.has('success')) {
                showToast('Product added successfully');
                window.history.replaceState({}, document.title, window.location.pathname);
            } else if (params.has('error')) {
                showToast(params.get('error'), 'error');
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        })();  
        
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
                                color: '#8892b0',
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                }
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
        }

        // Update top products
        function updateTopProducts() {
            fetch('php/top_selling_products.php')
        .then(response => response.json())
        .then(data => {
            const topProductsList = document.getElementById('top-products-list');
            topProductsList.innerHTML = '';
            data.forEach((product, index) => {
                const totalSales = parseFloat(product.TotalSales); // Use the correct key
                const item = document.createElement('div');
                item.className = 'product-item';
                item.innerHTML = `
                    <div class="product-rank">${index + 1}</div>
                    <div class="product-info">
                        <div class="product-name">${product.Product_name}</div>
                        <div class="product-sales"><span class="product-sales-value">₱${totalSales.toLocaleString()}</span> in sales</div>
                    </div>
                `;
                topProductsList.appendChild(item);
            });
        })
        .catch(error => {
            console.error('Error fetching top products:', error);
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



        // DASHBOARD END


        //inventory START

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
                                    <img src="uploads/${product.image}" alt="Product" class="product-image">
                                    <div style="margin-left: 10px;">
                                        <div>${product.name}</div>
                                        <div style="font-size: 12px; color: #8892b0;">${product.brand}</div>
                                    </div>
                                </div>
                            </td>
                            <td>${product.category}</td>
                            <td>₱${parseFloat(product.price).toFixed(2)}</td>
                            <td>${product.barcode}</td>
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


        function searchProducts() {
            const searchInput = document.getElementById('inventory-search').value.toLowerCase();
            const searchTerms = searchInput.split(' ').filter(term => term.trim() !== '');
            const tableRows = document.querySelectorAll('#inventory-table-body tr');

            tableRows.forEach(row => {
                const productName = row.querySelector('td:nth-child(1) div div').textContent.toLowerCase();
                const productCategory = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const productBrand = row.querySelector('td:nth-child(1) div div:nth-child(2)').textContent.toLowerCase();

                const rowText = `${productName} ${productCategory} ${productBrand}`;
                const matches = searchTerms.every(term => rowText.includes(term));

                row.style.display = matches ? '' : 'none';
            });
        }

        // Close add product modal
        function closeAddProductModal() {
            document.getElementById('add-product-modal').style.display = 'none';
        }

        // Use this function to open the modal and populate fields
        function openEditProductModal(product) {
            document.getElementById('edit-product-id').value = product.id;
            document.getElementById('edit-product-name').value = product.name;
            document.getElementById('edit-product-brand').value = product.brand;
            
            // Map category names to their corresponding IDs
            const categoryMap = {
                'LAPTOPS': '1',
                'SMARTPHONES': '2',
                'MOUSE': '3',
                'KEYBOARDS': '4',
                'MONITORS': '5'
            };
            
            // Set category value based on the product's category name
            const categoryId = categoryMap[product.category.toUpperCase()] || '';
            document.getElementById('edit-product-category').value = categoryId;
            
            document.getElementById('edit-product-price').value = product.price;
            document.getElementById('edit-product-quantity').value = product.quantity;
            currentEditId = product.id;
            currentEditType = 'product';
            document.getElementById('edit-product-modal').style.display = 'flex';
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

        // Close edit product modal
        function closeEditProductModal() {
            document.getElementById('edit-product-modal').style.display = 'none';
        }

        // Delete product
        function openDeleteProductModal(productId) {
            currentDeleteProductId = productId;
            document.getElementById('delete-product-modal').style.display = 'flex';
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

        function closeDeleteProductModal() {
            currentDeleteProductId = null;
            document.getElementById('delete-product-modal').style.display = 'none';
        }


        // inventory END


        // employee START

        // Render employee table
        function renderEmployeeTable() {
            fetch('php/get_employees.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const tbody = document.getElementById('employee-table-body');
                        tbody.innerHTML = '';
                        data.employees.forEach(employee => {
                            const hasAccount = parseInt(employee.has_account) === 1;
                            const row = document.createElement('tr');
                            row.setAttribute('data-employee-id', employee.employee_id);
                            row.style.width = '100%';
                            row.innerHTML = `
                                <td style="width: 10%">${employee.employee_id}</td>
                                <td style="width: 12%">${employee.employee_fname}</td>
                                <td style="width: 12%">${employee.employee_lname}</td>
                                <td style="width: 12%">${employee.employee_email || ''}</td>
                                <td style="width: 12%">${employee.employee_dob}</td>
                                <td style="width: 12%">${employee.phone}</td>
                                <td style="width: 12%">${employee.role}</td>
                                <td style="width: 10%"><span class="status-badge status-${employee.status}">${employee.status.charAt(0).toUpperCase() + employee.status.slice(1)}</span></td>
                                <td style="width: 10%; text-align: center; padding-left: 0px;">
                                    <div style="display: flex; justify-content: flex-start; align-items: center; gap: 8px;">
                                        <button class="action-btn edit-btn" onclick="showEditEmployeeModal(${employee.employee_id})"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn delete-btn" onclick="showDeleteConfirmModal(${employee.employee_id}, 'employee')"><i class="fas fa-trash"></i></button>
                                        ${hasAccount 
                                            ? `<button class="action-btn account-created-btn" style="color: #22c55e;" title="Account Created" onclick="showAccountDetails(${employee.employee_id})">
                                                <i class="fas fa-user-check"></i>
                                               </button>`
                                            : `<button class="action-btn create-account-btn" style="color: #007bff;" onclick="showCreateAccountModal(${employee.employee_id})">
                                                <i class="fas fa-user-plus"></i>
                                               </button>`
                                        }
                                    </div>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    } else {
                        document.getElementById('employee-table-body').innerHTML = '<tr><td colspan="8">Failed to load employees.</td></tr>';
                    }
                })
                .catch(() => {
                    document.getElementById('employee-table-body').innerHTML = '<tr><td colspan="8">Failed to load employees.</td></tr>';
                });
        }


        // Add this function to enable employee search
        function searchEmployees() {
            const searchInput = document.getElementById('employee-search').value.toLowerCase();
            const searchTerms = searchInput.split(' ').filter(term => term.trim() !== '');
            const tableRows = document.querySelectorAll('#employee-table-body tr');

            tableRows.forEach(row => {
                const firstName = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const lastName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const role = row.querySelector('td:nth-child(6)').textContent.toLowerCase();

                const rowText = `${firstName} ${lastName} ${email} ${role}`;
                const matches = searchTerms.every(term => rowText.includes(term));

                row.style.display = matches ? '' : 'none';
            });
        }

        // Show add employee modal
        function showAddEmployeeModal() {
            document.getElementById('add-employee-modal').style.display = 'flex';
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
                body: `employee_fname=${encodeURIComponent(fname)}&employee_lname=${encodeURIComponent(lname)}&employee_email=${encodeURIComponent(email)}&employee_dob=${encodeURIComponent(dob)}&employee_phone=${encodeURIComponent(phone)}&employee_role=${encodeURIComponent(role)}&employee_status=${encodeURIComponent(status)}`
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
                        const employee = data.employees.find(e => e.employee_id == id);
                        if (!employee) {
                            showToast('Employee not found', 'error');
                            return;
                        }

                        // Populate the modal fields
                        document.getElementById('edit-employee-id').value = employee.employee_id;
                        document.getElementById('edit-employee-fname').value = employee.employee_fname;
                        document.getElementById('edit-employee-lname').value = employee.employee_lname;
                        document.getElementById('edit-employee-email').value = employee.employee_email || '';
                        document.getElementById('edit-employee-dob').value = employee.employee_dob;
                        document.getElementById('edit-employee-phone').value = employee.phone;
                        document.getElementById('edit-employee-role').value = employee.role;
                        document.getElementById('edit-employee-status').value = employee.status;

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

        // Update employee
        function updateEmployee() {
            const employeeId = document.getElementById('edit-employee-id').value;
            const employeeFname = document.getElementById('edit-employee-fname').value;
            const employeeLname = document.getElementById('edit-employee-lname').value;
            const employeeEmail = document.getElementById('edit-employee-email').value;
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
                body: `employee_id=${encodeURIComponent(employeeId)}&employee_fname=${encodeURIComponent(employeeFname)}&employee_lname=${encodeURIComponent(employeeLname)}&employee_email=${encodeURIComponent(employeeEmail)}&employee_dob=${encodeURIComponent(employeeDob)}&employee_phone=${encodeURIComponent(employeePhone)}&employee_role=${encodeURIComponent(employeeRole)}&employee_status=${encodeURIComponent(employeeStatus)}`
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

        // Close edit employee modal
        function closeEditEmployeeModal() {
            document.getElementById('edit-employee-modal').style.display = 'none';
        }

        // Show delete EMPLOYEE confirmation modal
        function showDeleteConfirmModal(id, type) {
            currentDeleteId = id;
            currentDeleteType = type;
            
            const itemType = type === 'product' ? 'product' : 'employee';
            document.getElementById('delete-item-type').textContent = itemType;
            document.getElementById('delete-confirm-modal').style.display = 'flex';
        }
            
        // Close delete EMPLOYEE confirmation modal
        function closeDeleteConfirmModal() {
            document.getElementById('delete-confirm-modal').style.display = 'none';
        }

        // Confirm delete EMPLOYEE
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

        // Show employee create account modal
        function showCreateAccountModal(employeeId) {
            // Ensure the employee_id is set correctly
            const inputField = document.getElementById('create-account-employee-id');
            inputField.value = employeeId ? employeeId : ''; // Set the value or clear it if null
            document.getElementById('create-account-modal').style.display = 'flex';
        }

        // Close employee create account modal
        function closeCreateAccountModal() {
            document.getElementById('create-account-modal').style.display = 'none';
        }

        // Submit employee create account form
        function submitCreateAccountForm() {
            const form = document.getElementById('create-account-form');
            const formData = {};
            // Get all form inputs including the hidden employee_id
            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                // Only add if input has a name (avoid empty names)
                if (input.name) {
                    formData[input.name] = input.value;
                }
            });

            // Debug: log employee_id
            console.log('employee_id sent:', formData['employee_id']);

            fetch('php/create_account.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams(formData).toString()
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Account created successfully');
                    closeCreateAccountModal();
                    renderEmployeeTable(); // Refresh the table to update buttons
                } else {
                    showToast(data.message || 'Failed to create account', 'error');
                }
            })
            .catch(error => {
                showToast('Error creating account', 'error');
            });
        }

            function showAccountDetails(employeeId) {
    fetch(`php/get_account_details.php?employee_id=${employeeId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const account = data.account;
                const modalContent = `
                    <div class="account-details">
                        <div class="detail-group">
                            <label>Account Information</label>
                            <div><strong>Username:</strong> ${account.username}</div>
                            <div><strong>Account Email:</strong> ${account.email}</div>
                            <div><strong>Role:</strong> ${account.role}</div>
                        </div>
                        
                        <div class="detail-group">
                            <label>Employee Information</label>
                            <div><strong>Employee Name:</strong> ${account.employee_fname} ${account.employee_lname}</div>
                            <div><strong>Employee Email:</strong> ${account.employee_email}</div>
                        </div>
                        
                        <div class="detail-actions">
                            <button class="modal-btn modal-btn-primary" onclick="editAccount(${account.account_id})">
                                <i class="fas fa-edit"></i> Edit Account
                            </button>
                            <button class="modal-btn modal-btn-danger" onclick="deleteAccount(${account.account_id}, ${employeeId})">
                                <i class="fas fa-trash"></i> Delete Account
                            </button>
                        </div>
                    </div>
                `;
                
                document.getElementById('account-details-modal-body').innerHTML = modalContent;
                document.getElementById('account-details-modal').style.display = 'flex';
            } else {
                showToast(data.message || 'Failed to fetch account details', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to fetch account details: ' + error.message, 'error');
        });
}

        // Add this function to handle closing the modal
        function closeAccountDetailsModal() {
            document.getElementById('account-details-modal').style.display = 'none';
        }

    function editAccount(accountId) {
        // Get the account details from the modal
        const modalBody = document.getElementById('account-details-modal-body');
        const accountDetails = modalBody.querySelector('.account-details');
        let username = '', email = '', role = '';

        // Find all divs in the first detail-group (Account Information)
        const detailGroups = accountDetails.querySelectorAll('.detail-group');
        if (detailGroups.length > 0) {
            const infoDivs = detailGroups[0].querySelectorAll('div');
            infoDivs.forEach(div => {
                if (div.textContent.includes('Username:')) {
                    username = div.textContent.replace('Username:', '').trim();
                }
                if (div.textContent.includes('Account Email:')) {
                    email = div.textContent.replace('Account Email:', '').trim();
                }
                if (div.textContent.includes('Role:')) {
                    role = div.textContent.replace('Role:', '').trim();
                }
            });
        }

        document.getElementById('edit-account-id').value = accountId;
        document.getElementById('edit-account-username').value = username;
        document.getElementById('edit-account-email').value = email;
        document.getElementById('edit-account-role').value = role.toLowerCase() === 'admin' ? '1' : '2';

        closeAccountDetailsModal();
        document.getElementById('edit-account-modal').style.display = 'flex';
    }

    function closeEditAccountModal() {
        document.getElementById('edit-account-modal').style.display = 'none';
    }

    function submitEditAccountForm() {
        const form = document.getElementById('edit-account-form');
        const formData = new FormData(form);
        // If password is blank, remove it from the request
        if (!formData.get('password')) {
            formData.delete('password');
        }
        fetch('php/edit_account.php', {
            method: 'POST',
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Account updated successfully');
                closeEditAccountModal();
                renderEmployeeTable(); // Refresh the employee table
            } else {
                showToast(data.message || 'Failed to update account', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error updating account', 'error');
        });
    }

    function deleteAccount(accountId, employeeId) {
        if (!confirm('Are you sure you want to delete this account? This action cannot be undone.')) {
            return;
        }
        fetch('php/delete_account.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `account_id=${encodeURIComponent(accountId)}&employee_id=${encodeURIComponent(employeeId)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Account deleted successfully');
                closeAccountDetailsModal();
                renderEmployeeTable();
            } else {
                showToast(data.message || 'Failed to delete account', 'error');
            }
        })
        .catch(error => {
            showToast('Error deleting account', 'error');
        });
    }

    // employee END

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
    </script>
</body>
</html>