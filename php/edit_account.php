<?php
include "conn_db.php";

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_id = $_POST['account_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $rank_id = $_POST['rank_id'];
    $password = isset($_POST['password']) && $_POST['password'] !== '' ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    try {
        // Check if username already exists for other accounts
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? AND user_id != ?");
        $stmt->bind_param("si", $username, $account_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            throw new Exception("Username already exists");
        }

        if ($password) {
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, rank_id = ?, password = ? WHERE user_id = ?");
            $stmt->bind_param("ssisi", $username, $email, $rank_id, $password, $account_id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, rank_id = ? WHERE user_id = ?");
            $stmt->bind_param("ssii", $username, $email, $rank_id, $account_id);
        }
        $stmt->execute();

        if ($stmt->affected_rows > 0 || $stmt->errno === 0) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("No changes made or account not found");
        }

    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }

    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>
