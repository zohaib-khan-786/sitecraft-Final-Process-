<?php
include("../Connection/connection.php");
session_start();

// Check if user is already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header("location: ../Create_Store/website_buildup.php");
    exit;
}
require '../loadenv.php';
require '../vendor/autoload.php'; // Ensure you include the PHPMailer autoload here
loadEnv(__DIR__ . '/../.env');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($to, $subject, $message) {
    $mail = new PHPMailer(true);
    
    try {
       
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;
        $mail->Username = getenv('MAIL_USERNAME');  
        $mail->Password = getenv('MAIL_PASSWORD');  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('killerzobi893@gmail.com', 'Site Craft');  
        $mail->addAddress($to);  

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;  
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL Injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // User exists but status is inactive
            if ($row['Status_Update'] === 'inactive') {
                
                if (isset($_COOKIE['validateCode'])) {
                    setcookie('validateCode', '', time() - 3600, "/"); 
                }
                $validate_code = rand(1000, 9999);
                // Set cookie for the validation code
                setcookie('validateCode', $validate_code, time() + (86400 * 30), '/'); // Expires in 30 days

                // Send the verification code via email
                sendMail($row['email'], 'Email Verification Code', 'Your verification code is: ' . $validate_code);
                
                // Store user information in session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['username'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_email_registered'] = $row['email'];
                $_SESSION['logged_in'] = true;

                // Redirect to validation page
                header('Location: validate-code.php');
                exit;
            } else {
                // User exists and status is active, log them in
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['username'];
                $_SESSION['user_email'] = $row['email'];   
                
                $_SESSION['user_image'] = $row['image'];
                
                header("location: ../Create_Store/website_buildup.php?user_id=" . $row['id']);
                exit;
            }
        } else {
            echo "Invalid password";
        }
    } else {
        header('location: register.php');
        exit; 
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Styles/styles.css">
    <link rel="stylesheet" href="../Styles/auth.css">
</head>
<body>
<div class="container-fluid d-flex flex-column full-height">
    <nav class="navbar mt-2 navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php"><img src="../Uploads/SiteCraft_Logo.png" alt="SiteCraft"></a>
        </div>
    </nav>
    <div class="w-100 p-lg-5 container mx-auto my-auto">
        <div class="text-center mb-4">
            <h1>Log In</h1>
            <p>Don't have an account? <a href="register.php" class="text-decoration-underline text-primary">Sign Up</a></p>
        </div>
        <div class="row d-flex align-items-center justify-content-center px-lg-5">
            <div class="col-lg-6 col-12 p-4 border-divider px-lg-5 position-relative">
                <div class="column-divider position-absolute d-none d-lg-flex"><p>or</p></div>
                <form method="post">
                    <div class="mb-3 form-floating">
                        <input type="email" class="form-control border-0 border-bottom no-outline" id="email" name="email" placeholder="name@example.com" required>
                        <label for="email">Email address</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="password" class="form-control border-0 border-bottom no-outline" id="password" name="password" placeholder="@!20iandnjaskdn/^*^" required>
                        <label for="password">Password</label>
                    </div>
                    <a href="forgot-password.php" class="text-decoration-underline text-primary" >forgot password?</a>
                    <button type="submit" class="btn d-none d-lg-block text-primary rounded-pill px-3 fw-bold border border-primary mt-4">Log In</button>
                    <div class="container-sm d-lg-none d-flex align-items-center justify-content-center gap-3 mt-5">
                        <button class="btn btn-primary rounded-pill px-3 fw-bold">Log In</button>
                        <span>OR</span>
                        <a href="google-auth.php" class="google-sign-in-button-mobile p-2"></a>
                    </div>
                </form>
            </div>
            <div class="col-lg-6 col-12 p-4 px-lg-5 d-none d-lg-flex align-items-center justify-content-center">
                <a href="google-auth.php" class="google-sign-in-button" >
                    Sign in with Google
                </a>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>