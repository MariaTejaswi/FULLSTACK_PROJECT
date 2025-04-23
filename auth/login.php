<?php
include "db.php";
session_start(); // Start session at the beginning

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $email = trim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_EMAIL));
    $password = trim($_POST["password"]);

    // Server-side validation
    $errors = [];

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (!empty($errors)) {
        $errorMessage = implode("\n", $errors);
        echo "<script>
                alert('$errorMessage');
                window.location.href = '/FULLSTACK_PROJECT/auth/login.html';
              </script>";
        exit();
    }

    // Database query
    $sql = "SELECT id, fullname, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $fullname, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Regenerate session ID for security
            session_regenerate_id(true);

            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $fullname;

            header("Location: /FULLSTACK_PROJECT/homepage/homepage1.php");
            exit();
        } else {
            echo "<script>
                    alert('Incorrect Password!');
                    window.location.href = '/FULLSTACK_PROJECT/auth/login.html';
                  </script>";
            exit();
        }
    } else {
        echo "<script>
                alert('User not found!');
                window.location.href = '/FULLSTACK_PROJECT/auth/login.html';
              </script>";
        exit();
    }

    $stmt->close();
} else {
    // Redirect if accessed directly (not via POST)
    header("Location: /FULLSTACK_PROJECT/auth/login.html");
    exit();
}

$conn->close();
?>