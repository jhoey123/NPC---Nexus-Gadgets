<?php
include "conn_db.php";

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM employees");
$employees = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
    echo json_encode([
        "success" => true,
        "employees" => $employees
    ]);
} else {
    echo json_encode([
        "success" => false,
        "employees" => []
    ]);
}
$conn->close();
