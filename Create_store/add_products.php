<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true) {
    header('Location: ../Auth/login.php');
    exit();
}

include("../Connection/connection.php");

if (isset($_GET['store_id']) && !empty($_POST)) {    
    $store_id = $_GET['store_id'];
    $user_id = $_SESSION['user_id']; // Retrieve user_id from session

    // Check if all required POST variables are set
    $required_fields = ['productName', 'productCategory', 'productPrice', 'productCost', 'productDescription', 'productQuantity'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            echo "Error: Missing or empty field $field.";
            exit();
        }
    }

    // Retrieve form data
    $product_name = $_POST['productName'];
    $product_category = $_POST['productCategory'];
    $product_price = $_POST['productPrice'];
    $product_cost = $_POST['productCost']; // Make sure this is set correctly
    $product_description = $_POST['productDescription'];
    $product_quantity = $_POST['productQuantity'];

    // Check if the product already exists
    $stmt = $conn->prepare("SELECT id, image FROM products WHERE store_id = ? AND name = ?");
    $stmt->bind_param("is", $store_id, $product_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product_id = $result->fetch_assoc()['id']; // Get the product ID

        // Prepare update statement
        $update_stmt = $conn->prepare("UPDATE products SET image = ?, category = ?, price = ?, cost = ?, description = ?, quantity = ? WHERE id = ?");
        
        // Handle image upload
        if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['productImage']['tmp_name'];
            $file_name = $_FILES['productImage']['name'];
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $product_image_name = uniqid('product_img_') . '.' . $file_extension;
            $upload_directory = '../Product_images/'; 
            $product_image_path = $upload_directory . $product_image_name;
            $product_image_url = "http://localhost/Aptech_Vision/Product_images/" . $product_image_name;

            if (!move_uploaded_file($file_tmp, $product_image_path)) {
                echo "Failed to move uploaded file.";
                exit();
            }
        } else {
            // Use the existing image if no new image is uploaded
            if (!empty($_POST['existingImage'])) {
                $product_image_url = $_POST['existingImage'];
            } else {
                echo "Error: No image uploaded and existing image is missing.";
                exit();
            }
        }

        // Check if product_cost is set before binding
        if (empty($product_cost)) {
            echo "Error: Product cost is required.";
            exit();
        }

        $update_stmt->bind_param("ssddssi", $product_image_url, $product_category, $product_price, $product_cost, $product_description, $product_quantity, $product_id);
        
        if ($update_stmt->execute()) {
            if (isset($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header('Location: ../Store_Owner_Dashboard/products-section.php');
            }
        } else {
            echo "Error executing update query: " . $update_stmt->error;
        }

        $update_stmt->close();
    } else {
        // Insert new product
        $stmt = $conn->prepare("INSERT INTO products (store_id, name, image, category, price, cost, description, quantity, owner_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
            exit();
        }

        if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['productImage']['tmp_name'];
            $file_name = $_FILES['productImage']['name'];
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $product_image_name = uniqid('product_img_') . '.' . $file_extension;
            $upload_directory = '../Product_images/'; 
            $product_image_path = $upload_directory . $product_image_name;
            $product_image_url = "http://localhost/Aptech_Vision/Product_images/" . $product_image_name;

            if (!move_uploaded_file($file_tmp, $product_image_path)) {
                echo "Failed to move uploaded file.";
                exit();
            }
        } else {
            echo "No file uploaded or upload error occurred.";
            exit();
        }

        $stmt->bind_param("isssddsii", $store_id, $product_name, $product_image_url, $product_category, $product_price, $product_cost, $product_description, $product_quantity, $user_id);

        if ($stmt->execute()) {
            if (isset($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header('Location: ../Store_Owner_Dashboard/products-section.php');
            }
        } else {
            echo "Error executing query: " . $stmt->error;
        }
        
        $stmt->close();
    }
} else {
    echo "Error: Missing store_id or POST data.";
}
?>
