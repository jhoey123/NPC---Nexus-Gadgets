<?php
include 'functions.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['profit'])) {
    $profit = floatval($data['profit']);
    weeklyProfits($profit);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
