<?php

include("../../../Connection/connection.php");

header('Content-Type: application/json');

if (isset($_GET['storeName'])) {
    $storeName = $conn->real_escape_string($_GET['storeName']); // Escape the store name for security

    error_log("Store Name: " . $storeName); 

    // Construct the SQL query
    $sql = "SELECT logo FROM store WHERE name = '$storeName'";
    $result = $conn->query($sql);

    if ($result) {
        // Fetch the result
        if ($row = $result->fetch_assoc()) {
            echo json_encode(["logo" => $row['logo']]);
        } else {
            echo json_encode(["error" => "Store not found."]);
        }
        $result->free();
    } else {
        echo json_encode(["error" => "Query failed: " . $conn->error]);
    }
} else {
    echo json_encode(["error" => "Store name not provided."]);
}

$conn->close();
?>
