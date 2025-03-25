<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Encrypt password
    $gender = $_POST["gender"];
    $age = $_POST["age"];

    $sql = "INSERT INTO users (fullname, email, password, gender, age) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $fullname, $email, $password, $gender, $age);
    
    if ($stmt->execute()) {
        echo "Signup successful! <a href='login.html'>Login Here</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
