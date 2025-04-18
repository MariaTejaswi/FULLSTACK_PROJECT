<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize filter parameters
$category = 'Women'; // Fixed to Women
$min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 10000;
$size = isset($_GET['size']) ? $_GET['size'] : '';

// Build the SQL query with fixed category
$sql = "SELECT * FROM products WHERE category = ?";
$params = [$category];
$types = 's';

if ($min_price > 0) {
    $sql .= " AND price >= ?";
    $params[] = $min_price;
    $types .= 'd';
}
if ($max_price < 10000) {
    $sql .= " AND price <= ?";
    $params[] = $max_price;
    $types .= 'd';
}
if (!empty($size)) {
    $sql .= " AND size = ?";
    $params[] = $size;
    $types .= 's';
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Women's Collection | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .wishlist-button {
            position: absolute;
            top: 2px;
            right: 2px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.5rem;
            color: #9ca3af;
            transition: color 0.2s ease;
            z-index: 10;
        }
        .wishlist-button:hover {
            color: #ef4444;
        }
        .wishlist-button.filled {
            color: #ef4444;
        }
        .filter-sidebar {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }
        .filter-sidebar h3 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .filter-sidebar label {
            display: block;
            margin-bottom: 0.5rem;
            cursor: pointer;
        }
        .filter-sidebar input[type="checkbox"],
        .filter-sidebar input[type="radio"] {
            margin-right: 0.5rem;
        }
        .filter-sidebar .price-range {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .filter-sidebar input[type="number"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .filter-sidebar button {
            width: 100%;
            padding: 0.75rem;
            background: #3B8A9C;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .filter-sidebar button:hover {
            background: #2a6a7c;
        }
        .content-container {
            display: flex;
            flex-direction: row;
            gap: 2rem;
            align-items: flex-start;
        }
        @media (max-width: 768px) {
            .content-container {
                flex-direction: column;
            }
            .filter-sidebar {
                margin-bottom: 2rem;
                width: 100%;
            }
        }
    </style>
</head>
<body class="font-sans bg-gradient-to-r from-[#5a99a8] to-[#F5F7FA] text-black" id="body">
    <!-- Navigation Bar -->
    <nav class="bg-[#3B8A9C] text-white">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex space-x-4">
                <a href="/FULLSTACK_PROJECT/homepage/homepage1.php" class="px-3 py-2 block hover:bg-white hover:text-[#3B8A9C] rounded transition">HOME</a>
                <a href="/FULLSTACK_PROJECT/shop/shop.php" class="px-3 py-2 block bg-white text-[#3B8A9C] rounded transition">SHOP</a>
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

    <section class="max-w-7xl mx-auto py-12 px-2">
        <h2 id="auto-type-text" class="text-3xl md:text-4xl font-semibold italic text-center text-black mb-8"></h2>

        <div class="content-container">
            <!-- Filter Sidebar -->
            <div class="filter-sidebar md:w-1/4">
                <h3>Filters</h3>
                <form id="filter-form">
                    <!-- Price Range Filter -->
                    <div class="mb-6">
                        <h4 class="font-semibold mb-2">Price Range</h4>
                        <div class="price-range">
                            <input type="number" name="min_price" placeholder="Min Price" min="0" value="<?php echo $min_price; ?>">
                            <input type="number" name="max_price" placeholder="Max Price" min="0" value="<?php echo $max_price; ?>">
                        </div>
                    </div>
                    <!-- Size Filter -->
                    <div class="mb-6">
                        <h4 class="font-semibold mb-2">Size</h4>
                        <label><input type="checkbox" name="size" value="S"> Small</label>
                        <label><input type="checkbox" name="size" value="M"> Medium</label>
                        <label><input type="checkbox" name="size" value="L"> Large</label>
                        <label><input type="checkbox" name="size" value="XL"> Extra Large</label>
                    </div>
                    <button type="submit">Apply Filters</button>
                </form>
            </div>

            <!-- Product Grid -->
            <div class="md:w-3/4">
                <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-[40px] p-4">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        $is_in_wishlist = false;
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                            $check_wishlist_sql = "SELECT * FROM u_wishlist WHERE user_id = ? AND product_id = ?";
                            $check_wishlist_stmt = $conn->prepare($check_wishlist_sql);
                            $check_wishlist_stmt->bind_param('ii', $user_id, $row['id']);
                            $check_wishlist_stmt->execute();
                            $wishlist_result = $check_wishlist_stmt->get_result();
                            $is_in_wishlist = $wishlist_result->num_rows > 0;
                            $check_wishlist_stmt->close();
                        }
                        ?>
                        <div class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-300 hover:shadow-2xl hover:scale-105 relative">
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="w-full h-60 object-cover">
                            <button onclick="toggleWishlist(<?php echo $row['id']; ?>, this)" 
                                    class="wishlist-button <?php echo $is_in_wishlist ? 'filled' : ''; ?>"
                                    data-product-id="<?php echo $row['id']; ?>">
                                <i class="fas fa-heart"></i>
                            </button>
                            <div class="p-5">
                                <a href="/FULLSTACK_PROJECT/product/product.php?id=<?php echo $row['id']; ?>" class="text-xl font-semibold hover:underline">
                                    <?php echo htmlspecialchars($row['name']); ?>
                                </a>
                                <p class="text-gray-600 text-sm"><?php echo htmlspecialchars($row['description']); ?></p>
                                <p class="text-lg font-bold text-[#3B8A9C] mt-2">₹<?php echo number_format($row['price'], 2); ?></p>
                                <button onclick="addToCart(<?php echo $row['id']; ?>)" 
                                        class="mt-4 w-full bg-[#3B8A9C] text-white px-4 py-2 rounded transition-transform duration-200 hover:scale-110">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>

    <script>
        const text = "WOMEN'S COLLECTIONS";
        const autoTypeElement = document.getElementById("auto-type-text");
        let typeIndex = 0;

        function typeEffect() {
            if (typeIndex < text.length) {
                autoTypeElement.textContent += text.charAt(typeIndex);
                typeIndex++;
                setTimeout(typeEffect, 100);
            } else {
                setTimeout(() => {
                    autoTypeElement.textContent = "";
                    typeIndex = 0;
                    typeEffect();
                }, 2000);
            }
        }

        window.addEventListener("DOMContentLoaded", typeEffect);

        function addToCart(productId) {
            fetch('/FULLSTACK_PROJECT/cart/add_to_cart.php', {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "product_id=" + encodeURIComponent(productId) + "&quantity=1"
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: data.status,
                    text: data.message,
                    icon: data.icon,
                    confirmButtonColor: "#3B8A9C"
                });
            })
            .catch(error => {
                console.error("Fetch Error:", error);
                Swal.fire({
                    title: "Error",
                    text: "Failed to connect to the server!",
                    icon: "error",
                    confirmButtonColor: "#3B8A9C"
                });
            });
        }

        function toggleWishlist(productId, buttonElement) {
            const heartIcon = buttonElement.querySelector('i');
            const isFilled = buttonElement.classList.contains('filled');
            const action = isFilled ? 'remove' : 'add';

            fetch('/FULLSTACK_PROJECT/wishlist/toggle_wishlist.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + encodeURIComponent(productId) + '&action=' + encodeURIComponent(action)
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: data.status,
                    text: data.message,
                    icon: data.icon,
                    confirmButtonColor: '#3B8A9C'
                });

                if (data.status === 'Success') {
                    if (action === 'add') {
                        buttonElement.classList.add('filled');
                    } else {
                        buttonElement.classList.remove('filled');
                    }
                }
            })
            .catch(error => {
                console.error('Wishlist Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to connect to the server!',
                    icon: 'error',
                    confirmButtonColor: '#3B8A9C'
                });
            });
        }

        // Handle filter form submission
        document.getElementById('filter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const params = new URLSearchParams();

            // Always include category=Women
            params.append('category', 'Women');

            // Handle multiple sizes
            const sizes = formData.getAll('size');
            if (sizes.length > 0) {
                params.append('size', sizes.join(','));
            }

            // Price range (only if non-empty)
            const minPrice = formData.get('min_price');
            if (minPrice && minPrice !== '') {
                params.append('min_price', minPrice);
            }
            const maxPrice = formData.get('max_price');
            if (maxPrice && maxPrice !== '') {
                params.append('max_price', maxPrice);
            }

            fetch('/FULLSTACK_PROJECT/shop/filter_products.php?' + params.toString(), {
                method: 'GET'
            })
            .then(response => {
                console.log('Response status:', response.status); // Debug
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data); // Debug
                const productGrid = document.getElementById('product-grid');
                productGrid.innerHTML = '';

                if (data.error) {
                    Swal.fire({
                        title: 'Error',
                        text: data.error,
                        icon: 'error',
                        confirmButtonColor: '#3B8A9C'
                    });
                    return;
                }

                if (data.products.length === 0) {
                    productGrid.innerHTML = '<p class="text-center col-span-full">No products found.</p>';
                    return;
                }

                data.products.forEach(product => {
                    const isInWishlist = data.wishlist.includes(product.id.toString());
                    const productCard = `
                        <div class="bg-white shadow-md rounded-lg overflow-hidden transform transition duration-300 hover:shadow-2xl hover:scale-105 relative">
                            <img src="${product.image}" alt="${product.name}" class="w-full h-60 object-cover">
                            <button onclick="toggleWishlist(${product.id}, this)" 
                                    class="wishlist-button ${isInWishlist ? 'filled' : ''}"
                                    data-product-id="${product.id}">
                                <i class="fas fa-heart"></i>
                            </button>
                            <div class="p-5">
                                <a href="/FULLSTACK_PROJECT/product/product.php?id=${product.id}" class="text-xl font-semibold hover:underline">
                                    ${product.name}
                                </a>
                                <p class="text-gray-600 text-sm">${product.description}</p>
                                <p class="text-lg font-bold text-[#3B8A9C] mt-2">₹${parseFloat(product.price).toFixed(2)}</p>
                                <button onclick="addToCart(${product.id})" 
                                        class="mt-4 w-full bg-[#3B8A9C] text-white px-4 py-2 rounded transition-transform duration-200 hover:scale-110">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    `;
                    productGrid.innerHTML += productCard;
                });
            })
            .catch(error => {
                console.error('Filter Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to apply filters!',
                    icon: 'error',
                    confirmButtonColor: '#3B8A9C'
                });
            });
        });

        // Handle localStorage for wishlist
        document.addEventListener("DOMContentLoaded", function () {
            let removedItems = JSON.parse(localStorage.getItem("removedWishlist")) || [];
            removedItems.forEach(productId => {
                let btn = document.querySelector(`button[data-product-id="${productId}"]`);
                if (btn) {
                    btn.classList.remove("filled");
                }
            });
            if (removedItems.length > 0) {
                localStorage.removeItem("removedWishlist");
            }
        });
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>