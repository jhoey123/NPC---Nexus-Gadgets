<?php 


function getSales() {
    include 'conn_db.php';
    
    $sql = "SELECT sales FROM products";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $totalSales = 0;
    
    $sales = array();
    while($row = $result->fetch_assoc()) {
        $totalSales += $row['sales'];
    }
    
    return $totalSales;
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
    $todaysProfit = $profit;

    $dayOfWeek = date("l");

    $sql = "UPDATE profits SET profit = ? WHERE day = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ds", $todaysprofit, $dayOfWeek);
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


?>