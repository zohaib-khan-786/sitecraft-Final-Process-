<?php
include('../Connection/connection.php');

if (isset($_GET['store_id'])) {
    $store_id = $_GET['store_id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE store_id = ?");
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card mb-3 d-flex align-items-center justify-content-center" style="max-width: 200px;">';
            echo '<img src="' . htmlspecialchars($row['image']) . '" class="card-img-top w-75" alt="Product Image">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
            echo '<p class="card-text">Description: ' . htmlspecialchars($row['description']) . '</p>';
            echo '<p class="card-text">Quantity: ' . htmlspecialchars($row['quantity']) . '</p>';
            echo '<p class="card-text">Category: ' . htmlspecialchars($row['category']) . '</p>';
            echo '<p class="card-text">Price: $' . htmlspecialchars($row['price']) . '</p>';
            echo '<button type="button" class="btn btn-primary edit-product" data-product-id="' . $row['id'] . '">Edit</button>';
            echo '<button type="button" class="btn btn-danger delete-product" data-product-id="' . $row['id'] . '">Delete</button>';
            echo '</div></div>';
        }
    } else {
        echo '<p>No products found.</p>';
    }
    $stmt->close();
} elseif (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            echo json_encode(['success' => true, 'product' => $product]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
    }
} else {
    echo '<p>No products found.</p>';
}
?>
