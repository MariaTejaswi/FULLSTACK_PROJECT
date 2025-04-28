<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'C:/xampp/htdocs/FULLSTACK_PROJECT/phpmailer/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mariatejaswiimandi@gmail.com';
    $mail->Password = 'ihbw txyl ouzo xzip';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom('no-reply@yourdomain.com', 'FashionHub');
    $mail->addAddress('test@example.com');
    $mail->Subject = 'Test Email';
    $mail->Body = 'This is a test email.';
    $mail->send();
    echo 'Email sent successfully';
} catch (Exception $e) {
    echo 'Error: ' . $mail->ErrorInfo;
}
?>