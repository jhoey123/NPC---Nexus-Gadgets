<?php
include "conn_db.php";

$category = isset($_GET['inventory_category']) ? $_GET['inventory_category'] : 'All';

$query = "SELECT p.*, c.Category_name 
          FROM products p 
          LEFT JOIN categories c ON p.Category_id = c.Category_id";

if ($category !== 'All') {
    // Use the categories table to match category names
    $query .= " WHERE c.Category_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $category);
} else {
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
        echo '<div class="item-card" onclick="showInventoryModal(' . $rowJson . ')">';
        echo '<img src="' . htmlspecialchars($row['Product_image_path'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($row['Product_name'], ENT_QUOTES, 'UTF-8') . '" class="item-image">';
        echo '<div class="item-details">';
        echo '<h3>' . htmlspecialchars($row['Product_name'], ENT_QUOTES, 'UTF-8') . '</h3>';
        echo '<p><b>Price:</b> ₱' . number_format($row['Product_price'], 2) . '</p>';
        echo '<p><b>Quantity:</b> <span id="quantity-' . htmlspecialchars($row['Product_id'], ENT_QUOTES, 'UTF-8') . '">' . $row['Product_quantity'] . '</span></p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p class="no-products-message">No products available in this category.</p>';
}

$stmt->close();
$conn->close();
?>
