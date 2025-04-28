<?php
ob_start();
include "db.php";
require 'C:/xampp/htdocs/FULLSTACK_PROJECT/phpmailer/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = trim(filter_var($input['email'] ?? '', FILTER_SANITIZE_EMAIL));

    if (empty($email)) {
        ob_end_clean();
        echo json_encode(['success' => false, 'message' => 'Email is required']);
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        ob_end_clean();
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit();
    }

    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        ob_end_clean();
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $stmt->close();
        ob_end_clean();
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit();
    }
    $stmt->close();

    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Update or insert token
    $sql = "INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE token = ?, expires = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        ob_end_clean();
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        exit();
    }
    $stmt->bind_param("sssss", $email, $token, $expires, $token, $expires);
    if (!$stmt->execute()) {
        $stmt->close();
        ob_end_clean();
        echo json_encode(['success' => false, 'message' => 'Failed to store reset token: ' . $stmt->error]);
        exit();
    }
    $stmt->close();

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
        $mail->addAddress($email);
        $resetLink = "http://localhost/FULLSTACK_PROJECT/auth/reset.php?token=" . urlencode($token);
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = "Hello,<br><br>You requested a password reset. Click the link below to reset your password:<br><a href='$resetLink'>Reset Password</a><br><br>This link will expire in 1 hour.<br><br>If you did not request this, please ignore this email.";
        $mail->AltBody = "Hello,\n\nYou requested a password reset. Visit this link to reset your password:\n$resetLink\n\nThis link will expire in 1 hour.\n\nIf you did not request this, please ignore this email.";
        $mail->send();
        ob_end_clean();
        echo json_encode(['success' => true, 'message' => 'Reset link sent to your email']);
    } catch (Exception $e) {
        ob_end_clean();
        echo json_encode(['success' => false, 'message' => 'Failed to send reset email: ' . $e->getMessage()]);
    }

    $conn->close();
} else {
    ob_end_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
ob_end_clean();
?>