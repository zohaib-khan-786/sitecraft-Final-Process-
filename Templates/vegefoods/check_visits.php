<?php
include("../../Connection/connection.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['store_id'])) {
    $store_id = $_GET['store_id'];

    // Validate store_id
    if (!filter_var($store_id, FILTER_VALIDATE_INT)) {
        echo json_encode(array('error' => 'Invalid Store ID.'));
        exit();
    }

    $results = [];

    // Count the number of visits
    $file = 'visit_count.txt';
    if (!file_exists($file)) {
        file_put_contents($file, 0);
    }

    if (!isset($_COOKIE['has_visited'])) {
        $count = (int)file_get_contents($file);
        $count++;
        file_put_contents($file, $count);
        setcookie('has_visited', '1', time() + (86400 * 30)); 
    }

    $total_visits = file_get_contents($file);
    $results['total_visits'] = (int)$total_visits;

    // SQL query to calculate total sales, average sales, total orders, and total profit for the specified store
    $sql = "
        SELECT 
            SUM(daily_sales) AS total_sales, 
            AVG(daily_sales) AS average_sales,
            SUM(order_count) AS total_orders,
            SUM(daily_sales) - SUM(total_cost) AS total_profit
        FROM (
            SELECT 
                DATE(placed_at) AS order_date, 
                SUM(price) AS daily_sales,
                SUM(cost) AS total_cost,
                COUNT(*) AS order_count
            FROM orders
            WHERE store_id = ?
            GROUP BY DATE(placed_at)
        ) AS daily_totals
    ";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }
    
    // Bind the store_id parameter
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    // Check if we have any data returned
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $results['total_sales'] = (float)$row['total_sales'];
        $results['average_sales'] = (float)$row['average_sales'];
        $results['total_profit'] = (float)$row['total_profit'];
        $results['total_orders'] = (int)$row['total_orders'];
    } else {
        // If no orders exist for the store, initialize results to 0
        $results['total_sales'] = 0.0;
        $results['average_sales'] = 0.0;
        $results['total_orders'] = 0;
        $results['total_profit'] = 0.0;
    }

    // Free the result and close the statement
    $result->free();
    $stmt->close();

    // Return the results as JSON
    header('Content-Type: application/json');
    echo json_encode($results);
    exit();

} else {
    echo json_encode(array('error' => 'Store ID is not set.'));
    exit();
}
?>
