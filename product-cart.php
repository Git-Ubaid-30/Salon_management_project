<?php
include('components/header.php');

?>

<!--  addtocart  dynamic work start -->

<?php
if (isset($_POST["addToCart"])) {
    // Retrieve product details from POST request
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productImage = $_POST['productImage'];
    $quantity = $_POST['num-product']; // Quantity added by the user

    // Fetch supplier ID for the product
    $stmt = $pdo->prepare("SELECT supplier_id FROM products WHERE id = :pId");
    $stmt->bindParam(':pId', $productId, PDO::PARAM_INT);
    $stmt->execute();
    $productData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($productData) {
        $supplierId = $productData['supplier_id'];

        // Deduct the purchased quantity from the product's stock
        $stmt = $pdo->prepare("UPDATE products SET qty = qty - :qty WHERE id = :productId");
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':qty', $quantity, PDO::PARAM_INT);
        $stmt->execute();

        // Deduct the purchased quantity from the supplier's stock
        $stmt = $pdo->prepare("UPDATE suppliers SET product_qty = product_qty - :qty WHERE id = :supplierId");
        $stmt->bindParam(':supplierId', $supplierId, PDO::PARAM_INT);
        $stmt->bindParam(':qty', $quantity, PDO::PARAM_INT);
        $stmt->execute();

        // Add the product to the cart (Session variable `finalCart`)
        if (isset($_SESSION["finalCart"])) {
            // Check if the product is already in the cart
            $productIdsArray = array_column($_SESSION['finalCart'], 'p_id');
            $productIndex = array_search($productId, $productIdsArray);

            if ($productIndex !== false) {
                // Update the quantity if the product is already in the cart
                $_SESSION['finalCart'][$productIndex]['p_qty'] += $quantity;
                echo '<script>
                    Swal.fire({
                        title: "Success!",
                        text: "Product quantity updated in cart.",
                        icon: "success",
                        color: "#6b4e3d",
                        background: "#f5e6e0",
                        confirmButtonText: "Ok"
                    });
                </script>';
            } else {
                // Add the product to the cart if it's not already there
                $_SESSION['finalCart'][] = array(
                    'p_id' => $productId,
                    'p_name' => $productName,
                    'p_price' => $productPrice,
                    'p_image' => $productImage,
                    'p_qty' => $quantity
                );
                echo '<script>
                    Swal.fire({
                        title: "Success!",
                        text: "Product added to cart successfully.",
                        icon: "success",
                        color: "#6b4e3d",
                        background: "#f5e6e0",
                        confirmButtonText: "Continue Shopping"
                    });
                </script>';
            }
        } else {
            // If the cart doesn't exist, create it and add the product
            $_SESSION['finalCart'] = array();
            $_SESSION['finalCart'][] = array(
                'p_id' => $productId,
                'p_name' => $productName,
                'p_price' => $productPrice,
                'p_image' => $productImage,
                'p_qty' => $quantity
            );
            echo '<script>
                Swal.fire({
                    title: "Success!",
                    text: "Product added to cart successfully.",
                    icon: "success",
                    color: "#6b4e3d",
                    background: "#f5e6e0",
                    confirmButtonText: "Continue Shopping"
                });
            </script>';
        }
    } else {
        // Handle case where product is not found
        echo '<script>
            Swal.fire({
                title: "Error!",
                text: "Product not found.",
                icon: "error",
                color: "#6b4e3d",
                background: "#f5e6e0",
                confirmButtonText: "Ok"
            });
        </script>';
    }
}
?>





<!--  addtocart  dynamic work end -->


<!--  cart remove dynamic work start -->

