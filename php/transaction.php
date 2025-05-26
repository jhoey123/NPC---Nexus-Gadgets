<?php
// filepath: c:\xampp\htdocs\NPC---Nexus-Gadgets\php\save_transaction.php
include 'conn_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaction_id = $_POST['transaction_id'];
    $purchase_list = $_POST['purchase_list'];
    $total_amount = $_POST['total_amount'];
    $payment_method = $_POST['payment_method'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO transactions (transaction_id, purchase_list, total_amount, payment_method) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $transaction_id, $purchase_list, $total_amount, $payment_method);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>