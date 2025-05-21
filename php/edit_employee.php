<?php

include "conn_db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $employee_fname = $_POST['employee_fname'];
    $employee_lname = $_POST['employee_lname'];
    $employee_phone = $_POST['employee_phone'];
    $employee_role = $_POST['employee_role'];
    $employee_status = $_POST['employee_status'];

    try {
        $stmt = $conn->prepare("UPDATE employees SET employee_fname = ?, employee_lname = ?, phone = ?, role = ?, status = ? WHERE employee_id = ?");
        $stmt->bind_param("sssssi", $employee_fname, $employee_lname, $employee_phone, $employee_role, $employee_status, $employee_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Employee updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update employee']);
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
