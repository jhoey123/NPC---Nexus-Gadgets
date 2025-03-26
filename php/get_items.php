<?php
include "conn_db.php";

$category = isset($_GET['category']) ? $_GET['category'] : 'Keyboards';

if ($category === 'All') {
    $sql = "SELECT c.Category_name, c.Category_desc, p.Product_name, p.Product_brand, p.Product_price, p.Product_image_path, p.Product_quantity 
            FROM categories c 
            LEFT JOIN products p ON c.Category_id = p.Category_id 
            WHERE p.Product_name IS NOT NULL";
    $stmt = $conn->prepare($sql);
} else {
    $sql = "SELECT c.Category_name, c.Category_desc, p.Product_name, p.Product_brand, p.Product_price, p.Product_image_path, p.Product_quantity 
            FROM categories c 
            LEFT JOIN products p ON c.Category_id = p.Category_id 
            WHERE c.Category_name = ? AND p.Product_name IS NOT NULL";      
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "
        <div class='item-card hidden' data-name='{$row['Product_name']}'>
            <img src='{$row['Product_image_path']}' alt='{$row['Product_name']}' class='item-image'>
            <div class='item-details'>
                <div class='item-name'>{$row['Product_name']}</div>
                <div class='item-price'>₱" . number_format($row['Product_price'], 2) . "</div>
                <button class='add-btn' onclick=\"addToCart('{$row['Product_name']}', {$row['Product_price']}, '{$row['Product_image_path']}', {$row['Product_quantity']})\">ADD</button>
            </div>
        </div>";
    }
} else {
    echo "<p>No products available.</p>";
}

$stmt->close();
$conn->close();
?>

