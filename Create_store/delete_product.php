<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true) {
    header('Location: ../Auth/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
require '../Connection/connection.php';

if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    $sql = "SELECT p.id 
            FROM products p 
            JOIN store s ON p.store_id = s.id 
            WHERE p.id = ? AND s.created_by = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $product_id, $user_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $delete_sql = "DELETE FROM products WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $product_id);

            if ($delete_stmt->execute()) {
                // Redirect to the previous URL if the product is successfully deleted
                if (isset($_SERVER['HTTP_REFERER'])) {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    header('Location: products-section.php');
                }
            } else {
                echo "Error deleting product: " . $delete_stmt->error;
            }
            $delete_stmt->close();
        } else {
            if (isset($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header('Location: products-section.php');
            }
        }
        $stmt->close();
    } else {
        echo "Error validating product ownership: " . $stmt->error;
    }
} else {
    echo "No product specified for deletion.";
}
?>
