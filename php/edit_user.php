<?php
include "conn_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['account_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $rankId = $_POST['rank_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = isset($_POST['password']) && !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    $query = "UPDATE users SET username = ?, email = ?, rank_id = ?, firstname = ?, lastname = ?";
    $params = [$username, $email, $rankId, $firstname, $lastname];

    if ($password) {
        $query .= ", password = ?";
        $params[] = $password;
    }

    $query .= " WHERE user_id = ?";
    $params[] = $userId;

    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update user"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
