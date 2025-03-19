<?php 
session_start();

if (isset($_POST['submit'])) {
    if (isset($_FILES['filetoUpload']) && $_FILES['filetoUpload']['error'] == 0) {

        include "db_con.php";
        
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
            header("Location: ../product_upload.php?error=file_too_large");
            exit();
        }


        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (!in_array($image_type, $allowed_types)) {
            header("Location: ../product_upload.php?error=invalid_file_type");
            exit();
        }


        $upload_dir = '../uploads/';
        $new_image_name = uniqid() . '-' . basename($image_name);
        $upload_path = $upload_dir . $new_image_name;


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
            header("Location: ../product_upload.php?error=product_exists");
            exit();
        }

        if (move_uploaded_file($image_tmp_name, $upload_path)) {
            $stmt = $conn->prepare("INSERT INTO products (Product_name, Product_brand, Product_desc, Product_quantity, Product_price, Category_id, Product_image_name, Product_image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssidiss", $product_name, $product_brand, $product_desc, $product_quantity, $product_price, $product_category, $new_image_name, $upload_path);
            $stmt->execute();
            $stmt->close();

            header("Location: ../product_upload.php?success=upload_successful");
            exit();
        } else {
            header("Location: ../product_upload.php?error=upload_failed");
            exit();
        }
    } else {
        header("Location: ../product_upload.php?error=no_file_uploaded");
        exit();
    }
}
$conn->close();
?>