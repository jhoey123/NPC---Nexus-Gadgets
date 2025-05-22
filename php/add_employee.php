<?php
include "conn_db.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['employee_fname'] ?? '';
    $lname = $_POST['employee_lname'] ?? '';
    $dob = $_POST['employee_dob'] ?? '';
    $phone = $_POST['employee_phone'] ?? '';
    $role = $_POST['employee_role'] ?? '';
    $status = $_POST['employee_status'] ?? '';

    if (!$fname || !$lname || !$dob || !$phone || !$role || !$status) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO employees (employee_fname, employee_lname, employee_dob, phone, role, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fname, $lname, $dob, $phone, $role, $status);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Employee added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add employee']);
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
