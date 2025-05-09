<?php
session_start();


if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {

    include "conn_db.php";
    $fname = trim($_POST['firstname']);
    $lname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $rank = "3"; // 3 = customer

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password, rank_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $fname, $lname, $username, $email, $hashed_password, $rank);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}



?>