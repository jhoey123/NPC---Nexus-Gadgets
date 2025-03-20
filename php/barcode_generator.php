<?php

function barcodeGenerator($id): string {
    $country_code = '480';
    $manufacturer_code = str_pad($id, 4, '0', STR_PAD_LEFT);
    $product_code = str_pad($id, 5, '0', STR_PAD_LEFT);
    
    $barcode = $country_code . $manufacturer_code . $product_code;
    
    $odd_sum = 0;
    $even_sum = 0;
    
    for ($i = 0; $i < 12; $i++) {
        if ($i % 2 == 0) {
            $odd_sum += $barcode[$i];
        } else {
            $even_sum += $barcode[$i];
        }
    }
    
    $even_sum *= 3;
    $total_sum = $odd_sum + $even_sum;
    $last_digit = $total_sum % 10;
    $check_digit = (10 - $last_digit) % 10;
    
    $barcode .= $check_digit;
    
    return $barcode;
}

$id = 7;
echo barcodeGenerator($id);
?>