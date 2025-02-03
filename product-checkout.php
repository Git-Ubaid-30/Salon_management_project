<?php
include('components/header.php');
?>




<?php
$subtotal = 0;

if (!empty($_SESSION['finalCart'])) {
    foreach ($_SESSION['finalCart'] as $item) {
        $productTotal = $item['p_price'] * $item['p_qty'];
        $subtotal += $productTotal; // Accumulating the total
    }
}
$_SESSION['subtotal'] = $subtotal;

// Handle form submission
if (!empty($_POST)) {
    // Get billing details from the form
    $f_name = htmlspecialchars($_POST['f_name'] ?? '');
    $l_name = htmlspecialchars($_POST['l_name'] ?? '');
    $street_address = htmlspecialchars($_POST['street-address'] ?? '');
    $street_address2 = htmlspecialchars($_POST['street-address2'] ?? '');
    $town = htmlspecialchars($_POST['town'] ?? '');
    $postcode = htmlspecialchars($_POST['pz-code'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $order_notes = htmlspecialchars($_POST['order-notes'] ?? '');

    // Ensure that subtotal and shipping costs are set correctly
    $subtotal = $_SESSION['subtotal'] ?? 0;
    $flatRateShipping = 2.00;
    $shipping_cost = floatval($_POST['shipping'] ?? $flatRateShipping);
    $total_amount = $subtotal + $shipping_cost;

    // Payment method and order status
    $payment_method = $_POST['payment_method'] ?? '';
    $order_status = "Pending";

    // User details from session
    $user_id = $_SESSION['userId'] ?? '';
    $user_name = $_SESSION['userName'] ?? '';
    $user_email = $_SESSION['userEmail'] ?? '';

    // Check if the cart is empty
    if (empty($_SESSION['finalCart'])) {
        echo "<script>
        Swal.fire({
            title: 'Oops!',
            text: 'Your cart is empty!',
            color: '#6b4e3d',
            background: '#f5e6e0',
            icon: 'warning',
            confirmButtonText: 'Start Shopping'
        });
    </script>";
        exit;
    }

    // Database operations
    $pdo->beginTransaction();

    // Insert order details
    $orderQuery = "INSERT INTO orders (user_id, user_name, user_email, product_id, product_name, product_price, product_qty) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($orderQuery);

    foreach ($_SESSION['finalCart'] as $item) {
        $stmt->execute([
            $user_id,
            $user_name,
            $user_email,
            $item['p_id'],
            $item['p_name'],
            $item['p_price'],
            $item['p_qty']
        ]);
    }

    // Insert invoice details
    $invoiceQuery = "INSERT INTO invoice (first_name, last_name, street_address, street_address2, town, postcode, phone, email, order_notes, subtotal, shipping_cost, total_amount, payment_method, order_status) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $invoiceStmt = $pdo->prepare($invoiceQuery);
    $invoiceStmt->execute([
        $f_name,
        $l_name,
        $street_address,
        $street_address2,
        $town,
        $postcode,
        $phone,
        $email,
        $order_notes,
        $subtotal,
        $shipping_cost,
        $total_amount,
        $payment_method,
        $order_status
    ]);

    if ($pdo->commit()) {
        // Clear the cart after placing the order
        unset($_SESSION['finalCart']);
        $_SESSION['subtotal'] = 0;

        // Display success alert
        echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Order placed successfully!',
            icon: 'success',
            color: '#6b4e3d',
            background: '#f5e6e0',
            confirmButtonText: 'Go to Home'
        }).then(() => {
            window.location.href = 'index.php'; // Redirect to order summary page
        });
    </script>";
    } else {
        echo "<script>
        Swal.fire({
            title: 'Error!',
            text: 'Unable to process the order.',
            icon: 'error',
            color: '#6b4e3d',
            background: '#f5e6e0',
            confirmButtonText: 'Try Again'
        });
    </script>";
    }
}
?>

