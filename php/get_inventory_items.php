<?php
include "conn_db.php";

$category = isset($_GET['category']) ? $_GET['category'] : 'All';

$query = "SELECT p.*, c.Category_name 
          FROM products p 
          LEFT JOIN categories c ON p.Category_id = c.Category_id";

if ($category !== 'All') {
    $query .= " WHERE c.Category_name = ?";
}

$stmt = $conn->prepare($query);

if ($category !== 'All') {
    $stmt->bind_param("s", $category);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="item-card" onclick="showInventoryModal(' . htmlspecialchars(json_encode($row)) . ')">';
        echo '<img src="' . $row['Product_image_path'] . '" alt="' . $row['Product_name'] . '" class="item-image">';
        echo '<div class="item-details">';
        echo '<h3>' . $row['Product_name'] . '</h3>';
        echo '<p><b>Price:</b> ₱' . number_format($row['Product_price'], 2) . '</p>';
        echo '<p><b>Quantity:</b> <span id="quantity-' . $row['Product_id'] . '">' . $row['Product_quantity'] . '</span></p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p class="no-products-message">No products available in this category.</p>';
}

$stmt->close();
$conn->close();
?>
