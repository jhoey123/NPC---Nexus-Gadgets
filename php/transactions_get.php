<?php
header('Content-Type: application/json');
require_once 'conn_db.php';

// Adjust the table name and column names as needed to match your DB schema
$sql = "SELECT 
    cashier_name, 
    transaction_id, 
    purchase_list, 
    subtotal_amount, 
    cash_amount, 
    change_amount, 
    total_amount, 
    payment_method, 
    transaction_date 
FROM transactions 
ORDER BY transaction_date DESC";

$result = $conn->query($sql);

$transactions = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
}

echo json_encode($transactions);
$conn->close();
