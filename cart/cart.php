<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fashionhub_db");

if (!isset($_SESSION['user_id'])) {
    echo "
    <script>
    window.onload = function () {
        Swal.fire({
            title: 'Login Required',
            text: 'Please log in to view your cart.',
            icon: 'warning',
            confirmButtonColor: '#3B8A9C'
        }).then(() => {
            window.location.href = '/FULLSTACK_PROJECT/auth/login.html';
        });
    }
    </script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT c.id, p.name, p.price, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = $user_id";
$result = $conn->query($sql);

$total_amount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart | FashionHub</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>
<body class="bg-gradient-to-r from-[#5a99a8] to-[#F5F7FA] text-[#3B8A9C] font-sans">

    <nav class="bg-[#3B8A9C] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between">
            <a href="/FULLSTACK_PROJECT/homepage/homepage1.php" class="px-3 py-2 hover:bg-white hover:text-[#3B8A9C] transition rounded">HOME</a>
            <a href="/FULLSTACK_PROJECT/shop/shop.php" class="px-3 py-2 bg-white text-[#3B8A9C] font-bold rounded shadow">SHOP</a>
        </div>
    </nav>

    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Cart Card -->
            <div class="w-full lg:w-1/2 bg-white border-2 border-[#3B8A9C] shadow-lg rounded-xl p-6 animate-fadein">
                <h2 class="text-3xl font-bold mb-6">🛍️ Your Cart</h2>

                <?php if ($result->num_rows > 0): ?>
                    <div class="space-y-4">
                        <?php while ($row = $result->fetch_assoc()):
                            $product_total = $row['price'] * $row['quantity'];
                            $total_amount += $product_total;
                        ?>
                            <div class="flex justify-between items-center bg-[#3B8A9C]/10 px-4 py-3 rounded-lg hover:shadow transition">
                                <div>
                                    <p class="font-semibold text-lg"><?php echo htmlspecialchars($row['name']); ?></p>
                                    <p class="text-sm">₹<?php echo number_format($row['price'], 2); ?> × <?php echo $row['quantity']; ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-lg">₹<?php echo number_format($product_total, 2); ?></p>
                                    <button onclick="removeFromCart(<?php echo $row['id']; ?>)" class="text-red-600 hover:text-red-800 text-sm">✖ Remove</button>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="mt-8 border-t pt-4 text-right">
                        <p class="text-xl font-bold">Total: ₹<?php echo number_format($total_amount, 2); ?></p>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Empty Cart" class="w-24 mx-auto mb-4 animate-bounce">
                        <p class="text-xl">Oops! Your cart is empty.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Ads Section -->
            <?php include '../advertise/ad.php'; ?>

        </div>

        <!-- Payment Section -->
        <div class="mt-12 bg-white border-2 border-[#3B8A9C] shadow-lg rounded-xl p-6 text-center animate-fadein">
            <h2 class="text-2xl font-bold mb-4">Ready to Checkout?</h2>
            <p class="text-lg mb-6">Complete your purchase securely</p>
            <button onclick="openPaymentModal()" class="bg-[#3B8A9C] hover:bg-[#317488] text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition">Proceed to Payment</button>
        </div>

        <!-- Payment Modal -->
        <div id="paymentModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-xl w-full max-w-md relative animate-fadein shadow-xl border-2 border-[#3B8A9C]">
                <button onclick="closePaymentModal()" class="absolute top-3 right-4 text-2xl text-red-600 hover:text-red-800">×</button>
                <h3 class="text-2xl font-bold mb-6 text-[#3B8A9C] text-center">Choose Payment Method</h3>

                <div class="flex justify-center gap-2 mb-4">
                    <button onclick="showTab('cardTab')" id="cardTabBtn" class="tab-btn bg-[#3B8A9C] text-white px-4 py-2 rounded shadow">Card</button>
                    <button onclick="showTab('upiTab')" id="upiTabBtn" class="tab-btn bg-gray-200 text-[#3B8A9C] px-4 py-2 rounded shadow">UPI</button>
                    <button onclick="showTab('debitTab')" id="debitTabBtn" class="tab-btn bg-gray-200 text-[#3B8A9C] px-4 py-2 rounded shadow">Debit/Credit</button>
                </div>

                <!-- CARD PAYMENT -->
                <form id="cardTab" onsubmit="handlePayment(event)" class="space-y-4 payment-tab">
                    <input type="text" required placeholder="Name on Card" class="w-full px-4 py-2 border placeholder-gray-400 rounded">
                    <input type="text" required placeholder="Card Number" maxlength="16" class="w-full px-4 py-2 border placeholder-gray-400 rounded">
                    <div class="flex gap-4">
                        <input type="text" required placeholder="MM/YY" maxlength="5" class="w-1/2 px-4 py-2 border placeholder-gray-400 rounded">
                        <input type="text" required placeholder="CVV" maxlength="3" class="w-1/2 px-4 py-2 border placeholder-gray-400 rounded">
                    </div>
                    <input type="text" required placeholder="Address" maxlength="30" class="w-full px-4 py-2 border placeholder-gray-400 rounded">
                    <button type="submit" class="w-full bg-[#3B8A9C] hover:bg-[#317488] text-white font-bold py-2 rounded transition">Pay ₹<?php echo number_format($total_amount, 2); ?></button>
                </form>

                <!-- UPI PAYMENT -->
                <form id="upiTab" onsubmit="handlePayment(event)" class="space-y-4 hidden payment-tab">
                    <input type="text" required placeholder="Your UPI ID (e.g., xyz@upi)" class="w-full px-4 py-2 border placeholder-gray-400 rounded">
                    <input type="text" required placeholder="Address" maxlength="30" class="w-full px-4 py-2 border placeholder-gray-400 rounded">
                    <button type="submit" class="w-full bg-[#3B8A9C] hover:bg-[#317488] text-white font-bold py-2 rounded transition">Pay ₹<?php echo number_format($total_amount, 2); ?> via UPI</button>
                </form>

                <!-- DEBIT / CREDIT PAYMENT -->
                <form id="debitTab" onsubmit="handlePayment(event)" class="space-y-4 hidden payment-tab">
                    <input type="text" required placeholder="Cardholder Name" class="w-full px-4 py-2 border placeholder-gray-400 rounded">
                    <input type="text" required placeholder="Card Number" maxlength="16" class="w-full px-4 py-2 border placeholder-gray-400 rounded">
                    <input type="text" required placeholder="Expiry Date (MM/YY)" maxlength="5" class="w-full px-4 py-2 border placeholder-gray-400 rounded">
                    <input type="text" required placeholder="CVV" maxlength="3" class="w-full px-4 py-2 border placeholder-gray-400 rounded">
                    <input type="text" required placeholder="Address" maxlength="30" class="w-full px-4 py-2 border placeholder-gray-400 rounded">
                    <button type="submit" class="w-full bg-[#3B8A9C] hover:bg-[#317488] text-white font-bold py-2 rounded transition">Pay ₹<?php echo number_format($total_amount, 2); ?> with Card</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        function showTab(tabId) {
            document.querySelectorAll('.payment-tab').forEach(tab => tab.classList.add('hidden'));
            document.getElementById(tabId).classList.remove('hidden');

            // Update tab buttons styling
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-[#3B8A9C]', 'text-white');
                btn.classList.add('bg-gray-200', 'text-[#3B8A9C]');
            });

            const activeBtnId = tabId + "Btn";
            document.getElementById(activeBtnId).classList.remove('bg-gray-200', 'text-[#3B8A9C]');
            document.getElementById(activeBtnId).classList.add('bg-[#3B8A9C]', 'text-white');
        }

        function openPaymentModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
            gsap.from("#paymentModal > div", {
                scale: 0.8,
                opacity: 0,
                duration: 0.5,
                ease: "back.out(1.7)"
            });
        }

        function closePaymentModal() {
            gsap.to("#paymentModal > div", {
                scale: 0.8,
                opacity: 0,
                duration: 0.3,
                ease: "power1.in",
                onComplete: () => {
                    document.getElementById('paymentModal').classList.add('hidden');
                }
            });
        }

        function handlePayment(e) {
            e.preventDefault();

            const tabs = {
                cardTab: 'Card',
                upiTab: 'UPI',
                debitTab: 'Debit/Credit'
            };

            let paymentMethod = null;
            let address = "N/A";

            for (const [tabId, method] of Object.entries(tabs)) {
                const tab = document.getElementById(tabId);
                if (!tab.classList.contains('hidden')) {
                    paymentMethod = method;
                    const addressInput = tab.querySelector('input[placeholder="Address"]');
                    if (addressInput) address = addressInput.value || "N/A";
                    break;
                }
            }

            if (!paymentMethod) {
                Swal.fire({
                    title: "Select Payment Method",
                    text: "Please select a valid payment method.",
                    icon: "warning",
                    confirmButtonColor: "#3B8A9C"
                });
                return;
            }

            console.log({
                paymentMethod: paymentMethod,
                totalAmount: <?php echo $total_amount; ?>,
                address: address
            });

            const formData = new FormData();
            formData.append('payment_method', paymentMethod);
            formData.append('total_amount', <?php echo $total_amount; ?>);
            formData.append('address', address);

            fetch('/FULLSTACK_PROJECT/order/place_order.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                console.log(data);
                if (data.includes('Order placed successfully')) {
                    Swal.fire({
                        title: "Success",
                        text: "Your order has been placed successfully!",
                        icon: "success",
                        confirmButtonColor: '#3B8A9C'
                    }).then(() => {
                        window.location.href = '/FULLSTACK_PROJECT/order/order.php';
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Something went wrong. Please try again.",
                        icon: "error",
                        confirmButtonColor: "#3B8A9C"
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    title: "Error",
                    text: "Something went wrong. Please try again.",
                    icon: "error",
                    confirmButtonColor: "#3B8A9C"
                });
            });
        }

        function removeFromCart(cartId) {
            fetch('/FULLSTACK_PROJECT/cart/remove_from_cart.php', {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "cart_id=" + encodeURIComponent(cartId)
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: data.status,
                    text: data.message,
                    icon: data.icon,
                    confirmButtonColor: "#3B8A9C"
                }).then(() => {
                    location.reload();
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

        gsap.from(".animate-fadein", {
            opacity: 0,
            y: 50,
            duration: 1,
            ease: "power3.out",
            stagger: 0.2
        });
    </script>

</body>
</html>

<?php $conn->close(); ?>