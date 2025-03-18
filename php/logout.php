<?php
session_start();


if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    session_start(); 
    session_regenerate_id(true);
    header("Location: Index.html");
    exit();
} else {
    header("Location: Index.html?error=Invalid_request");
    exit();
}
?>
