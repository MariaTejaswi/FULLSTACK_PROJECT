<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim(filter_input(INPUT_POST, "fullname", FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $gender = trim($_POST["gender"]);
    $age = filter_input(INPUT_POST, "age", FILTER_VALIDATE_INT);
    $security_question = trim($_POST["security_question"]);
    $security_answer = trim($_POST["security_answer"]);

    $errors = [];

    if (empty($fullname) || strlen($fullname) < 2) {
        $errors[] = "Full name is required and must be at least 2 characters.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }

    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (empty($confirm_password) || $confirm_password !== $password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($gender) || $gender === "select") {
        $errors[] = "Please select a gender.";
    }

    if ($age === false || $age < 13 || $age > 80) {
        $errors[] = "Age must be between 13 and 80.";
    }

    if (empty($security_question) || empty($security_answer)) {
        $errors[] = "Security question and answer are required.";
    }

    if (!empty($errors)) {
        $errorMessage = implode("\n", $errors);
        echo "<script>
                alert('$errorMessage');
                window.location.href = '/FULLSTACK_PROJECT/auth/signup.html';
              </script>";
        exit();
    }

    $check_sql = "SELECT id FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>
                alert('Email already exists!');
                window.location.href = '/FULLSTACK_PROJECT/auth/signup.html';
              </script>";
        exit();
    }
    $check_stmt->close();

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $hashed_answer = password_hash($security_answer, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (fullname, email, password, gender, age, security_question, security_answer) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<script>alert('Query preparation failed!');</script>";
        exit();
    }

    $stmt->bind_param("ssssiss", $fullname, $email, $hashed_password, $gender, $age, $security_question, $hashed_answer);

    if ($stmt->execute()) {
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                  <script>
                      document.addEventListener('DOMContentLoaded', function() {
                          Swal.fire({
                              title: 'Signup Successful!',
                              text: 'Proceed to login?',
                              icon: 'success',
                              confirmButtonColor: '#3085d6',
                              confirmButtonText: 'OK'
                          }).then(() => {
                              window.location.href = '/FULLSTACK_PROJECT/auth/login.html';
                          });
                      });
                  </script>
              </head>
              <body></body>
              </html>";
        exit();
    } else {
        echo "<script>alert('Signup failed. Try again!');</script>";
    }

    $stmt->close();
} else {
    header("Location: /FULLSTACK_PROJECT/auth/signup.html");
    exit();
}

$conn->close();
?>