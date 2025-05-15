<?php


session_start();
//$_SESSION['user'] = "admin"; // For testing purposes, set a session variable to simulate a logged-in user

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
} else {
    include "php/conn_db.php";
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, #0a192f 0%, #172a45 100%);
            display: flex;
            min-height: 100vh;
            cursor: default;
            color: #e6f1ff;
        }

        /* Sidebar styles */
        .sidebar {
            width: 80px;
            background: linear-gradient(180deg, #0a192f 10%, #020c1b 90%);
            color: #e6f1ff;
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
            border-right: 1px solid #1e2d3d;
        }

        .sidebar:hover {
            width: 200px;
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
            color: #6366f1;
            transition: all 0.3s;
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
            width: 70px;
            height: 70px;
            border-radius: 50%;
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
        }

        .sidebar:hover .sidebar-icon.logo {
            justify-content: center;
            padding-left: 0;
            flex-direction: column;
            background-color: transparent;
        }

        .sidebar-icon.logo:hover {
            background-color: transparent !important;
        }

        .sidebar:hover .sidebar-icon {
            width: 100%;
            justify-content: flex-start;
            padding-left: 37px;
            margin-bottom: 15px;
            transition: width 0.5s;
            opacity: 1;
            gap: 10px;
        }

        .sidebar-icon.active {
            background-color: #1e2d3d;
            color: #6366f1;
        }

        .sidebar-icon.active .sidebar-text {
            color: #6366f1;
        }

        .sidebar-icon:active,
        .sidebar-icon.active:active {
            background-color: #0a192f;
            color: #6366f1;
        }

        .sidebar-icon:hover:not(.active) {
            background-color: #1e2d3d;
            color: #6366f1;
        }

        .sidebar-icon:active {
            background-color: #0a192f;
        }

        .sidebar-text {
            display: none;
            font-size: 14px;
            color: #ccd6f6;
            transition: all 0.5s;
        }

        .sidebar:hover .sidebar-text {
            display: inline;
            transition: margin-left 0.5s;
        }

        /* Dashboard styles */
        .main-content {
            flex: 1;
            padding: 25px;
            padding-left: 100px;
            transition: margin-left 0.5s;
        }   

        .sidebar:hover ~ .main-content {
            margin-left: 130px; 
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .dashboard-title {
            font-size: 28px;
            font-weight: 700;
            color: #6366f1;
        }

        .date-display {
            font-size: 16px;
            color: #8892b0;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #112240;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #1e2d3d;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }

        .stat-title {
            font-size: 14px;
            color: #8892b0;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #e6f1ff;
        }

        .stat-change {
            display: flex;
            align-items: center;
            font-size: 12px;
            margin-top: 8px;
        }

        .stat-change.up {
            color: #6366f1;
        }

        .stat-change.down {
            color: #ff5555;
        }

        .chart-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: #112240;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #1e2d3d;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #6366f1;
        }

        .chart-period {
            font-size: 14px;
            color: #8892b0;
        }

        .chart-placeholder {
            height: 300px;
            background-color: #0a192f;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8892b0;
            border: 1px dashed #1e2d3d;
        }

        .products-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .product-list {
            background: #112240;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #1e2d3d;
        }

        .product-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .product-list-title {
            font-size: 18px;
            font-weight: 600;
            color: #6366f1;
        }

        .product-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #1e2d3d;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-rank {
            font-weight: 700;
            color: #6366f1;
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-size: 14px;
            font-weight: 500;
            color: #e6f1ff;
        }

        .product-sales {
            font-size: 12px;
            color: #8892b0;
        }

        .product-sales-value {
            font-weight: 600;
            color: #6366f1;
        }

        /* Upload section styles */
        .upload-content {
            flex: 1;
            padding: 25px;
            padding-left: 100px;
            transition: margin-left 0.5s;
            display: none;
        }

        .sidebar:hover ~ .upload-content {
            margin-left: 130px;
        }

        .upload-container {
            max-width: 800px;
            margin: 0 auto;
            background: #112240;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #1e2d3d;
        }

        .upload-header {
            margin-bottom: 30px;
        }

        .upload-title {
            font-size: 24px;
            font-weight: 700;
            color: #6366f1;
            margin-bottom: 10px;
        }

        .upload-subtitle {
            font-size: 16px;
            color: #8892b0;
        }

        .upload-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #e6f1ff;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            background-color: #0a192f;
            border: 1px solid #1e2d3d;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
            color: #e6f1ff;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #64ffda;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .file-upload {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            border: 2px dashed #1e2d3d;
            border-radius: 8px;
            cursor: pointer;
            transition: border-color 0.3s, background-color 0.3s;
            background-color: #0a192f;
        }

        .file-upload:hover {
            border-color: #6366f1;
            background-color: #112240;
        }

        .file-upload-icon {
            font-size: 24px;
            color: #6366f1;
            margin-bottom: 10px;
        }

        .file-upload-text {
            font-size: 14px;
            color: #8892b0;
            text-align: center;
        }

        .file-upload-text span {
            color: #6366f1;
            font-weight: 500;
        }

        .file-upload input {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-btn {
            grid-column: span 2;
            background-color: #6366f1;
            color: #0a192f;
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .upload-btn:hover {
            background-color: #525ddc;
        }

        /* Inventory section styles */
        .inventory-content {
            flex: 1;
            padding: 25px;
            padding-left: 100px;
            transition: margin-left 0.5s;
            display: none;
        }

        .sidebar:hover ~ .inventory-content {
            margin-left: 130px;
        }

        .inventory-header {
            margin-bottom: 30px;
        }

        .inventory-title {
            font-size: 24px;
            font-weight: 700;
            color: #6366f1;
            margin-bottom: 10px;
        }

        .inventory-subtitle {
            font-size: 16px;
            color: #8892b0;
        }

        .inventory-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .inventory-search {
            position: relative;
            width: 300px;
        }

        .inventory-search input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            background-color: #0a192f;
            border: 1px solid #1e2d3d;
            border-radius: 8px;
            font-size: 14px;
            color: #e6f1ff;
        }

        .inventory-search i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8892b0;
        }

        <button class="add-product-btn" onclick="showAddProductModal()">
    <i class="fas fa-plus" style="margin-right: 8px;"></i> Add Product
