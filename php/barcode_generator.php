<?php

// Usage: include this file and call generateBarcode($productId) to get a unique barcode.

function generateBarcode($productId = null) {
    // You can use product ID, current time, and a random number for uniqueness
    $prefix = 'NG'; // Nexus Gadgets
    $date = date('YmdHis');
    $rand = mt_rand(1000, 9999);
    if ($productId) {
        return $prefix . '-' . $date . '-' . $productId . '-' . $rand;
    } else {
        return $prefix . '-' . $date . '-' . $rand;
    }
}

?>