<?php 
session_start();
if(isset($_POST['submit'])) {
    include "conn_db.php";

    $barcode = $_POST['barcode'];

    $stmt = $conn->prepare('SELECT * FROM products WHERE Barcode_id = ?');
    $stmt->bind_param('s', $barcode);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

}
?>