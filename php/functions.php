<?php 


function getItems_sold() {
    include 'conn_db.php';
    
    $sql = "SELECT Items_sold, Product_price FROM products";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $totalItems_sold = 0;

    while ($row = $result->fetch_assoc()) {
        $totalItems_sold += $row['Items_sold'] * $row['Product_price']; // Multiply Items_sold by price
    }

    $stmt->close();
    $conn->close();

    return $totalItems_sold;
}

function getTodaysOrders() {
    include 'conn_db.php';
    $date = date("Y-m-d");
    $nextDate = date("Y-m-d", strtotime($date . ' +1 day'));

    $sql = "SELECT COUNT(1) as count FROM transactions WHERE transaction_date >= ? AND transaction_date < ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $date, $nextDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();
    $conn->close();

    $row = $result->fetch_assoc();
    return $row['count'];
}

function weeklyProfits($profit) {
    include 'conn_db.php';

    $dayOfWeek = date("l"); // Get the current day of the week

    $sql = "UPDATE profits SET Profits = Profits + ? WHERE Day = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ds", $profit, $dayOfWeek);
    $stmt->execute();
    $stmt->close();
    $conn->close();
 }

function getWeeklyProfits() {
    include 'conn_db.php';

    $profits = [];

    $sql = "SELECT * FROM profits";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();

    while ($row = $result->fetch_assoc()) {
        $profits[] = $row['Profits'];  // Cast to float for safety
    }

    return $profits;
}

function addItems_sold($id, $quantity) {
    include 'conn_db.php';

    $sql = "UPDATE products SET Items_sold = Items_sold + ? WHERE Product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}


?>