<?php
include "conn_db.php";
header('Content-Type: application/json');

$limit = 5;

$query = "
    SELECT Product_name, (Product_price * Items_sold) AS TotalSales
    FROM products
    ORDER BY TotalSales DESC
    LIMIT ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $limit);

$stmt->execute();
$result = $stmt->get_result();

$topProducts = [];
while ($row = $result->fetch_assoc()) {
    $row['TotalSales'] = (float)$row['TotalSales']; // Ensure TotalSales is a float
    $topProducts[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($topProducts);
?>
