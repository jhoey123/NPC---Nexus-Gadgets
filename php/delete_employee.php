<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['employee_id'])) {
    echo json_encode(['success' => false, 'message' => 'Employee ID is required']);
    exit;
}

$employee_id = intval($_POST['employee_id']);

include 'conn_db.php';

$stmt = $conn->prepare("DELETE FROM employees WHERE employee_id = ?");
$stmt->bind_param("i", $employee_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete employee']);
}

$stmt->close();
$conn->close();
