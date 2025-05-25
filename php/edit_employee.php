<?php
include "conn_db.php";
header('Content-Type: application/json');

if (isset($_POST['employee_id'])) {
    try {
        $employee_id = intval($_POST['employee_id']);
        $fname = $conn->real_escape_string($_POST['employee_fname']);
        $lname = $conn->real_escape_string($_POST['employee_lname']);
        $email = $conn->real_escape_string($_POST['employee_email']);
        $dob = $conn->real_escape_string($_POST['employee_dob']);
        $phone = $conn->real_escape_string($_POST['employee_phone']);
        $role = $conn->real_escape_string($_POST['employee_role']);
        $status = $conn->real_escape_string($_POST['employee_status']);

        $sql = "UPDATE employees SET 
            employee_fname = ?, 
            employee_lname = ?, 
            employee_email = ?,
            employee_dob = ?, 
            phone = ?, 
            role = ?, 
            status = ? 
            WHERE employee_id = ?";
            
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $fname, $lname, $email, $dob, $phone, $role, $status, $employee_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Employee updated successfully']);
        } else {
            throw new Exception($stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing employee ID']);
}

$conn->close();
