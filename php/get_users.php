<?php
include "conn_db.php";

header('Content-Type: application/json');

try {
    $sql = "SELECT u.user_id, u.firstname, u.lastname, u.username, u.email, 
            r.rank_name as role
            FROM users u
            LEFT JOIN ranks r ON u.rank_id = r.rank_id 
            ORDER BY u.user_id ASC";
            
    $result = $conn->query($sql);

    if ($result) {
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = array(
                'user_id' => $row['user_id'],
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'username' => $row['username'],
                'email' => $row['email'],
                'role' => $row['role']
            );
        }
        echo json_encode(array('success' => true, 'users' => $users));
    } else {
        throw new Exception("Error fetching users");
    }
} catch (Exception $e) {
    echo json_encode(array('success' => false, 'message' => $e->getMessage()));
}

$conn->close();
?>
