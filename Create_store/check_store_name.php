<?php
include('../Connection/connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $storeName = $_POST['storeName'];

    $stmt = $conn->prepare("SELECT COUNT(*) FROM store WHERE name = ?");
    $stmt->bind_param("s", $storeName);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    echo json_encode($count > 0);
}

$conn->close();
?>