<?php
if (isset($_GET['cartRemove'])) {
    $productId = $_GET['cartRemove'];

    // Check if the cart session exists
    if (isset($_SESSION['finalCart'])) {
        // Loop through the cart session and find the product to remove
        foreach ($_SESSION['finalCart'] as $key => $value) {
            if ($value['p_id'] == $productId) {
                // Store the quantity to be returned to the database
                $productQuantityInCart = $value['p_qty'];

                // Remove the product from the cart session
                unset($_SESSION['finalCart'][$key]);

                // Re-index the session array to avoid gaps after removal
                $_SESSION['finalCart'] = array_values($_SESSION['finalCart']);

                // Update the product quantity in the 'products' table
                // Assuming you have a PDO connection established as $pdo
                $stmt = $pdo->prepare("UPDATE products SET qty = qty + :productQuantityInCart WHERE id = :productId");
                $stmt->bindParam(':productQuantityInCart', $productQuantityInCart, PDO::PARAM_INT);
                $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);

                // Execute the query for the 'products' table
                $stmt->execute();

                // Now update the supplier quantity based on the 'supplier_id' in the 'products' table
                // Get the supplier_id of the product
                $stmt_supplier = $pdo->prepare("SELECT supplier_id FROM products WHERE id = :productId");
                $stmt_supplier->bindParam(':productId', $productId, PDO::PARAM_INT);
                $stmt_supplier->execute();
                $supplier = $stmt_supplier->fetch(PDO::FETCH_ASSOC);

                if ($supplier) {
                    // Update the supplier's quantity in the 'suppliers' table based on supplier_id
                    $supplierId = $supplier['supplier_id'];
                    $stmt_update_supplier = $pdo->prepare("UPDATE suppliers SET product_qty = product_qty + :productQuantityInCart WHERE id = :supplierId");
                    $stmt_update_supplier->bindParam(':productQuantityInCart', $productQuantityInCart, PDO::PARAM_INT);
                    $stmt_update_supplier->bindParam(':supplierId', $supplierId, PDO::PARAM_INT);
                    // Execute the query to update the supplier's quantity
                    $stmt_update_supplier->execute();
                    echo '<script>Swal.fire("Product Removed", "The product has been successfully removed from your cart.", "success");</script>';
                } else {
                    // If no supplier found for the product, you can log an error or handle this case as needed
                    // echo '<script>alert("Supplier not found for this product.")</script>';
                }

                // Exit the loop once the product is removed and stock updated
                break;
            }
        }
    }
}
?>

<!--  cart remove dynamic work end -->


<!--  qty dynamic work start -->

