<?php 
session_start();
include "barcode_generator.php";

if (isset($_POST['submit'])) {
    if (isset($_FILES['filetoUpload']) && $_FILES['filetoUpload']['error'] == 0) {

        include "conn_db.php";
        
        $image_name = $_FILES['filetoUpload']['name'];
        $image_tmp_name = $_FILES['filetoUpload']['tmp_name'];
        $image_type = $_FILES['filetoUpload']['type'];
        $image_size = $_FILES['filetoUpload']['size'];
        $product_name = htmlspecialchars($_POST['Product_Name']);
        $product_brand = htmlspecialchars($_POST['Product_Brand']);
        $product_desc = htmlspecialchars($_POST['Product_Desc']);
        $product_price = htmlspecialchars($_POST['Product_Price']);
        $product_quantity = htmlspecialchars($_POST['Product_Quantity']);
        $product_category = htmlspecialchars($_POST['Category_id']);

        
        if ($image_size > 5 * 1024 * 1024) {
            header("Location: ../adminpanel.php?section=upload&error=file_too_large");
            exit();
        }


        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (!in_array($image_type, $allowed_types)) {
            header("Location: ../adminpanel.php?section=upload&error=invalid_file_type");
            exit();
        }


        $upload_dir = '../uploads/';
        $new_image_name = uniqid() . '-' . basename($image_name);
        $upload_path = $upload_dir . $new_image_name;
        $db_image_path = 'uploads/' . $new_image_name;


        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }


        $stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE product_name = ?");
        $stmt->bind_param("s", $product_name);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            header("Location: ../adminpanel.php?section=upload&error=product_exists");
            exit();
        }

        if (move_uploaded_file($image_tmp_name, $upload_path)) {
            $stmt = $conn->prepare("INSERT INTO products (Product_name, Product_brand, Product_desc, Product_quantity, Product_price, Category_id, Product_image_name, Product_image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssidiss", $product_name, $product_brand, $product_desc, $product_quantity, $product_price, $product_category, $new_image_name, $db_image_path);
            if($stmt->execute()) {
                $product_id = $conn->insert_id;
                $stmt->close();


                $barcode = barcodeGenerator($product_id);


                $update_stmt = $conn->prepare("UPDATE products SET Barcode_id = ? WHERE Product_id = ?");
                $update_stmt->bind_param("ii", $barcode, $product_id);
                $update_stmt->execute();
                $update_stmt->close();

                header("Location: ../adminpanel.php?section=upload&success=upload_successful");
                exit();
            }
        } else {
            header("Location: ../adminpanel.php?section=upload&error=upload_failed");
            exit();
        }
    } else {
        header("Location: ../adminpanel.php?section=upload&error=no_file_uploaded");
        exit();
    }
}
$conn->close();
?>