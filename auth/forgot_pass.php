<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
    $security_question = trim($_POST["security_question"]);
    $security_answer = trim($_POST["security_answer"]);
    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    $errors = [];

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }

    if (empty($security_question)) {
        $errors[] = "Please select your security question.";
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
        echo "<script>alert('" . implode("\\n", $errors) . "'); window.history.back();</script>";
        exit();
    }

    // Fetch the user and check email, security question, and hashed answer
    $sql = "SELECT id, security_question, security_answer FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $stored_question, $stored_answer);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();

        // Check if the security question matches and verify the hashed answer
        if ($security_question === $stored_question && password_verify($security_answer, $stored_answer)) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update the password in the database
            $update_sql = "UPDATE users SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $hashed_password, $id);

            if ($update_stmt->execute()) {
                echo "<script>
                        alert('Password reset successful. You can now login.');
                        window.location.href = '/FULLSTACK_PROJECT/auth/login.html';
                      </script>";
            } else {
                echo "<script>alert('Failed to update password. Try again later.');</script>";
            }

            $update_stmt->close();
        } else {
            echo "<script>alert('Security question or answer is incorrect.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No user found with that email.'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    header("Location: /FULLSTACK_PROJECT/auth/forgot-password.html");
    exit();
}

$conn->close();
?>
