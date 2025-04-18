<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];

    // Basic validation
    if (empty($fullname) || empty($email) || empty($password) || empty($gender) || empty($age)) {
        echo "<script>
                alert('All fields are required!');
                window.location.href = '/FULLSTACK_PROJECT/auth/signup.html';
              </script>";
        exit();
    }

    // Check if email already exists
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

    // Encrypt password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert into database
    $sql = "INSERT INTO users (fullname, email, password, gender, age) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<script>
                alert('Query preparation failed!');
              </script>";
        exit();
    }

    $stmt->bind_param("ssssi", $fullname, $email, $hashed_password, $gender, $age);

    if ($stmt->execute()) {
        // Send an HTML response with SweetAlert2
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
        echo "<script>
                alert('Signup failed. Try again!');
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