<!-- CSS to make inputs more attractive -->
<style>
    .shop-payment-method {
        margin: 20px 0;
    }

    .payment-option {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .payment-radio input[type="radio"] {
        display: none;
    }

    .payment-radio {
        position: relative;
        padding-left: 30px;
        cursor: pointer;
        font-size: 16px;
    }

    .payment-radio input[type="radio"]:checked+.radio-label {
        font-weight: bold;
    }

    .payment-radio .radio-label {
        position: relative;
        padding-left: 25px;
    }

    .payment-radio .radio-label::before {
        content: '';
        position: absolute;
        left: 0;
        top: 3px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid #007bff;
        background-color: #fff;
        transition: background 0.3s ease;
    }

    .payment-radio input[type="radio"]:checked+.radio-label::before {
        background-color: #007bff;
        border-color: #007bff;
    }

    /* Input fields styling */
    .card-details input {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    .card-details label {
        font-size: 14px;
        font-weight: bold;
        margin-top: 10px;
    }

    .card-details h4 {
        margin-top: 20px;
        font-size: 18px;
    }
</style>


<style>
    h2.title {
        font-size: 1.6rem;
        color: #333;
        margin-bottom: 15px;
    }

    /* Checkout Form Styles */
    .checkout-billing-details-wrap {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .checkout-billing-details-wrap label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .checkout-billing-details-wrap input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
    }

    /* Order Summary Styles */
    .checkout-order-details-wrap {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .table th,
    .table td {
        padding: 10px;
        text-align: left;
        font-size: 1rem;
    }

    .table th {
        background-color: #f1f1f1;
        font-weight: bold;
    }

    .table td {
        color: #555;
    }

    .table tfoot th {
        font-weight: bold;
    }

    /* Button Styles */
    .btn-place-order {
        color: black;
        background-color: #fe8282;
        color: white;
        padding: 15px 30px;
        border: none;
        border-radius: 5px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
    }

    .btn-place-order:hover {
        background-color: #fe8282;
    }

    /* Payment Methods */
    .shop-payment-method {
        margin-top: 20px;
    }

    .shop-payment-method label {
        display: block;
        font-size: 1.1rem;
        margin-bottom: 10px;
    }
</style>

<main class="main-content">

    <!--== Start Shopping Checkout Area Wrapper ==-->
    <section class="shopping-checkout-wrap section-space">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <!-- Billing Section -->
                    <div class="checkout-billing-details-wrap">
                        <h2 class="title">Billing Details</h2>
                        <form action="product-checkout.php" method="POST">
                            <div class="billing-form-wrap">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="f_name">First Name</label>
                                        <input type="text" id="f_name" name="f_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="l_name">Last Name</label>
                                        <input type="text" id="l_name" name="l_name" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="street-address">Street Address</label>
                                        <input type="text" id="street-address" name="street-address" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="town">Town / City</label>
                                        <input type="text" id="town" name="town" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="phone">Phone (Optional)</label>
                                        <input type="text" id="phone" name="phone">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="email">Email Address</label>
                                        <input type="email" id="email" name="email" required>
                                    </div>
                                </div>
                            </div>


                            <!-- Order Summary -->
                            <div class="checkout-order-details">
                                <h2>Your Order</h2>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="product-name">Product</th>
                                            <th class="product-total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $flatRateShipping = 2.00; // Shipping cost
                                        $subtotal = 0;

                                        if (!empty($_SESSION['finalCart'])) {
                                            foreach ($_SESSION['finalCart'] as $item) {
                                                $productTotal = $item['p_price'] * $item['p_qty'];
                                                $subtotal += $productTotal;
                                        ?>
                                                <tr>
                                                    <th class="product-name">
                                                        <?php echo htmlspecialchars($item['p_name']); ?>
                                                    </th>
                                                    <th class="product-name">
                                                        <?php echo (int) $item['p_qty']; ?>
                                                    </th>

                                                </tr>
                                            <?php }

                                            $totalAmount = $subtotal + $flatRateShipping; ?>
                                            <!-- Subtotal row -->
                                            <tr>
                                                <th>Subtotal:</th>
                                                <th id="subtotal">$<?php echo number_format($subtotal, 2); ?></td>
                                            </tr>
                                            <!-- Shipping row -->
                                            <tr>
                                                <th>Shipping:</th>
                                                <th id="shipping">$<?php echo number_format($flatRateShipping, 2); ?></th>
                                            </tr>
                                            <!-- Total row -->
                                            <tr>
                                                <th>Total:</th>
                                                <th id="total-amount">$<?php echo number_format($totalAmount, 2); ?></th>
                                            </tr>
                                        <?php } else { ?>
                                            <!-- Empty cart message -->
                                            <tr>
                                                <td colspan="2">Your cart is empty.</td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>


                                </table>
                            </div>






                            <!-- Payment Methods -->
                            <div class="shop-payment-method">
                                <h3>Select Payment Method</h3>
                                <div class="payment-option">
                                    <label class="payment-radio">
                                        <input type="radio" name="payment_method" value="Direct Bank Transfer" required>
                                        <span class="radio-label">Direct Bank Transfer</span>
                                    </label>
                                    <label class="payment-radio">
                                        <input type="radio" name="payment_method" value="Cash on Delivery" required>
                                        <span class="radio-label">Cash on Delivery</span>
                                    </label>
                                </div>

                                <!-- Card Details Input, hidden by default -->
                                <div id="card-details" class="card-details" style="display: none;">
                                    <h4>Card Details</h4>
                                    <label for="card-number">Card Number</label>
                                    <input type="text" id="card-number" name="card-number"
                                        placeholder="Enter card number">
                                    <label for="card-expiry">Expiry Date</label>
                                    <input type="text" id="card-expiry" name="card-expiry" placeholder="MM/YY">
                                    <label for="card-cvc">CVC</label>
                                    <input type="text" id="card-cvc" name="card-cvc" placeholder="CVC">
                                </div>
                            </div>


                            <!-- Submit Button -->
                            <button type="submit" class="btn-place-order text-white">Place Order</button>

                            <!-- JavaScript to show card details input when Direct Bank Transfer is selected -->
                            <script>
                                const radioButtons = document.querySelectorAll('input[name="payment_method"]');
                                const cardDetailsSection = document.getElementById('card-details');

                                radioButtons.forEach(radio => {
                                    radio.addEventListener('change', function() {
                                        if (this.value === 'Direct Bank Transfer') {
                                            cardDetailsSection.style.display = 'block';
                                        } else {
                                            cardDetailsSection.style.display = 'none';

                                        }

                                    });
                                });
                            </script>

                        </form>
                    </div>
                </div>
            </div>


        </div>
    </section>
    <!--== End Shopping Checkout Area Wrapper ==-->

</main>

<?php
include('components/footer.php');
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const subtotal = <?php echo $subtotal; ?>;
        const shippingOptions = document.querySelectorAll('input[name="shipping"]');
        const totalAmountElement = document.getElementById("total-amount");

        // Update total when shipping option is selected
        shippingOptions.forEach(option => {
            option.addEventListener("change", function() {
                const selectedShipping = parseFloat(option.value);
                const newTotal = subtotal + selectedShipping;
                totalAmountElement.textContent = `£${newTotal.toFixed(2)}`;
            });
        });

        // Handle Direct Bank Transfer visibility
        const bankInputContainer = document.getElementById("bank-input-container");
        const bankRadioButton = document.getElementById("flat-rate");

        bankInputContainer.style.display = "none"; // Initial state

        bankRadioButton.addEventListener("change", function() {
            if (this.checked) {
                bankInputContainer.style.display = "block"; // Show when selected
            } else {
                bankInputContainer.style.display = "none"; // Hide when not selected
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const subtotal = <?php echo $subtotal; ?>;
        const shippingOptions = document.querySelectorAll('input[name="shipping"]');
        const totalAmountElement = document.getElementById("total-amount");

        shippingOptions.forEach(option => {
            option.addEventListener("change", function() {
                const selectedShipping = parseFloat(option.value);
                const newTotal = subtotal + selectedShipping;
                totalAmountElement.textContent = `£${newTotal.toFixed(2)}`;
            });
        });
    });
</script>