<?php
header('Content-Type: application/json');
if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'No product ID specified']);
    exit;
}
$id = intval($_GET['id']);
require_once 'conn_db.php';

$stmt = $conn->prepare("SELECT 
    Product_id, Product_name, Product_brand, Product_desc, Product_quantity, Product_price, Category_id, Barcode_id, Product_image_path
    FROM products WHERE Product_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    // Optionally get category name if you have a categories table
    $categoryName = null;
    if (!empty($row['Category_id'])) {
        $catStmt = $conn->prepare("SELECT category_name FROM categories WHERE category_id = ?");
        $catStmt->bind_param("i", $row['Category_id']);
        $catStmt->execute();
        $catRes = $catStmt->get_result();
        if ($catRow = $catRes->fetch_assoc()) {
            $categoryName = $catRow['category_name'];
        }
        $catStmt->close();
    }
    // Determine status
    if ($row['Product_quantity'] > 10) {
        $status = 'In Stock';
    } else if ($row['Product_quantity'] > 0) {
        $status = 'Low Stock';
    } else {
        $status = 'Out of Stock';
    }
    $row['status'] = $status;
    $row['Category_name'] = $categoryName;
    echo json_encode(['success' => true, 'product' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
}
$stmt->close();
$conn->close();
