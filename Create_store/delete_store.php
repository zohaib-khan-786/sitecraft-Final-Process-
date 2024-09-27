<?php
include("../Connection/connection.php");

$store_id = $_GET['id'];

// Function to delete a directory and its contents
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return false;
    }
    if (!is_dir($dir) || is_link($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDirectory($dir . "/" . $item)) {
            chmod($dir . "/" . $item, 0777);
            if (!deleteDirectory($dir . "/" . $item)) {
                return false;
            }
        }
    }
    return rmdir($dir);
}

// Retrieve the store data to get the template name and logo
$sql = "SELECT template, logo FROM store WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $store_id);
$stmt->execute();
$result = $stmt->get_result();
$store = $result->fetch_assoc();

if ($store) {
    $templateName = $store['template'];
    $storeLogoUrl = $store['logo'];
    $storeDir = "../User_Stores/$templateName";
    
    // Parse the logo URL to get the file path
    $parsedUrl = parse_url($storeLogoUrl);
    $logoPath = $_SERVER['DOCUMENT_ROOT'] . $parsedUrl['path'];

    // Retrieve and delete associated product images
    $sql = "SELECT image FROM products WHERE store_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($product = $result->fetch_assoc()) {
        $productImage = $product['image'];
        $productImagePath = "../Product_images/" . basename($productImage);
        if (file_exists($productImagePath)) {
            unlink($productImagePath);
        }
    }

    // Delete associated products from the database
    $sql = "DELETE FROM products WHERE store_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $store_id);
    $stmt->execute();

    // Delete the store directory and logo
    if (deleteDirectory($storeDir)) {
        if (file_exists($logoPath)) {
            unlink($logoPath);
        }

        // If the directory and logo are deleted, delete the store from the database
        $sql = "DELETE FROM store WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $store_id);
        if ($stmt->execute() === TRUE) {
            header("Location: website_buildup.php");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error deleting directory.";
    }
} else {
    echo "Store not found.";
}

$stmt->close();
$conn->close();
?>
