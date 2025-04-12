<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: /FULLSTACK_PROJECT/auth/login.html");
    exit();
}

// Fetch user details if needed
$username = $_SESSION['username'];  // Assuming username is stored in session
?>
