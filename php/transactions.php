<?php
include 'conn_db.php';

$data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['purchaseList'], $data['subtotalAmount'], $data['totalAmount'], $data['paymentMethod'], $data['cashAmount'], $data['changeAmount'], $data['cashierName'])) {
    // Generate a 9-character alphanumeric transaction ID
    $transactionId = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 9);
    $purchaseList = $data['purchaseList'];
    $subtotalAmount = number_format($data['subtotalAmount'], 2, '.', '');
    $totalAmount = number_format($data['totalAmount'], 2, '.', '');
    $paymentMethod = $data['paymentMethod'];
    $cashAmount = number_format($data['cashAmount'], 2, '.', '');
    $changeAmount = number_format($data['changeAmount'], 2, '.', '');
    $cashierName = $data['cashierName'];
    $transactionDate = date("Y-m-d H:i:s");

    $sql = "INSERT INTO transactions (transaction_id, purchase_list, subtotal_amount, cash_amount, change_amount, total_amount, payment_method, cashier_name, transaction_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdddssss", $transactionId, $purchaseList, $subtotalAmount, $cashAmount, $changeAmount, $totalAmount, $paymentMethod, $cashierName, $transactionDate);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'transactionId' => $transactionId]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

$conn->close();
?>
