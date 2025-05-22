<?php 
session_start();
header('Content-Type: application/json');

try {
    if(isset($_POST['barcode'])) {
        include "conn_db.php";

        if(!$conn) {
            throw new Exception("Database connection failed");
        }

        $barcode = $_POST['barcode'];
        
        error_log("Received barcode: " . $barcode);

        $stmt = $conn->prepare('SELECT p.Product_Name, p.Product_Price, p.Product_Quantity, p.Product_image_path FROM products p WHERE p.Barcode_id = ?');
        if(!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param('s', $barcode);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row) {
            error_log("Product found: " . json_encode($row));
            // Return with keys expected by JS
            echo json_encode([
                'name' => $row['Product_Name'],
                'price' => $row['Product_Price'],
                'quantity' => $row['Product_Quantity'],
                'image' => $row['Product_image_path']
            ]);
        } else {
            error_log("No product found for barcode: " . $barcode);
            echo json_encode(null);
        }
        
        $stmt->close();
    } else {
        error_log("Barcode parameter not set");
        echo json_encode(null);
    }
} catch(Exception $e) {
    error_log("Error in barcode_scan.php: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
}
?>
