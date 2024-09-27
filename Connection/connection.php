<?php

$conn = new mysqli('localhost','root','','sitecraft');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}


?>