<?php
session_start();
include '../../Connection/connection.php';

// Set the template name to 'giftos'
$template = 'pullshoes';
$sessionId = session_id();

// Prepare the query to fetch cart items for the specific session and template
$query = "select * FROM cart WHERE session_id = ? and template_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $sessionId, $template); // Bind both session_id and template name
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
$totalAmount = 0;

// Calculate total cart items and amount
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
    $totalAmount += $row['product_price'] * $row['quantity'];
}

// Format the total amount and create a response array
$response = [
    'cartItems' => $cartItems,
    'totalAmount' => number_format($totalAmount, 2)
];

// Output the response as JSON
echo json_encode($response);
?>