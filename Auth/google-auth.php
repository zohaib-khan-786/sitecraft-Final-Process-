<?php
include("../Connection/connection.php");
session_start();

require '../loadenv.php';
require '../vendor/autoload.php'; // Ensure you include the PHPMailer autoload here
loadEnv(__DIR__ . '/../.env');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$google_oauth_client_id = getenv('GOOGLE_OAUTH_CLIENT_ID');
$google_oauth_client_secret = getenv('GOOGLE_OAUTH_CLIENT_SECRET');
$google_oauth_redirect_uri = getenv('GOOGLE_OAUTH_REDIRECT_URI');
$google_oauth_version = getenv('GOOGLE_OAUTH_VERSION');



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

if (isset($_GET['code']) && !empty($_GET['code'])) {
    $params = [
        'code' => $_GET['code'],
        'client_id' => $google_oauth_client_id,
        'client_secret' => $google_oauth_client_secret,
        'redirect_uri' => $google_oauth_redirect_uri,
        'grant_type' => 'authorization_code'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $response = json_decode($response, true);
    if (isset($response['access_token']) && !empty($response['access_token'])) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/' . $google_oauth_version . '/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $profile = json_decode($response, true);
        
        if (isset($profile['email'])) {
            $google_name_parts = [];
            $google_name_parts[] = isset($profile['given_name']) ? preg_replace('/[^a-zA-Z0-9]/s', '', $profile['given_name']) : '';
            $google_name_parts[] = isset($profile['family_name']) ? preg_replace('/[^a-zA-Z0-9]/s', '', $profile['family_name']) : '';
            session_regenerate_id();
            $_SESSION['google_name'] = implode(' ', $google_name_parts);
            $_SESSION['google_picture'] = isset($profile['picture']) ? $profile['picture'] : '';

            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }
            
            $stmt->bind_param("s", $profile['email']);
            if($stmt->execute()){
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                
                // If the user exists
                if($user){
                    if ($user['Status_Update'] === 'inactive') {
                        // User exists but status is inactive, send verification code

                        if (isset($_COOKIE['validateCode'])) {
                            setcookie('validateCode', '', time() - 3600, "/"); 
                        }
                        
                        $validate_code = rand(1000, 9999);
                        setcookie('validateCode', $validate_code, time() + (86400 * 30), "/");
            
                        
                        sendMail($profile['email'], 'Email Verification Code', 'Your verification code is: ' . $validate_code);
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_name'] = $user['username'];
                        $_SESSION['user_email'] = $user['email'];
                        $_SESSION['user_email_registered'] = $user['email'];
                        $_SESSION['logged_in'] = true;

                        header('Location: validate-code.php');
                        exit;
                    } else {
                        // User exists and status is active, no need to send code
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_name'] = $user['username'];
                        $_SESSION['user_email'] = $user['email'];   
                        $_SESSION['logged_in'] = true;
                        
                        header('Location: ../Create_Store/website_buildup.php');
                        exit;
                    }
                } else {
                    // Insert new user
                    $stmt = $conn->prepare("INSERT INTO users (email, username, image, Status_Update) VALUES (?,?,?, 'inactive')");
                    if ($stmt === false) {
                        die('Prepare failed: ' . htmlspecialchars($conn->error));
                    }
                    
                    $stmt->bind_param("sss", $profile['email'], $_SESSION['google_name'], $_SESSION['google_picture']);
                    if($stmt->execute()){
                        $_SESSION['user_id'] = $conn->insert_id;
                        $_SESSION['user_name'] = $_SESSION['google_name'];
                        $_SESSION['user_email'] = $profile['email'];
                        $_SESSION['user_email_registered'] = $user['email'];
                        $_SESSION['logged_in'] = true;

                        // Send verification code for new user

                        if (isset($_COOKIE['validateCode'])) {
                            setcookie('validateCode', '', time() - 3600, "/");
                        }
                        echo($_COOKIE['valdiateCode']);
                        exit();

                        $validate_code = rand(1000, 9999);
                        setcookie('validateCode', $validate_code, time() + (86400 * 30), "/"); // Expiry 30 days
                        sendMail($profile['email'], 'Email Verification Code', 'Your verification code is: ' . $validate_code);
                        error_log("Verification code sent to " . $profile['email']);
                        echo($validate_code);
                        echo($_COOKIE['validateCode']);
                        exit();
                        header('Location: validate-code.php');
                        exit;
                    } else {
                        echo "Error executing query: ". $stmt->error;
                    }
                }
            } else {
                echo "Error executing query: ". $stmt->error;
            }
        } else {
            exit('Could not retrieve profile information! Please try again later!');
        }
    } else {
        exit('Invalid access token! Please try again later!');
    }
} else {
    $params = [
        'response_type' => 'code',
        'client_id' => $google_oauth_client_id,
        'redirect_uri' => $google_oauth_redirect_uri,
        'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
        'access_type' => 'offline',
        'prompt' => 'consent'
    ];
    header('Location: https://accounts.google.com/o/oauth2/auth?' . http_build_query($params));
    exit;
}
?>
