<?php
header('Content-Type: application/json');
require_once 'conn_db.php';

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (
    !isset($data['order_id'], $data['name'], $data['email'], $data['shipping_address'], $data['phone'], $data['order_date'], $data['items'], $data['order_total'], $data['payment_method'])
) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$order_id = $data['order_id'];
$name = $data['name'];
$email = $data['email'];
$shipping_address = $data['shipping_address'];
$phone = $data['phone'];
$order_date = $data['order_date'];

// Convert items array to plain text (e.g., "Product A x2, Product B x1")
$items_ordered = '';
if (is_array($data['items'])) {
    $itemStrings = [];
    foreach ($data['items'] as $item) {
        $itemName = isset($item['name']) ? $item['name'] : '';
        $itemQty = isset($item['quantity']) ? $item['quantity'] : 1;
        $itemStrings[] = $itemName . ' x' . $itemQty;
    }
    $items_ordered = implode(', ', $itemStrings);
} else {
    $items_ordered = '';
}

$order_total = $data['order_total'];
$payment_method = $data['payment_method'];

$stmt = $conn->prepare("INSERT INTO orders (order_id, name, email, shipping_address, phone, order_date, items_ordered, order_total, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssds", $order_id, $name, $email, $shipping_address, $phone, $order_date, $items_ordered, $order_total, $payment_method);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
}

$stmt->close();
$conn->close();
