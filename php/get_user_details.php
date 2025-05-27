<?php
include "conn_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Debugging: Log the received user_id
    error_log("Fetching details for user_id: $userId");

    $stmt = $conn->prepare("SELECT user_id, username, email, rank_id, firstname, lastname FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(["success" => true, "user" => $user]);
    } else {
        // Debugging: Log if no user is found
        error_log("No user found for user_id: $userId");
        echo json_encode(["success" => false, "message" => "User not found"]);
    }

    $stmt->close();
    $conn->close();
} else {
    // Debugging: Log invalid requests
    error_log("Invalid request to get_user_details.php");
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
