<?php
// place_order.php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'sitecraft');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
    exit;
}



$data = json_decode(file_get_contents('php://input'), true);


if (!isset($data['products'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid order data.']);
    exit;
}


$products = $data['products'];



foreach ($products as $product) {
    $stmt = $conn->prepare("INSERT INTO orders (name, image, price, cost, store_id, quantity) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddii", $product['name'], $product['image'], $product['price'], $product['cost'], $product['storeId'], $product['quantity']);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true]);
?>
