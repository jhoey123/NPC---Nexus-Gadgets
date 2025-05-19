<?php
include "conn_db.php";
header('Content-Type: application/json');

$category = isset($_GET['inventory_category']) ? $_GET['inventory_category'] : 'All';

$query = "SELECT 
    p.Product_id AS id,
    p.Product_name AS name,
    p.Product_brand AS brand,
    p.Product_desc AS description,
    p.Product_quantity AS quantity,
    p.Product_price AS price,
    c.Category_name AS category,
    p.Product_image_path AS image
    FROM products p
    LEFT JOIN categories c ON p.Category_id = c.Category_id";

if ($category !== 'All') {
    $query .= " WHERE c.Category_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $category);
} else {
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
echo json_encode($items);

$stmt->close();
$conn->close();
?>
