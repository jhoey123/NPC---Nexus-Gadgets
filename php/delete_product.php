<?php
include "conn_db.php";

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    if (empty($product_id)) {
        $response['message'] = 'Product ID is required.';
    } else {
        $stmt = $conn->prepare("DELETE FROM products WHERE Product_id = ?");
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Product deleted successfully.';
        } else {
            $response['message'] = 'Failed to delete product.';
        }

        $stmt->close();
    }
}

$conn->close();
echo json_encode($response);
