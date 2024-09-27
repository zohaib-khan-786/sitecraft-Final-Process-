<?php
session_start();
// Database connection
include "connection.php";

// Include PHPMailer classes at the top
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Require autoload.php at the top
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $stmt = $conn->prepare("insert INTO contact_form (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        // Initialize PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'aqsajamil379@gmail.com'; // Replace with your email address
            $mail->Password = 'jmyxmuzpjcdfkycp'; // Replace with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('aqsajamil379@gmail.com', 'SiteCraft'); // Replace with your email address and name
            $mail->addAddress($email); // Replace with the email address to receive contact form submissions

            $mail->isHTML(true);
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body    = "Name: $name<br>Email: $email<br>Subject: $subject<br>Message: $message";

            $mail->send();
            echo "Message sent successfully!";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Failed to save message. Please try again later.";
    }

    $stmt->close();
    $conn->close();
}
?>