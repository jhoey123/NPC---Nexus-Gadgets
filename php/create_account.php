<?php
include "conn_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $employee_id = $_POST['employee_id'];
    $rank_id = $_POST['rank_id'];

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

        // Create user account
        $stmt = $conn->prepare("INSERT INTO users (user_id, username, password, rank_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $employee_id, $username, $password, $rank_id);
        $stmt->execute();

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    $conn->close();
}
?>