</button>

        .inventory-table {
            width: 100%;
            background: #112240;
            border-radius: 12px;
            overflow: hidden;
            transition: background-color 0.3s;
        }

        .add-product-btn:hover {
            background-color: #525ddc;
        }

        .inventory-table {
            width: 100%;
            background: #112240;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #1e2d3d;
        }

        .inventory-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .inventory-table th {
            background-color: #0a192f;
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            color: #6366f1;
            border-bottom: 1px solid #1e2d3d;
        }

        .inventory-table td {
            padding: 12px 15px;
            font-size: 14px;
            color: #e6f1ff;
            border-bottom: 1px solid #1e2d3d;
        }

        .inventory-table tr:last-child td {
            border-bottom: none;
        }

        .inventory-table tr:hover {
            background-color: #0a192f;
        }

        .product-image {
            width: 50px;
            height: 50px;
            border-radius: 6px;
            object-fit: cover;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-in-stock {
            background-color: rgba(100, 255, 218, 0.1);
            color: #64ffda;
        }

        .status-low-stock {
            background-color: rgba(255, 213, 0, 0.1);
            color: #ffd500;
        }

        .status-out-of-stock {
            background-color: rgba(255, 85, 85, 0.1);
            color: #ff5555;
        }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
            color: #8892b0;
            transition: color 0.3s;
        }

        .edit-btn {
            color: #64ffda;
        }

        .edit-btn:hover {
            color: #52d9c4;
        }

        .delete-btn {
            color: #ff5555;
        }

        .delete-btn:hover {
            color: #ff3333;
        }

        /* Employee section styles */
        .employee-content {
            flex: 1;
            padding: 25px;
            padding-left: 100px;
            transition: margin-left 0.5s;
            display: none;
        }

        .sidebar:hover ~ .employee-content {
            margin-left: 130px;
        }

        .employee-header {
            margin-bottom: 30px;
        }

        .employee-title {
            font-size: 24px;
            font-weight: 700;
            color: #6366f1; /* Updated color */
            margin-bottom: 10px;
        }

        .employee-subtitle {
            font-size: 16px;
            color: #6366f1; /* Updated color */
        }

        .employee-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .employee-search {
            position: relative;
            width: 300px;
        }

        .employee-search input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            background-color: #0a192f;
            border: 1px solid #1e2d3d;
            border-radius: 8px;
            font-size: 14px;
            color: #6366f1; /* Updated color */
        }

        .employee-search i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8892b0;
        }

        .add-employee-btn {
            background-color: #6366f1;
            color: #0a192f;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-employee-btn:hover {
            background-color: #525ddc;
        }

        .employee-table {
            width: 100%;
            background: #112240;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #1e2d3d;
        }

        .employee-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .employee-table th {
            background-color: #0a192f;
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            color: #6366f1; /* Updated color */
            border-bottom: 1px solid #1e2d3d;
        }

        .employee-table td {
            padding: 12px 15px;
            font-size: 14px;
            color: #6366f1; /* Updated color */
            border-bottom: 1px solid #1e2d3d;
        }

        .employee-table tr:last-child td {
            border-bottom: none;
        }

        .employee-table tr:hover {
            background-color: #0a192f;
        }

        .employee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .role-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .role-admin {
            background-color: rgba(100, 255, 218, 0.1);
            color: #6366f1;
        }

        .role-manager {
            background-color: rgba(0, 191, 255, 0.1);
            color: #00bfff;
        }

        .role-staff {
            background-color: rgba(138, 43, 226, 0.1);
            color: #8a2be2;
        }

        /* Modal styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
        }

        .modal-content {
            background: #112240;
            border-radius: 12px;
            width: 500px;
            max-width: 90%;
            /* Remove max-height and overflow to prevent scrolling */
            height: auto;
            overflow: visible;
            border: 1px solid #1e2d3d;
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #1e2d3d;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #64ffda;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #8892b0;
            transition: color 0.3s;
        }

        .modal-close:hover {
            color: #ff5555;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid #1e2d3d;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .modal-btn-primary {
            background-color: #6366f1;
            color: #0a192f;
            border: none;
        }

        .modal-btn-primary:hover {
            background-color: #525ddc;
        }

        .modal-btn-secondary {
            background-color: transparent;
            color: #e6f1ff;
            border: 1px solid #1e2d3d;
        }

        .modal-btn-secondary:hover {
            background-color: #0a192f;
        }

        /* Toast notification */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #112240;
            color: #e6f1ff;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-left: 4px solid #6366f1;
            display: flex;
            align-items: center;
            z-index: 1001;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast i {
            margin-right: 10px;
            color: #6366f1;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .chart-container {
                grid-template-columns: 1fr;
            }
            
            .products-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .upload-form {
                grid-template-columns: 1fr;
            }
            
            .form-group.full-width {
                grid-column: span 1;
            }
            
            .upload-btn {
                grid-column: span 1;
            }
        }
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
        <div style="flex: 1;"></div>
        <div class="sidebar-icon" id="logout-button" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i>
            <span class="sidebar-text">Logout</span>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="main-content" id="dashboard-content">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Admin POS Dashboard</h1>
                <div class="date-display">Today, <span id="current-date"></span></div>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-title">Total Sales</div>
                <div class="stat-value" id="total-sales">₱12,345</div>
                <div class="stat-change up">
                    <i class="fas fa-arrow-up"></i> <span id="sales-change">12%</span> from yesterday
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Today's Orders</div>
                <div class="stat-value" id="today-orders">42</div>
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
    <div class="upload-content" id="upload-content">
        <div class="upload-container">
            <div class="upload-header">
                <h2 class="upload-title">Add New Product</h2>
                <p class="upload-subtitle">Fill in the details below to add a new product to inventory</p>
            </div>
            
            <form class="upload-form" id="product-form" onsubmit="addProduct(event)">
                <div class="form-group">
                    <label for="product-name">Product Name</label>
                    <input type="text" id="product-name" placeholder="Enter product name" required>
                </div>
                
                <div class="form-group">
                    <label for="product-brand">Brand</label>
                    <input type="text" id="product-brand" placeholder="Enter brand name" required>
                </div>
                
                <div class="form-group">
                    <label for="product-price">Price</label>
                    <input type="number" id="product-price" placeholder="Enter price" min="0" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="product-quantity">Quantity</label>
                    <input type="number" id="product-quantity" placeholder="Enter quantity" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="product-category">Category</label>
                    <select id="product-category" required>
                        <option value="">Select category</option>
                        <option value="laptops">Laptops</option>
                        <option value="smartphones">Smartphones</option>
                        <option value="keyboards">Keyboards</option>
                        <option value="mice">Mouse</option>
                        <option value="monitors">Monitors</option>
                    </select>
                </div>
                
                <div class="form-group full-width">
                    <label for="product-description">Description</label>
                    <textarea id="product-description" rows="3" placeholder="Enter product description"></textarea>
                </div>
                
                <div class="form-group full-width">
                    <label>Product Image</label>
                    <div class="file-upload" id="file-upload-container">
                        <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                        <div class="file-upload-text">
                            Drag & drop your image here or <span>browse</span><br>
                            Supports: JPG, PNG (Max 5MB)
                        </div>
                        <input type="file" id="product-image" accept="image/*" onchange="handleFileSelect(event)">
                    </div>
                    <div id="file-preview" style="display: none; margin-top: 10px;">
                        <img id="preview-image" src="#" alt="Preview" style="max-width: 100px; max-height: 100px; border-radius: 4px;">
                        <button type="button" onclick="removeImage()" class="ml-2 text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="upload-btn">
                    <i class="fas fa-plus-circle" style="margin-right: 8px;"></i> Add Product
                </button>
            </form>
        </div>
    </div>

    <!-- Inventory Content -->
    <div class="inventory-content" id="inventory-content">
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

    <!-- Employee Content -->
    <div class="employee-content" id="employee-content">
        <div class="employee-header">
            <h2 class="employee-title">Employee Management</h2>
            <p class="employee-subtitle">View and manage your staff members</p>
        </div>
        
        <div class="employee-actions">
            <div class="employee-search">
                <i class="fas fa-search"></i>
                <input type="text" id="employee-search" placeholder="Search employees..." oninput="searchEmployees()">
            </div>
            <button class="add-employee-btn" onclick="showAddEmployeeModal()">
                <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Add Employee
            </button>
        </div>
        
        <div class="employee-table">
            <table>
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="employee-table-body">
                    <!-- Employees will be populated here by JavaScript -->
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
                <form id="edit-product-form">
                    <input type="hidden" id="edit-product-id">
                    <div class="form-group">
                        <label for="edit-product-name">Product Name</label>
                        <input type="text" id="edit-product-name" placeholder="Enter product name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-product-category">Category</label>
                        <select id="edit-product-category" required>
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
                        <input type="number" id="edit-product-price" placeholder="Enter price" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-product-quantity">Quantity</label>
                        <input type="number" id="edit-product-quantity" placeholder="Enter quantity" min="0" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" onclick="closeEditProductModal()">Cancel</button>
                <button class="modal-btn modal-btn-primary" onclick="updateProduct()">Update Product</button>
            </div>
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
                        <label for="modal-employee-name">Full Name</label>
                        <input type="text" id="modal-employee-name" placeholder="Enter full name" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-employee-email">Email</label>
                        <input type="email" id="modal-employee-email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-employee-phone">Phone</label>
                        <input type="tel" id="modal-employee-phone" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-employee-role">Role</label>
                        <select id="modal-employee-role" required>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="staff">Staff</option>
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
                <button class="modal-btn modal-btn-primary" onclick="addEmployeeFromModal()">Add Employee</button>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
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
                        <label for="edit-employee-name">Full Name</label>
                        <input type="text" id="edit-employee-name" placeholder="Enter full name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-employee-email">Email</label>
                        <input type="email" id="edit-employee-email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-employee-phone">Phone</label>
                        <input type="tel" id="edit-employee-phone" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-employee-role">Role</label>
                        <select id="edit-employee-role" required>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="staff">Staff</option>
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

    <!-- Delete Confirmation Modal -->
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
        let currentDeleteId = null;
        let currentDeleteType = null;
        let currentEditId = null;
        let currentEditType = null;
        let selectedFile = null;

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
            
            // Set default view
            switchView('dashboard');
            
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
                    labels: salesData.map(item => item.date.toLocaleDateString('en-US', { weekday: 'short' })),
                    datasets: [{
                        label: 'Sales',
                        data: salesData.map(item => item.sales),
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

            document.getElementById(`${view}-content`).style.display = 'block';

            document.querySelectorAll('.sidebar-icon').forEach(icon => {
                icon.classList.remove('active');
            });

            document.getElementById(`${view}-button`).classList.add('active');
        }

        // Update dashboard stats
        function updateDashboardStats() {
            const totalSales = salesData.reduce((sum, item) => sum + item.sales, 0);
            const todayOrders = salesData[salesData.length - 1].orders;
            const newCustomers = salesData[salesData.length - 1].customers;
            const conversionRate = (Math.random() * 5).toFixed(1);
            
            document.getElementById('total-sales').textContent = `₱${totalSales.toLocaleString()}`;
            document.getElementById('today-orders').textContent = todayOrders;
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
                { icon: 'clock', name: 'Peak Shopping Time', value: '2:00 PM - 5:00 PM' },
                { icon: 'map-marker-alt', name: 'Top Location', value: 'Metro Manila' }
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
            const name = document.getElementById('modal-employee-name').value;
            const email = document.getElementById('modal-employee-email').value;
            const phone = document.getElementById('modal-employee-phone').value;
            const role = document.getElementById('modal-employee-role').value;
            const status = document.getElementById('modal-employee-status').value;
            
            if (!name || !email || !phone || !role || !status) {
                showToast('Please fill all fields', 'error');
                return;
            }
            
            const newEmployee = {
                id: employees.length > 0 ? Math.max(...employees.map(e => e.id)) + 1 : 1,
                name,
                email,
                phone,
                role,
                status,
                avatar: 'https://via.placeholder.com/40'
            };
            
            employees.push(newEmployee);
            renderEmployeeTable();
            
            // Reset form
            document.getElementById('modal-employee-form').reset();
            
            showToast('Employee added successfully');
            closeAddEmployeeModal();
        }

        // Render inventory table
        function renderInventoryTable() {
            const tbody = document.getElementById('inventory-table-body');
            tbody.innerHTML = '';
            
            products.forEach(product => {
                const row = document.createElement('tr');
                
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
                    <td>${product.category.charAt(0).toUpperCase() + product.category.slice(1)}</td>
                    <td>₱${product.price.toFixed(2)}</td>
                    <td>${product.quantity}</td>
                    <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    <td>
                        <button class="action-btn edit-btn" onclick="showEditProductModal(${product.id})"><i class="fas fa-edit"></i></button>
                        <button class="action-btn delete-btn" onclick="showDeleteConfirmModal(${product.id}, 'product')"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        // Render employee table
        function renderEmployeeTable() {
            const tbody = document.getElementById('employee-table-body');
            tbody.innerHTML = '';
            
            employees.forEach(employee => {
                const row = document.createElement('tr');
                
                // Determine role class
                let roleClass;
                if (employee.role === 'admin') {
                    roleClass = 'role-admin';
                } else if (employee.role === 'manager') {
                    roleClass = 'role-manager';
                } else {
                    roleClass = 'role-staff';
                }
                
                row.innerHTML = `
                    <td>
                        <div style="display: flex; align-items: center;">
                            <img src="${employee.avatar}" alt="Employee" class="employee-avatar">
                            <div style="margin-left: 10px;">
                                <div>${employee.name}</div>
                                <div style="font-size: 12px; color: #8892b0;">ID: EMP${employee.id.toString().padStart(3, '0')}</div>
                            </div>
                        </div>
                    </td>
                    <td>${employee.email}</td>
                    <td>${employee.phone}</td>
                    <td><span class="role-badge ${roleClass}">${employee.role.charAt(0).toUpperCase() + employee.role.slice(1)}</span></td>
                    <td>${employee.status.charAt(0).toUpperCase() + employee.status.slice(1)}</td>
                    <td>
                        <button class="action-btn edit-btn" onclick="showEditEmployeeModal(${employee.id})"><i class="fas fa-edit"></i></button>
                        <button class="action-btn delete-btn" onclick="showDeleteConfirmModal(${employee.id}, 'employee')"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        // Search products
        function searchProducts() {
            const searchTerm = document.getElementById('inventory-search').value.toLowerCase();
            const rows = document.getElementById('inventory-table-body').querySelectorAll('tr');
            
            rows.forEach(row => {
                const name = row.querySelector('td:first-child div:first-child').textContent.toLowerCase();
                const brand = row.querySelector('td:first-child div:nth-child(2)').textContent.toLowerCase();
                const category = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                if (name.includes(searchTerm) || brand.includes(searchTerm) || category.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Search employees
        function searchEmployees() {
            const searchTerm = document.getElementById('employee-search').value.toLowerCase();
            const rows = document.getElementById('employee-table-body').querySelectorAll('tr');
            
            rows.forEach(row => {
                const name = row.querySelector('td:first-child div:first-child').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const role = row.querySelector('td:nth-child(4) span').textContent.toLowerCase();
                
                if (name.includes(searchTerm) || email.includes(searchTerm) || role.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Show add product modal
        function showAddProductModal() {
            document.getElementById('add-product-modal').style.display = 'flex';
        }

        // Close add product modal
        function closeAddProductModal() {
            document.getElementById('add-product-modal').style.display = 'none';
        }

        // Show edit product modal
        function showEditProductModal(id) {
            const product = products.find(p => p.id === id);
            if (!product) return;
            
            document.getElementById('edit-product-id').value = product.id;
            document.getElementById('edit-product-name').value = product.name;
            document.getElementById('edit-product-category').value = product.category;
            document.getElementById('edit-product-price').value = product.price;
            document.getElementById('edit-product-quantity').value = product.quantity;
            
            currentEditId = id;
            currentEditType = 'product';
            document.getElementById('edit-product-modal').style.display = 'flex';
        }

        // Close edit product modal
        function closeEditProductModal() {
            document.getElementById('edit-product-modal').style.display = 'none';
        }

        // Update product
        function updateProduct() {
            const id = parseInt(document.getElementById('edit-product-id').value);
            const name = document.getElementById('edit-product-name').value;
            const category = document.getElementById('edit-product-category').value;
            const price = parseFloat(document.getElementById('edit-product-price').value);
            const quantity = parseInt(document.getElementById('edit-product-quantity').value);
            
            const productIndex = products.findIndex(p => p.id === id);
            if (productIndex === -1) return;
            
            products[productIndex] = {
                ...products[productIndex],
                name,
                category,
                price,
                quantity
            };
            
            renderInventoryTable();
            showToast('Product updated successfully');
            closeEditProductModal();
        }

        // Show add employee modal
        function showAddEmployeeModal() {
            document.getElementById('add-employee-modal').style.display = 'flex';
        }

        // Close add employee modal
        function closeAddEmployeeModal() {
            document.getElementById('add-employee-modal').style.display = 'none';
        }

        // Show edit employee modal
        function showEditEmployeeModal(id) {
            const employee = employees.find(e => e.id === id);
            if (!employee) return;
            
            document.getElementById('edit-employee-id').value = employee.id;
            document.getElementById('edit-employee-name').value = employee.name;
            document.getElementById('edit-employee-email').value = employee.email;
            document.getElementById('edit-employee-phone').value = employee.phone;
            document.getElementById('edit-employee-role').value = employee.role;
            document.getElementById('edit-employee-status').value = employee.status;
            
            currentEditId = id;
            currentEditType = 'employee';
            document.getElementById('edit-employee-modal').style.display = 'flex';
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
            const id = parseInt(document.getElementById('edit-employee-id').value);
            const name = document.getElementById('edit-employee-name').value;
            const email = document.getElementById('edit-employee-email').value;
            const phone = document.getElementById('edit-employee-phone').value;
            const role = document.getElementById('edit-employee-role').value;
            const status = document.getElementById('edit-employee-status').value;
            
            const employeeIndex = employees.findIndex(e => e.id === id);
            if (employeeIndex === -1) return;
            
            employees[employeeIndex] = {
                            ...employees[employeeIndex],
                            name,
                            email,
                            phone,
                            role,
                            status
                        };
            
                        renderEmployeeTable();
                        showToast('Employee updated successfully');
                        closeEditEmployeeModal();
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
                        } else if (currentDeleteType === 'employee') {
                            employees = employees.filter(e => e.id !== currentDeleteId);
                            renderEmployeeTable();
                        }
            
                        showToast('Item deleted successfully');
                        closeDeleteConfirmModal();
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