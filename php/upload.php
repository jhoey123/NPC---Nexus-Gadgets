<?php
include "conn_db.php";
include "barcode_generator.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $productBrand = $_POST['product_brand'];
    $productPrice = $_POST['product_price'];
    $productQuantity = $_POST['product_quantity'];
    $productCategory = $_POST['product_category'];
    $productDescription = $_POST['product_description'];

    // Handle file upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['product_image']['tmp_name'];
        $imageName = basename($_FILES['product_image']['name']);
        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        if (in_array(strtolower($imageExtension), $allowedExtensions)) {
            $uploadDir = "../uploads/";
            $newImageName = uniqid() . '.' . $imageExtension;
            $uploadPath = $uploadDir . $newImageName;

            if (move_uploaded_file($imageTmpPath, $uploadPath)) {
                // Insert product data into the database
                $stmt = $conn->prepare("INSERT INTO products (Product_name, Product_brand, Product_price, Product_quantity, Category_id, Product_desc, Product_image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdiiss", $productName, $productBrand, $productPrice, $productQuantity, $productCategory, $productDescription, $newImageName);
                $stmt->execute();
                $productId = $stmt->insert_id;

                // Generate barcode using the new product ID
                $barcode = generateBarcode($productId);

                // Update the product with the generated barcode
                $update = $conn->prepare("UPDATE products SET Barcode_id = ? WHERE Product_id = ?");
                $update->bind_param("si", $barcode, $productId);
                $update->execute();

                $stmt->close();
                $update->close();

                header("Location: ../adminpanel.php?success=1");    
            } else {
                header("Location: ../adminpanel.php?error=" . urlencode("File upload failed"));
            }
        } else {
            header("Location: ../adminpanel.php?error=" . urlencode("Invalid file type"));
        }
    } else {
        header("Location: ../adminpanel.php?error=" . urlencode("No file uploaded"));
    }
} else {
    header("Location: ../adminpanel.php");
    exit();
}
?>