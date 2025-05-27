<?php
include "conn_db.php";

header('Content-Type: application/json');

if (isset($_GET['employee_id'])) {
    try {
        $stmt = $conn->prepare("
            SELECT 
                u.user_id as account_id,
                u.username,
                u.email,
                u.firstname,
                u.lastname,
                r.rank_name as role,
                e.employee_fname,
                e.employee_lname,
                e.employee_email
            FROM employees e
            INNER JOIN users u ON e.employee_id = u.employee_id
            INNER JOIN ranks r ON u.rank_id = r.rank_id
            WHERE e.employee_id = ?
        ");

        if (!$stmt) {
            throw new Exception($conn->error);
        }

        $stmt->bind_param("i", $_GET['employee_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($account = $result->fetch_assoc()) {
            echo json_encode([
                'success' => true,
                'account' => $account
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No account found for this employee'
            ]);
        }

    } catch (Exception $e) {
        error_log("Error in get_account_details.php: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Error fetching account details: ' . $e->getMessage()
        ]);
    }

    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Employee ID not provided'
    ]);
}
?>
