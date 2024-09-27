<?php
session_start();
include './connection.php';

// Retrieve the template name from the request, fallback to a default value if not provided
$template = isset($_GET['template']) ? $_GET['template'] : 'freshshop';
$sessionId = session_id();

// Prepare the query to fetch cart items based on session and template
$query = "SELECT * FROM cart WHERE session_id = ? and template_name = ?";
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