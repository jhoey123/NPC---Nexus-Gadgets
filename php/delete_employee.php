<?php
include "conn_db.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'] ?? null;
    if (!$employee_id) {
        echo json_encode(['success' => false, 'message' => 'No employee ID provided']);
        exit;
    }

    try {
        $stmt = $conn->prepare("DELETE FROM employees WHERE employee_id = ?");
        $stmt->bind_param("i", $employee_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Employee deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete employee']);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
