<?php
header('Content-Type: application/json');

include("../../../Connection/connection.php");
session_start();

$storeName = isset($_GET['storeName']) ? $_GET['storeName'] : '';

if ($storeName) {
    // Join query to fetch store and products in one go
    $sql = "SELECT p.id, p.name, p.description, p.category, p.quantity, p.price, p.image, p.created_at, s.id as store_id 
            FROM products p
            JOIN store s ON p.store_id = s.id
            WHERE s.name = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["error" => "Database prepare error: " . $conn->error]);
        exit;
    }
    $stmt->bind_param("s", $storeName);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    $currentDate = new DateTime();
    $newProductThreshold = new DateTime();
    $newProductThreshold->modify('-30 days');   

    while ($row = $result->fetch_assoc()) {
        $createdAt = new DateTime($row['created_at']);
        $isNew = $createdAt > $newProductThreshold ? 'New' : 'Old';
        $row['isNew'] = $isNew;
        $products[] = $row;
    }

    if (empty($products)) {
        $storeId = 0; 
        $stmt->close();
        $sql = "SELECT id, name, description, category, quantity, price, image, created_at 
                FROM products WHERE store_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(["error" => "Database prepare error: " . $conn->error]);
            exit;
        }
        $stmt->bind_param("i", $storeId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $createdAt = new DateTime($row['created_at']);
            $isNew = $createdAt > $newProductThreshold ? 'New' : 'Old';
            $row['isNew'] = $isNew;
            $products[] = $row;
        }
    } else {
        $storeId = $products[0]['store_id']; 
    }

    echo json_encode(["storeId" => $storeId, "products" => $products]);

    $stmt->close();
} else {
    echo json_encode(["error" => "Store name not provided."]);
}

$conn->close();
?>
