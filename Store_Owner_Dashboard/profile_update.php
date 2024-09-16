<?php
include("../Connection/connection.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true) {
    header('Location: ../Auth/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize an array to hold update queries and parameter types
    $updateFields = [];
    $params = []; // For binding parameters
    $types = '';  // Parameter types string

    // Check if the file was uploaded
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
        $fileTmpPath = $_FILES['profileImage']['tmp_name'];
        $fileName = $_FILES['profileImage']['name'];
        $uploadFileDir = '../Uploads/';
        $dest_path = $uploadFileDir . basename($fileName);

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $updateFields[] = "image = ?";
            $params[] = $dest_path;
            $types .= 's'; // 's' for string type
        } else {
            echo "There was an error moving the uploaded file.";
        }
    }

    // Collect other fields from the POST request
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Only update if provided

    // Update the SQL fields based on what is provided
    $updateFields[] = "username = ?";
    $params[] = $username;
    $types .= 's'; // 's' for string type

    $updateFields[] = "email = ?";
    $params[] = $email;
    $types .= 's'; // 's' for string type

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $updateFields[] = "password = ?";
        $params[] = $hashedPassword;
        $types .= 's'; // 's' for string type
    }

    // Prepare the SQL statement
    $sql = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = ?";
    $params[] = $user_id; // Add user_id for the WHERE clause
    $types .= 'i'; // 'i' for integer type

    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param($types, ...$params); // Spread operator to pass parameters

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['user_image'] = $dest_path ?? $_SESSION['user_image']; // Update session variable if the image is uploaded
        if (isset($_SERVER['HTTP_REFERER'])) {

            $referer = $_SERVER['HTTP_REFERER'];
        

            if (strpos($referer, '?') !== false) {
                $redirectUrl = $referer . '&success=true';
            } else {
                $redirectUrl = $referer . '?success=true';
            }
        
            header("Location: $redirectUrl");
            exit();
        } else {
            header('Location: account_setting.php?success=true');
            exit();
        }
        exit();
    } else {
        echo "Error updating profile information.";
    }
} else {
    header('Location: index.php'); 
    exit();
}
?>
