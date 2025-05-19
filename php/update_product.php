<?php
include "conn_db.php";
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_desc = isset($_POST['product_desc']) ? $_POST['product_desc'] : ''; // Default to an empty string if not provided
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];


    // Start transaction
    $conn->begin_transaction();

    try {
        // Update basic product information
        $stmt = $conn->prepare("UPDATE products SET 
            Product_name = ?, 
            Product_desc     = ?, 
            Product_price = ?, 
            Product_quantity = ? 
            WHERE Product_id = ?");
        
        $stmt->bind_param("ssdii", 
            $product_name, 
            $product_desc, 
            $product_price, 
            $product_quantity, 
            $product_id
        );
        
        $stmt->execute();

        // Handle image upload if provided
        if (isset($_FILES['product_image']) && $_FILES['product_image']['size'] > 0) {
            $file = $_FILES['product_image'];
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            // Validate file extension
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            if (!in_array($file_ext, $allowed)) {
                throw new Exception("Invalid file type. Only JPG, PNG and GIF files are allowed.");
            }

            // Generate new filename
            $new_filename = uniqid() . '.' . $file_ext;
            $upload_path = '../uploads/' . $new_filename;
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Update image path and name in database
                $image_path = 'uploads/' . $new_filename;
                $stmt = $conn->prepare("UPDATE products SET Product_image_path = ?, Product_image_name = ? WHERE Product_id = ?");
                $stmt->bind_param("ssi", $image_path, $file_name, $product_id);
                $stmt->execute();
            } else {
                throw new Exception("Failed to upload image.");
            }
        }

        $conn->commit();
        $response['success'] = true;
        $response['message'] = 'Product updated successfully';
    } catch (Exception $e) {
        $conn->rollback();
        $response['message'] = $e->getMessage();
    }
}

$conn->close();

// Redirect back to adminpanel.php
header("Location: ../adminpanel.php");
exit();
