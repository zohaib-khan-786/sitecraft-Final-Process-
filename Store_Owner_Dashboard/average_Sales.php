<?php
include("../Connection/connection.php");


$average_sales_per_day = 0;

$sql = "
    SELECT AVG(daily_sales) AS average_sales_per_day
    FROM (
        SELECT DATE(placed_at) AS order_date, SUM(price) AS daily_sales
        FROM orders
        GROUP BY DATE(placed_at)
    ) AS daily_totals
";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}

$stmt->execute();

$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $average_sales_per_day = $row['average_sales_per_day'];
} else {
    echo "No sales data available.";
}

$stmt->close();

echo number_format($average_sales_per_day, 2);
?>
