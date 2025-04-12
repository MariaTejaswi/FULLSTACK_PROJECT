<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.7s ease-in-out;
        }
        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-[#3B8A9C] flex items-center justify-center min-h-screen">
  <div class="absolute inset-0 bg-[url('../images/contactus.png')] bg-cover bg-center opacity-75"></div>


    <div id="formCard" class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md fade-in scale-95">
        <h2 class="text-3xl font-bold mb-6 text-[#3B8A9C] text-center animate-bounce">Contact Us</h2>
        <form action="submit_contact.php" method="POST" class="space-y-5">
            <input type="text" name="name" placeholder="Your Name" required 
                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3B8A9C] transition-all duration-300 hover:shadow-md" />

            <input type="email" name="email" placeholder="Your Email" required 
                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3B8A9C] transition-all duration-300 hover:shadow-md" />

            <select name="type" required 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3B8A9C] transition-all duration-300 hover:shadow-md">
                <option value="">-- Select Query Type --</option>
                <option value="Order Related">Order Related</option>
                <option value="Product Info">Product Info</option>
                <option value="Return/Exchange">Return/Exchange</option>
                <option value="Other">Other</option>
            </select>

            <textarea name="message" rows="5" placeholder="Type your query here..." required 
                      class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3B8A9C] transition-all duration-300 hover:shadow-md"></textarea>

            <button type="submit" 
                    class="w-full bg-[#3B8A9C] text-white py-3 rounded-lg hover:bg-[#337685] transition-all duration-300 transform hover:scale-105">Send Message</button>
        </form>
    </div>

    <script>
        // Fade-in animation on page load
        window.addEventListener('DOMContentLoaded', () => {
            document.getElementById('formCard').classList.add('show');
        });
    </script>
</body>
</html>
