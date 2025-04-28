<?php
include "db.php";

$token = $_GET['token'] ?? '';
$validToken = false;
$email = '';
$errorMessage = '';

if ($token) {
    $sql = "SELECT email, expires FROM password_resets WHERE token = ? AND expires > NOW()";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $errorMessage = "Database error: " . $conn->error;
    } else {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($email, $expires);
            $stmt->fetch();
            $validToken = true;
        } else {
            $errorMessage = "Invalid or expired reset link.";
        }
        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $validToken) {
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    $errors = [];
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $errors[] = "Database error: " . $conn->error;
        } else {
            $stmt->bind_param("ss", $hashed_password, $email);
            if ($stmt->execute()) {
                $sql = "DELETE FROM password_resets WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                echo "<script>
                        alert('Password reset successfully! Please log in.');
                        window.location.href = '/FULLSTACK_PROJECT/auth/login.html';
                      </script>";
                exit();
            } else {
                $errors[] = "Failed to update password.";
            }
            $stmt->close();
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="/FULLSTACK_PROJECT/src/output.css" rel="stylesheet">
</head>
<body class="px-6 pb-4 bg-gradient-to-r from-gray-400 to-[#6daab9]">
    <div class="absolute inset-0 bg-[url('../images/login.png')] bg-center bg-cover"></div>
    <div class="w-full max-w-md mx-auto relative mt-30 md:mt-60">
        <div class="absolute w-[200%] h-[130%] left-[-50%] top-[-15%] bg-gray-300/50 backdrop-blur-lg rounded-xl shadow-xl z-0"></div>
        <div class="relative w-full max-w-md mx-auto bg-white/70 backdrop-blur-md rounded-2xl p-6 shadow-lg z-10">
            <h1 class="text-center text-4xl font-bold font-serif">Reset Password</h1>

            <?php if (!$validToken): ?>
                <p class="text-center text-red-500 mt-4"><?php echo $errorMessage; ?></p>
                <p class="text-center mt-2"><a href="/FULLSTACK_PROJECT/auth/login.html" class="text-blue-500 underline">Back to Login</a></p>
            <?php else: ?>
                <?php if (!empty($errors)): ?>
                    <div class="text-red-500 text-center mb-4">
                        <?php echo implode("<br>", $errors); ?>
                    </div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="mb-4">
                        <label for="password" class="font-medium text-gray-700">New Password</label>
                        <input type="password" id="password" name="password" required
                            class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-[#3B8A9C]">
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="font-medium text-gray-700">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-[#3B8A9C]">
                    </div>
                    <button type="submit"
                        class="w-full mt-5 bg-[#3B8A9C] text-white py-2 rounded-lg hover:bg-[#589ca0eb] transition hover:cursor-pointer">
                        Reset Password
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>