<?php 
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>THIS IS ADMIN</h1>
</body>
</html>