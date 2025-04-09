<?php
include "conn_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $quantitySold = intval($_POST['quantity_sold']);

    $stmt = $conn->prepare("UPDATE products SET Product_quantity = Product_quantity - ? WHERE Product_name = ?");
    $stmt->bind_param("is", $quantitySold, $productName);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update inventory.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
