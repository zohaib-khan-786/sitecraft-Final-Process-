<?php

$conn = new mysqli('localhost','root','','sitecraft1');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}


?>