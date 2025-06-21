<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "info@tourrx.com";
    $subject = "New Contact Form Submission from TourRx Website";

    $name = htmlspecialchars(trim($_POST["name"] ?? ''));
    $email = htmlspecialchars(trim($_POST["email"] ?? ''));
    $phone = htmlspecialchars(trim($_POST["phone"] ?? ''));
    $message = htmlspecialchars(trim($_POST["message"] ?? ''));

    $email_body = "You have received a new message from the contact form.\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Contact Number: $phone\n";
    $email_body .= "Message:\n$message\n";

    $headers = "From: TourRx Website <noreply@tourrx.com>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Optional log for debugging
    file_put_contents("debug.txt", "Form received from $name <$email>\n", FILE_APPEND);

    if (mail($to, $subject, $email_body, $headers)) {
        header("Location: https://tourrx.com");
        exit();
    } else {
        echo "Message delivery failed.";
    }
} else {
    echo "Invalid request method.";
}
?>
