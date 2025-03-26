<?php
include "db.php";
session_start(); // Start session at the beginning

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["username"]); // Trim to remove spaces
    $password = $_POST["password"];

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
            $_SESSION["username"] = $fullname; // Store the user's name

            header("Location: /FULLSTACK_PROJECT/homepage/homepage.php");
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
}
$conn->close();
?>