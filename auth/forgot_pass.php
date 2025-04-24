<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
    $security_question = trim($_POST["security_question"]);
    $security_answer = trim($_POST["security_answer"]);
    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Server-side validation
    $errors = [];

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }

    if (empty($security_answer)) {
        $errors[] = "Please answer the security question.";
    }

    if (empty($new_password) || strlen($new_password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($new_password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (!empty($errors)) {
        echo "<script>alert('" . implode("\n", $errors) . "');</script>";
        exit();
    }

    // Check if email exists
    $sql = "SELECT id, security_answer FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_answer);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();

        // Verify the security answer
        if (password_verify($security_answer, $hashed_answer)) {
            // Encrypt new password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update the password in the database
            $update_sql = "UPDATE users SET password = ? WHERE email = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $hashed_password, $email);

            if ($update_stmt->execute()) {
                echo "<script>alert('Password reset successful! You can now login.'); window.location.href='/FULLSTACK_PROJECT/auth/login.html';</script>";
            } else {
                echo "<script>alert('Error resetting password. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Incorrect answer to the security question.');</script>";
        }
    } else {
        echo "<script>alert('Email not found.');</script>";
    }

    $stmt->close();
} else {
    header("Location: /FULLSTACK_PROJECT/auth/forgot-password.html");
    exit();
}

$conn->close();
?>