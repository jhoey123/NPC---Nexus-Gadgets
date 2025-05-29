<?php
header('Content-Type: application/json');
include 'conn_db.php';

// Adjust table/column names as needed for your schema
$sql = "SELECT 
            id, 
            order_id, 
            name, 
            email, 
            shipping_address, 
            phone, 
            order_date, 
            items_ordered, 
            order_total, 
            payment_method 
        FROM orders
        ORDER BY order_date DESC";

$result = $conn->query($sql);

$orders = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = [
            'id' => $row['id'],
            'order_id' => $row['order_id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'shipping_address' => $row['shipping_address'],
            'phone' => $row['phone'],
            'order_date' => $row['order_date'],
            'items_ordered' => $row['items_ordered'],
            'order_total' => $row['order_total'],
            'payment_method' => $row['payment_method']
        ];
    }
}

echo json_encode([
    'success' => true,
    'orders' => $orders
]);
$conn->close();
