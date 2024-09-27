<?php
include('../Connection/connection.php');
session_start();
if (isset($_SESSION['logged_in']) && isset($_SESSION['logged_in']) == true) {
    header("location: ../Create_Store/website_buildup.php");
}
require '../loadenv.php';
require '../vendor/autoload.php';
loadEnv(__DIR__ . '/../.env');
ob_start();
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
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // email check
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        echo "Email already exists";
        exit();
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    }
    $_SESSION['user_email_registered'] = $email;
    if ($conn->query($sql) === TRUE) {

        $_SESSION['validate'] = true;

        $validate_code = rand(0000,9999);
        $cookie_expiry = time() + (86400 * 30);
        setcookie('validateCode',$validate_code, $cookie_expiry);
        sendMail($email,'Email Verification Code','The verification code is: '.$validate_code);

        header("Location: validate-code.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
                <h1>Sign Up</h1>
                <p>Already have an account? <a href="login.php" class="text-decoration-underline text-primary">Login</a></p>
            </div>
            <div class="row d-flex align-items-center justify-content-center px-lg-5">
                <div class="col-lg-6 col-12 p-4 border-divider px-lg-5 position-relative">
                    <div class="column-divider position-absolute d-none d-lg-flex"><p>or</p></div>
                    <form method="post">
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control border-0 border-bottom no-outline" id="username" name="username" placeholder="Zohaib Khan" required>
                            <label for="username">Username</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="email" class="form-control border-0 border-bottom no-outline" id="email" name="email" placeholder="name@example.com" required>
                            <label for="email">Email address</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="password" class="form-control border-0 border-bottom no-outline" id="password" name="password" placeholder="@!20iandnjaskdn/^*^" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="password" class="form-control border-0 border-bottom no-outline" id="confirmPassword" name="confirmPassword" placeholder="@!20iandnjaskdn/^*^" required>
                            <label for="confirmPassword">Confirm Password</label>
                            <div class="invalid-feedback">Passwords do not match.</div>
                            <div class="valid-feedback">Passwords match.</div>
                        </div>
                        <button type="submit" class="btn d-none d-lg-block text-primary rounded-pill px-3 fw-bold border border-primary mt-5">Sign Up with Email</button>
                        <div class="container-sm d-lg-none d-flex align-items-center justify-content-center gap-3 mt-5">
                            <button class="btn btn-primary rounded-pill px-3 fw-bold">Sign Up</button>
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

    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');

        confirmPasswordInput.addEventListener('input', function() {
            if (passwordInput.value === confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('');
            } else {
                confirmPasswordInput.setCustomValidity('Passwords do not match.');
            }
        });

        passwordInput.addEventListener('input', function() {
            confirmPasswordInput.setCustomValidity('');
        });

        passwordInput.addEventListener('blur', function() {
            if (passwordInput.value === confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('');
            }
        });

        confirmPasswordInput.addEventListener('blur', function() {
            if (passwordInput.value === confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('');
            }
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>

