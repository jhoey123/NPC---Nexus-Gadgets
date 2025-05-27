<?php
include "conn_db.php";

// Debug log
error_log("POST data received: " . print_r($_POST, true));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $employee_id = isset($_POST['employee_id']) ? intval($_POST['employee_id']) : 0;
    $rank_id = $_POST['rank_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    // Debug log
    error_log("Processed data - employee_id: $employee_id, rank_id: $rank_id");

    // Start transaction
    $conn->begin_transaction();

    try {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            throw new Exception("Username already exists");
        }

        // Check if employee_id exists in the employees table
        $stmt = $conn->prepare("SELECT employee_id FROM employees WHERE employee_id = ?");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Invalid employee ID");
        }

        // Create user account and link it to the employee using employee_id foreign key
        $stmt = $conn->prepare("INSERT INTO users (username, password, rank_id, firstname, lastname, email, employee_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssi", $username, $password, $rank_id, $first_name, $last_name, $email, $employee_id);
        $stmt->execute();

        // Update has_account field in employees table
        $update_stmt = $conn->prepare("UPDATE employees SET has_account = 1 WHERE employee_id = ?");
        $update_stmt->bind_param("i", $employee_id);
        $update_stmt->execute();

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    $stmt->close();
    $conn->close();
}
?>
