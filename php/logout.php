<?php
session_start();

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    session_start(); 
    session_regenerate_id(true);
    header("Location: ../index.php");
    exit();
} else {
    header("Location: ../index.php?error=Invalid_request");
    exit();
}
?>
