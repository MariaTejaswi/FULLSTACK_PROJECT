<?php
session_start();
require_once '../auth/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$updated = false; // Flag to show alert

// Handle image and form updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (in_array($_FILES['profile_image']['type'], $allowedTypes)) {
            $filename = time() . '_' . basename($_FILES['profile_image']['name']);
            $targetPath = '../uploads/' . $filename;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath);
            mysqli_query($conn, "UPDATE users SET image = '$filename' WHERE id = $user_id");
        }
    }

    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password = '$hashed' WHERE id = $user_id");
    }

    mysqli_query($conn, "UPDATE users SET gender = '$gender', age = $age WHERE id = $user_id");

    $updated = true; // Set the flag for success message

    // Re-fetch updated user data
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
    $user = mysqli_fetch_assoc($result);
} else {
    // First load
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
    $user = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link href="../src/output.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-gray-400 to-[#6daab9] min-h-screen">
<!-- Navigation Bar -->
    <nav class="bg-[#3B8A9C] text-white">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex space-x-4">
                <a href="/FULLSTACK_PROJECT/homepage/homepage1.php" class="px-3 py-2 block hover:bg-white hover:text-[#3B8A9C] rounded transition">HOME</a>
                <a href="shop.php" class="px-3 py-2 block bg-white text-[#3B8A9C] rounded transition">SHOP</a>
                <a href="/FULLSTACK_PROJECT/cart/cart.php" class="px-3 py-2 block hover:bg-white hover:text-[#3B8A9C] rounded transition">CART</a>
                <a href="/FULLSTACK_PROJECT/wishlist/wishlist.php" class="px-3 py-2 block hover:bg-white hover:text-[#3B8A9C] rounded transition">WISHLIST</a>
                <a href="/FULLSTACK_PROJECT/contactus/contact.php" class="px-3 py-2 block hover:bg-white hover:text-[#3B8A9C] rounded transition">CONTACT</a>
            </div>
            <div class="flex items-center space-x-4 ml-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-white">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                    <a href="/FULLSTACK_PROJECT/homepage/logout.php" class="px-3 py-2 bg-white text-[#3B8A9C] rounded">LOGOUT</a>
                <?php else: ?>
                    <a href="/FULLSTACK_PROJECT/auth/login.html" class="px-3 py-2 bg-white text-[#3B8A9C] rounded">LOGIN / SIGN UP</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
<?php if ($updated): ?>
    <script>
        window.onload = function () {
            alert("Profile updated successfully!");
            // Refresh the page after alert is closed
            setTimeout(function () {
                window.location.href = window.location.href;
            }, 100);
        };
    </script>
<?php endif; ?>
<div class=" flex items-center justify-center">
<div class="bg-white p-8 rounded shadow-md w-full max-w-md mt-25">
        <h2 class="text-2xl font-bold mb-6 text-center">Your Profile</h2>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <!-- Profile Image -->
            <?php
            $profileImage = (!empty($user['image'])) ? $user['image'] : 'default.png';
            $imagePath = "../uploads/" . $profileImage;
            ?>
            <div class="text-center">
                <img src="<?php echo $imagePath; ?>" alt="Profile Image" class="mx-auto rounded-full w-24 h-24 object-cover">
                <div class="mt-4 flex justify-center">
    <label class="cursor-pointer bg-[#3B8A9C] text-white px-4 py-2 rounded-full hover:bg-purple-200 text-sm font-medium">
        Change profile picture
        <input type="file" name="profile_image" accept="image/*" class="hidden">
    </label>
</div>

            </div>

            <!-- User Info -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" value="<?php echo htmlspecialchars($user['fullname']); ?>" disabled class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 cursor-not-allowed h-10 p-3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm h-10 pl-2">
                    <option value="Male" <?php if($user['gender'] == 'male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if($user['gender'] == 'female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if($user['gender'] == 'other') echo 'selected'; ?>>Other</option>
                    <option value="NA" <?php if($user['gender'] == 'na') echo 'selected'; ?>>Prefer not to say</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Age</label>
                <input type="number" name="age" value="<?php echo $user['age']; ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm h-10 p-3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" name="password" placeholder="Enter new password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm h-10 p-3">
            </div>

            <div class="text-center">
                <button type="submit" class="bg-[#3B8A9C] text-white py-2 px-4 rounded transition">Update Profile</button>
            </div>
        </form>
    </div>
</div>
    
</body>
</html>