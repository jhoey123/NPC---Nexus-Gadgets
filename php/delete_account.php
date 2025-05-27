<?php
include "conn_db.php";
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_id = isset($_POST['account_id']) ? intval($_POST['account_id']) : 0;
    $employee_id = isset($_POST['employee_id']) ? intval($_POST['employee_id']) : 0;

    $conn->begin_transaction();
    try {
        // Delete the user account
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $account_id);
        $stmt->execute();

        // Set has_account to 0 for the employee
        $update_stmt = $conn->prepare("UPDATE employees SET has_account = 0 WHERE employee_id = ?");
        $update_stmt->bind_param("i", $employee_id);
        $update_stmt->execute();

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    if (isset($stmt)) $stmt->close();
    if (isset($update_stmt)) $update_stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
