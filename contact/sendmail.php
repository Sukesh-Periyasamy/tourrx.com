<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"] ?? ''));
    $email = htmlspecialchars(trim($_POST["email"] ?? ''));
    $phone = htmlspecialchars(trim($_POST["phone"] ?? ''));
    $message = htmlspecialchars(trim($_POST["message"] ?? ''));

    // Basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP settings (HostingRaja or use mail.tourrx.com)
        $mail->isSMTP();
        $mail->Host = 'mail.tourrx.com';          // Confirm with HostingRaja if different
        $mail->SMTPAuth = true;
        $mail->Username = 'info@tourrx.com';      // Your domain email
        $mail->Password = '12345678@#aAbBcC';  // Replace with your real password
        $mail->SMTPSecure = 'tls';                // Or 'ssl' if required
        $mail->Port = 587;                         // Or 465 for SSL

        // Sender and recipient
        $mail->setFrom('info@tourrx.com', 'TourRx Website');
        $mail->addAddress('info@tourrx.com');       // Where you receive the message
        $mail->addReplyTo($email, $name);

        // Message content
        $mail->isHTML(false);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";

        $mail->send();
        header("Location: https://tourrx.com"); // Redirect on success
        exit();
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
