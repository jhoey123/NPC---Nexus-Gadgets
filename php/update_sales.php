<?php
include 'functions.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['quantity'])) {
    $id = intval($data['id']);
    $quantity = intval($data['quantity']);
    addSales($id, $quantity);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
