<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $type    = htmlspecialchars($_POST['type']);
    $message = htmlspecialchars($_POST['message']);
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Message Received</title>
        <!-- <script src="https://cdn.tailwindcss.com"></script> -->
         <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
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
    <body class="bg-gradient-to-r from-gray-600 to-gray-300 flex items-center justify-center min-h-screen">

        <div id="thanksCard" class="bg-[#3B8A9C] p-10 rounded-2xl shadow-lg text-center max-w-xl text-white fade-in scale-95">
            <h2 class="text-3xl font-bold mb-4">Thank you, <?php echo $name; ?>!</h2>
            <p class="mb-2 text-lg">We received your <strong><?php echo $type; ?></strong> query.</p>
            <p class="mb-2">We’ll get back to you at <strong><?php echo $email; ?></strong>.</p>
            <p class="italic text-white/80 mt-4">“<?php echo $message; ?>”</p>
            <a href="contact.php" class="inline-block mt-6 bg-white text-[#3B8A9C] px-5 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300">Go Back</a>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', () => {
                document.getElementById('thanksCard').classList.add('show');
            });
        </script>
    </body>
    </html>

<?php
}
?>