<?php
if (isset($_POST['updatedQtyInp'])) {
    $pId = $_POST['productId'];  // Get the product ID
    $pQty = $_POST['productQty']; // Get the updated quantity

    // Get the current quantity from the session
    $currentQty = 0;
    foreach ($_SESSION['finalCart'] as $key => $value) {
        if ($value['p_id'] == $pId) {
            $currentQty = $value['p_qty'];  // Store the current quantity from the session
            break;  // Exit the loop once we find the product
        }
    }

    // Calculate the difference in quantity
    $qtyDifference = $pQty - $currentQty;

    // Update the cart in the session
    foreach ($_SESSION['finalCart'] as $key => $value) {
        if ($value['p_id'] == $pId) {
            $_SESSION['finalCart'][$key]['p_qty'] = $pQty;  // Update quantity in session
            break;  // Break once we find and update the product
        }
    }

    // Make sure the database connection is established correctly
    try {
        // Get the supplier_id from the products table
        $stmt = $pdo->prepare("SELECT supplier_id FROM products WHERE id = :pId");
        $stmt->execute([':pId' => $pId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if supplier_id is found
        if ($product) {
            $supplierId = $product['supplier_id'];

            // Update the supplier's stock in the suppliers table (adjust quantity based on the difference)
            $stmt = $pdo->prepare("UPDATE suppliers 
                                   SET product_qty = product_qty - :qtyDifference 
                                   WHERE id = :supplierId");
            $stmt->execute([
                ':qtyDifference' => $qtyDifference,  // The difference in quantity
                ':supplierId' => $supplierId  // The supplier ID from the products table
            ]);

            // Update the product's stock in the products table (adjust quantity based on the difference)
            $stmt = $pdo->prepare("UPDATE products
                                   SET qty = qty - :qtyDifference
                                   WHERE id = :pId");
            $stmt->execute([
                ':qtyDifference' => $qtyDifference,  // The difference in quantity
                ':pId' => $pId  // The product ID
            ]);

            // Check if the queries were successful
            if ($stmt->rowCount() > 0) {
                echo '<script>
                    Swal.fire({
                        title: "Success!",
                        text: "Supplier and product stock updated successfully.",
                        icon: "success",
                        color: "#6b4e3d",
                        background: "#f5e6e0",
                        confirmButtonText: "Ok"
                    });
                </script>';
            } else {
                echo '<script>
                    Swal.fire({
                        title: "Error!",
                        text: "No stock update was made for the product or supplier.",
                        icon: "error",
                        color: "#6b4e3d",
                        background: "#f5e6e0",
                        confirmButtonText: "Ok"
                    });
                </script>';
            }
        } else {
            echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "Product not found or product has no associated supplier.",
                    icon: "error",
                    color: "#6b4e3d",
                    background: "#f5e6e0",
                    confirmButtonText: "Ok"
                });
            </script>';
        }
    } catch (PDOException $e) {
        // Handle any database errors
        echo '<script>
            Swal.fire({
                title: "Error!",
                text: "Error updating supplier/product stock.",
                icon: "error",
                color: "#6b4e3d",
                background: "#f5e6e0",
                confirmButtonText: "Ok"
            });
        </script>' . $e->getMessage();;
    }
}
?>


<!-- qty dynamic work end -->

<!-- main work start here -->

<main class="main-content">

    <section class="section-space">
        <div class="container">
            <div class="shopping-cart-form table-responsive">
                <form action="#" method="post">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th class="product-thumbnail">Image</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-subtotal">Total</th>
                                <th class="product-remove">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($_SESSION['finalCart'])) {
                                foreach ($_SESSION['finalCart'] as $key => $value) {
                            ?>
                                    <tr class="tbody-item">
                                        <td class="product-thumbnail">
                                            <div class="thumb">
                                                <a href="single-product.html">
                                                    <img src="assets/images/shop/<?php echo $value['p_image'] ?>" width="68"
                                                        height="84" alt="Image-HasTech">
                                                </a>
                                            </div>
                                        </td>
                                        <td class="product-name">
                                            <a class="title" href="#"><?php echo $value['p_name'] ?></a>
                                        </td>
                                        <td class="product-price">
                                            <span class="price"
                                                data-price="<?php echo $value['p_price']; ?>"><?php echo $value['p_price']; ?></span>
                                        </td>
                                        <!-- Product Quantity -->
                                        <td class="product-quantity">
                                            <div class="pro-qty">
                                                <div class="dec qty-btn">-</div>
                                                <input name="num-product1" value="<?php echo max($value['p_qty'], 1); ?>"
                                                    min="1" data-product-id="<?php echo $value['p_id']; ?>"
                                                    data-product-price="<?php echo $value['p_price']; ?>"
                                                    class="quantity-input">
                                                <div class="inc qty-btn">+</div>
                                            </div>
                                        </td>

                                        <td class="product-subtotal"
                                            data-subtotal="<?php echo $value['p_price'] * $value['p_qty']; ?>">
                                            $<?php echo number_format($value['p_price'] * $value['p_qty'], 2); ?>
                                        </td>

                                        <td class="product-remove">
                                            <a class="remove" href="javascript:void(0);"
                                                onclick="confirmRemove(<?php echo $value['p_id']; ?>)">×</a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>

                    </table>
                </form>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="cart-totals-wrap">
                        <h2 class="title">Cart totals</h2>
                        <table>

                            <tbody>
                                <!-- Cart Total -->
                                <tr class="cart-subtotal">
                                    <th>Subtotal:</th>
                                    <?php
                                    $totalAmount = 0;
                                    if (isset($_SESSION['finalCart']) && !empty($_SESSION['finalCart'])) {
                                        foreach ($_SESSION['finalCart'] as $key => $value) {
                                            $totalAmount += $value['p_price'] * $value['p_qty'];
                                        }
                                    }
                                    ?>
                                    <td>
                                        <span class="amount" id="subtotal">
                                            $<?php echo number_format($totalAmount, 2); ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="shipping-totals">
                                    <th>Shipping</th>
                                    <td>
                                        <ul class="shipping-list">
                                            <li class="radio">
                                                <input type="radio" name="shipping" id="flat-rate" value="2.00" checked>
                                                <label for="flat-rate">Flat rate: <span>$2.00</span></label>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr class="order-total">
                                    <th>Total</th>
                                    <td>
                                        <span class="amount" id="total-amount">
                                            $<?php echo number_format($totalAmount + 2.00, 2); ?>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>

                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const updateCartTotals = () => {
                                        const subtotalElement = document.getElementById('subtotal');
                                        const totalElement = document.getElementById('total-amount');
                                        let subtotal = 0;

                                        document.querySelectorAll('.product-subtotal').forEach((item) => {
                                            const itemSubtotal = parseFloat(item.dataset.subtotal) || 0;
                                            subtotal += itemSubtotal;
                                        });

                                        const shipping = parseFloat(document.querySelector('input[name="shipping"]:checked')?.value || 0);
                                        subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
                                        totalElement.textContent = `$${(subtotal + shipping).toFixed(2)}`;
                                    };

                                    const updateProductSubtotal = (inputElement) => {
                                        const quantity = parseInt(inputElement.value) || 1;
                                        const productPrice = parseFloat(inputElement.dataset.productPrice) || 0;
                                        const row = inputElement.closest('tr');
                                        const productSubtotalElement = row.querySelector('.product-subtotal');
                                        const productSubtotal = productPrice * quantity;

                                        productSubtotalElement.dataset.subtotal = productSubtotal.toFixed(2);
                                        productSubtotalElement.textContent = `$${productSubtotal.toFixed(2)}`;
                                    };

                                    document.querySelectorAll('.qty-btn').forEach((button) => {
                                        button.addEventListener('click', (event) => {
                                            const isIncrement = event.target.classList.contains('inc');
                                            const isDecrement = event.target.classList.contains('dec');
                                            const inputField = event.target.closest('.pro-qty').querySelector('.quantity-input');
                                            let quantity = parseInt(inputField.value) || 1;

                                            if (isIncrement) {
                                                quantity += 1;
                                            } else if (isDecrement && quantity > 1) {
                                                quantity -= 1;
                                            }

                                            inputField.value = quantity;
                                            updateProductSubtotal(inputField);
                                            updateCartTotals();
                                        });
                                    });

                                    document.querySelectorAll('.quantity-input').forEach((input) => {
                                        input.addEventListener('input', (event) => {
                                            const value = parseInt(event.target.value) || 1;
                                            event.target.value = value; // Ensure valid number
                                            updateProductSubtotal(event.target);
                                            updateCartTotals();
                                        });
                                    });

                                    document.querySelectorAll('input[name="shipping"]').forEach((radio) => {
                                        radio.addEventListener('change', () => {
                                            updateCartTotals();
                                        });
                                    });

                                    // Initial total calculation
                                    updateCartTotals();
                                });
                            </script>

                        </table>

                        <div class="text-end">
                            <?php
                            // Check if the cart has items
                            $cartIsEmpty = empty($_SESSION['finalCart']) || count($_SESSION['finalCart']) === 0;

                            if ($cartIsEmpty): ?>
                                <!-- Disabled button when cart is empty -->
                                <button class="checkout-button btn btn-secondary" disabled>
                                    No products in the cart
                                </button>
                            <?php else: ?>
                                <?php if (isset($_SESSION['userEmail'])): ?>
                                    <!-- Proceed to checkout for logged-in users -->
                                    <button id="checkoutBtn" class="checkout-button btn btn-success"
                                        onclick="window.location.href='product-checkout.php';">
                                        Proceed to checkout
                                    </button>
                                <?php else: ?>
                                    <!-- Redirect to login for non-logged-in users -->
                                    <button onclick="window.location.href='login.php';" class="checkout-button btn btn-primary">
                                        Proceed to checkout
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    $(document).ready(function() {
        // Function to update the subtotal of a product
        function updateSubtotal(element) {
            var qty = parseInt($(element).val());
            var unitPrice = parseFloat($(element).data('product-price'));

            if (!isNaN(qty) && !isNaN(unitPrice)) {
                var newSubtotal = qty * unitPrice;

                // Update the displayed subtotal
                $(element).closest('tr').find('.product-subtotal').text('$' + newSubtotal.toFixed(2));
                $(element).closest('tr').find('.product-subtotal').attr('data-subtotal', newSubtotal.toFixed(2));

                // Update the cart totals after updating a single product's subtotal
                updateCartTotal();
            }
        }

        // Increase quantity by 1
        $('.inc').click(function() {
            var qtyInput = $(this).siblings('.quantity-input');
            var currentQty = parseInt(qtyInput.val());
            qtyInput.val(currentQty + 1);
            updateSubtotal(qtyInput);
        });

        // Decrease quantity by 1
        $('.dec').click(function() {
            var qtyInput = $(this).siblings('.quantity-input');
            var currentQty = parseInt(qtyInput.val());
            if (currentQty > 1) { // Prevent quantity from going below 1
                qtyInput.val(currentQty - 1);
                updateSubtotal(qtyInput);
            }
        });

        // Update the subtotal when the input value changes (if entered manually)
        $('.quantity-input').on('input', function() {
            updateSubtotal(this);
        });

        // Function to update the cart total
        function updateCartTotal() {
            var totalAmount = 0;
            $('.product-subtotal').each(function() {
                var subtotal = parseFloat($(this).attr('data-subtotal'));
                if (!isNaN(subtotal)) {
                    totalAmount += subtotal;
                }
            });

            // Update the subtotal displayed on the page
            $('#subtotal').text('$' + totalAmount.toFixed(2));

            // Shipping cost (add flat rate or other logic here)
            const shippingCost = 2.00; // Flat rate shipping cost for example
            const totalWithShipping = totalAmount + shippingCost;
            $('#total-amount').text('$' + totalWithShipping.toFixed(2));
        }

        // Initialize the cart total when the page loads
        updateCartTotal();
    });
</script>

<!-- main work end here -->

<?php

include('components/footer.php');
?>
<script>
    $(document).ready(function() {
        // Increment button functionality
        $(document).on('click', '.inc', function() {
            let productQtyInput = $(this).closest('.pro-qty').find('input[name="num-product1"]');
            let currentQty = parseInt(productQtyInput.val()); // Get the current quantity
            let productId = productQtyInput.data('product-id'); // Get the product ID

            if (!isNaN(currentQty)) {
                let updatedQty = currentQty; // Increment the quantity
                productQtyInput.val(updatedQty); // Update the input field value
                qtyIncDec(productId, updatedQty); // Send updated quantity to the server
                updateTotal($(this), updatedQty); // Update the total on the page
            }
        });

        // Decrement button functionality
        $(document).on('click', '.dec', function() {
            let productQtyInput = $(this).closest('.pro-qty').find('input[name="num-product1"]');
            let currentQty = parseInt(productQtyInput.val()); // Get the current quantity
            let productId = productQtyInput.data('product-id'); // Get the product ID

            if (!isNaN(currentQty) && currentQty > 1) { // Ensure quantity doesn't go below 1
                let updatedQty = currentQty; // Decrement the quantity
                productQtyInput.val(updatedQty); // Update the input field value
                qtyIncDec(productId, updatedQty); // Send updated quantity to the server
                updateTotal($(this), updatedQty); // Update the total on the page
            }
        });

        // Function to send updated quantity to the server via AJAX
        function qtyIncDec(pId, pQty) {
            $.ajax({
                url: 'product-cart.php', // URL to the PHP file for handling updates
                type: 'POST',
                data: {
                    "updatedQtyInp": true,
                    "productId": pId,
                    "productQty": pQty
                },
                success: function(response) {
                    // Optional: Handle the success response, e.g., refresh totals or display a success message
                    console.log("Quantity updated successfully");
                    console.log(response); // Log the response from the server for debugging
                },
                error: function(xhr, status, error) {
                    console.error("Error updating quantity:", error);
                }
            });
        }

        // Function to update the total price based on updated quantity
        function updateTotal(element, qty) {
            let price = parseFloat(element.closest('.table_row').find('.column-3').text()); // Get the product price
            let totalAmount = element.closest('.table_row').find('.column-5'); // Total price cell
            let total = price * qty;
            totalAmount.text(total.toFixed(2)); // Update the total with proper formatting
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Function to update the subtotal
        function updateSubtotal(element) {
            var qty = parseInt($(element).val());
            var unitPrice = parseFloat($(element).data('product-price'));
            var newSubtotal = qty * unitPrice;

            $(element).closest('tr').find('.product-subtotal').text('$' + newSubtotal.toFixed(2));
            $(element).closest('tr').find('.product-subtotal').attr('data-subtotal', newSubtotal.toFixed(2));
        }

        // Increase quantity by 1
        $('.inc').click(function() {
            var qtyInput = $(this).siblings('.quantity-input');
            var currentQty = parseInt(qtyInput.val());
            qtyInput.val(currentQty);
            updateSubtotal(qtyInput);
        });

        // Decrease quantity by 1
        $('.dec').click(function() {
            var qtyInput = $(this).siblings('.quantity-input');
            var currentQty = parseInt(qtyInput.val());
            if (currentQty > 1) { // Prevent decreasing below 1
                qtyInput.val(currentQty);
                updateSubtotal(qtyInput);
            }
        });

        // Update the subtotal when the input value changes (if entered manually)
        $('.quantity-input').on('input', function() {
            updateSubtotal(this);
        });
    });
</script>

<!-- ================================remove -->

<script>
    function confirmRemove(productId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            color: "#6b4e3d",
            background: "#f5e6e0",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, remove it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to PHP removal script with product ID
                window.location.href = "?cartRemove=" + productId;
            }
        });
    }
</script>