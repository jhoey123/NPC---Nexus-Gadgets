<?php
include "conn_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    // Check if the user is connected to an employee
    $stmt = $conn->prepare("SELECT employee_id FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $employeeId = $user['employee_id'];

        if ($employeeId) {
            // Set has_account to 0 for the connected employee
            $updateStmt = $conn->prepare("UPDATE employees SET has_account = 0 WHERE employee_id = ?");
            $updateStmt->bind_param("i", $employeeId);
            if (!$updateStmt->execute()) {
                error_log("Failed to update has_account for employee_id $employeeId: " . $updateStmt->error);
            }
            $updateStmt->close();
        }
    }

    $stmt->close();

    // Delete the user
    $deleteStmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $deleteStmt->bind_param("i", $userId);

    if ($deleteStmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        error_log("Failed to delete user_id $userId: " . $deleteStmt->error);
        echo json_encode(["success" => false, "message" => "Failed to delete user"]);
    }

    $deleteStmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
