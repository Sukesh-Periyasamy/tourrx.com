<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Show errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars(trim($_POST["name"] ?? ''));
    $email   = htmlspecialchars(trim($_POST["email"] ?? ''));
    $phone   = htmlspecialchars(trim($_POST["phone"] ?? ''));
    $message = htmlspecialchars(trim($_POST["message"] ?? ''));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 's4159.bom1.stableserver.net';   // HostingRaja secure SMTP host
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@tourrx.com';               // Your email
        $mail->Password   = '12345678@#aAbBcC';           // Replace with actual password
        $mail->SMTPSecure = 'ssl';                           // Use SSL
        $mail->Port       = 465;                             // SSL port

        // Sender and recipient
        $mail->setFrom('info@tourrx.com', 'TourRx Website');
        $mail->addAddress('info@tourrx.com');                // Receiver
        $mail->addReplyTo($email, $name);                    // User's email

        // Email content
        $mail->isHTML(false);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "Name: $name\n"
                       . "Email: $email\n"
                       . "Phone: $phone\n\n"
                       . "Message:\n$message";

        // Send the message
        $mail->send();
        header("Location: https://tourrx.com"); // Redirect on success
        exit();

    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
