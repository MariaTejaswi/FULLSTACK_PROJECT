<?php
// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Correct path to autoload using relative directory
require __DIR__ . '/../phpmailer/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and store form input
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $type    = htmlspecialchars($_POST['type']);
    $message = htmlspecialchars($_POST['message']);

    // Send mail using PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Set SMTP server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mariatejaswiimandi@gmail.com'; // Your Gmail address
        $mail->Password   = 'ihbw txyl ouzo xzip'; // Your 16-character App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS encryption
        $mail->Port       = 587;  // Port for TLS

        // Set the sender and recipient addresses
        $mail->setFrom($email, $name);
        $mail->addAddress('mariatejaswiimandi@gmail.com'); // Send email to yourself

        // Set email content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Query from $name";
        $mail->Body    = "
            <h2>New Message from Fashion Store Contact Page</h2>
            <p><b>Name:</b> $name</p>
            <p><b>Email:</b> $email</p>
            <p><b>Type:</b> $type</p>
            <p><b>Message:</b><br>$message</p>
        ";

        // Attempt to send the email
        $mail->send();

        // Redirect to thank you page with encoded parameters
        header("Location: thank_you.php?name=" . urlencode($name) . "&type=" . urlencode($type) . "&email=" . urlencode($email) . "&message=" . urlencode($message));
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        exit();
    }
}
?>