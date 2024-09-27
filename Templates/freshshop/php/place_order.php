<?php
// place_order.php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'sitecraft');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
    exit;
}

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Ensure data is valid
if (!is_array($data) || empty($data)) {
    echo json_encode(['success' => false, 'error' => 'Invalid order data.']);
    exit;
}

foreach ($data as $product) {
    // Ensure necessary fields are present
    if (!isset($product['name'], $product['image'], $product['price'], $product['storeId'], $product['quantity'])) {
        echo json_encode(['success' => false, 'error' => 'Missing product data.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO orders (name, image, price, store_id, quantity) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssdii", $product['name'], $product['image'], $product['price'], $product['storeId'], $product['quantity']);
        $stmt->execute();
    } else {
        echo json_encode(['success' => false, 'error' => 'Database error during insert.']);
        exit;
    }
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true]);
?>
