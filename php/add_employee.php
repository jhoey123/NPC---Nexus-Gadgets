<?php
header('Content-Type: application/json');
require_once 'conn_db.php';

if (
    isset($_POST['employee_fname'], $_POST['employee_lname'], $_POST['employee_email'], $_POST['employee_dob'], $_POST['employee_phone'], $_POST['employee_role'], $_POST['employee_status'])
) {
    $fname = trim($_POST['employee_fname']);
    $lname = trim($_POST['employee_lname']);
    $email = trim($_POST['employee_email']);
    $dob = trim($_POST['employee_dob']);
    $phone = trim($_POST['employee_phone']);
    $role = trim($_POST['employee_role']);
    $status = trim($_POST['employee_status']);

    // Check for duplicate email
    $stmt = $conn->prepare("SELECT employee_id FROM employees WHERE employee_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists']);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();

    // Insert new employee
    $stmt = $conn->prepare("INSERT INTO employees (employee_fname, employee_lname, employee_email, employee_dob, phone, role, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $fname, $lname, $email, $dob, $phone, $role, $status);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add employee']);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
}
