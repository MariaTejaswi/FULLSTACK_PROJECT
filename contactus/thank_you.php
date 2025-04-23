<?php
if (isset($_GET['name'], $_GET['type'], $_GET['email'], $_GET['message'])) {
    $name = htmlspecialchars($_GET['name']);
    $type = htmlspecialchars($_GET['type']);
    $email = htmlspecialchars($_GET['email']);
    $message = htmlspecialchars($_GET['message']);
} else {
    // If no query parameters, redirect back to the contact form
    header("Location: contact.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Received</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css"> <!-- Make sure this path is correct -->
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s ease-in-out;
        }
        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gradient-to-r to-[#5a99a8] from-[#F5F7FA] flex items-center justify-center min-h-screen">
    <div id="thanksCard" class="bg-[#3B8A9C] p-10 rounded-2xl shadow-lg text-center max-w-xl text-white fade-in scale-95">
        <h2 class="text-3xl font-bold mb-4">Thank you, <?php echo $name ?: 'Guest'; ?>!</h2>
        <p class="mb-2 text-lg">We received your <strong><?php echo $type ?: 'general'; ?></strong> query.</p>
        <p class="mb-2">We’ll get back to you at <strong><?php echo $email ?: 'your email address'; ?></strong>.</p>
        <p class="italic text-white/80 mt-4">“<?php echo $message ?: 'No message provided'; ?>”</p>
        <a href="contact.php" class="inline-block mt-6 bg-white text-[#3B8A9C] px-5 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300">Go Back</a>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            document.getElementById('thanksCard').classList.add('show');
        });
    </script>
</body>
</html>
