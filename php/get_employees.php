<?php 

    include "conn_db.php";

    header('Content-Type: application/json');

    try {
        $stmt = $conn->prepare("SELECT employee_id, employee_fname, employee_lname, phone, employee_dob, role FROM employees");
        $stmt->execute();
        $result = $stmt->get_result();

        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }

        echo json_encode(['success' => true, 'employees' => $employees]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch employees']);
    }

    $stmt->close();
    $conn->close();

?>