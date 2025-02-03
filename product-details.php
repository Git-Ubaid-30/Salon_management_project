<?php
include('components/header.php');
?>

<style>
    /* For the filled stars */
    .filled {
        color: #ff9393;
        /* Pinkish color for filled stars */
    }

    /* For the empty stars */
    .empty {
        color: #ccc;
        /* Light gray color for empty stars */
    }
</style>

<main class="main-content">
    <!--== Start Product Details Area Wrapper ==-->
    <section class="section-space">
        <div class="container">
            <div class="row product-details">
                <?php
                if (isset($_GET['id'])) {
                    $productsId = $_GET['id'];

                    // Query: Select product details and stock from products and suppliers
                    $query = $pdo->prepare("
        SELECT 
            products.id, 
            products.name, 
            products.price, 
            products.des, 
            products.image, 
            products.rating, 
            suppliers.product_qty AS supplier_stock 
        FROM 
            products 
        INNER JOIN 
            suppliers 
        ON 
            products.supplier_id = suppliers.id 
        WHERE 
            products.id = :pId
    ");
                    $query->bindParam(':pId', $productsId, PDO::PARAM_INT);
                    $query->execute();

                    $products = $query->fetch(PDO::FETCH_ASSOC);
                }

                // Check if the product exists
                if ($products) {
                    // Handle missing or null 'rating' with a default value of 0
                    $productRating = isset($products['rating']) ? (int) $products['rating'] : 0;
                    ?>
                    <div class="col-lg-6">
                        <div class="product-details-thumb">
                            <img src="assets/images/shop/<?php echo htmlspecialchars($products['image']); ?>" width="570"
                                height="693" alt="Product Image">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product-details-content">
                            <h5 class="product-details-collection">Product</h5>
                            <h3 class="product-details-title"><?php echo htmlspecialchars($products['name']); ?></h3>
                            <div class="product-details-review">
                                <div class="product-rating">
                                    <div class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="star">
                                                <i
                                                    class="fa <?php echo $i <= $productRating ? 'fa-star filled' : 'fa-star-o empty'; ?>"></i>
                                            </span>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2"><?php echo htmlspecialchars($products['des']); ?></p>

                            <h6 class="product-details-text">
                                <?php
                                if ($products['supplier_stock'] <= 0) {
                                    echo '<span style="color: red;">Out of Stock</span>';
                                } elseif ($products['supplier_stock'] < 5) {
                                    echo '<span style="color: orange;">Low in Stock</span> (' . $products['supplier_stock'] . ')';
                                } else {
                                    echo '<span style="color: green;">Available Stock:</span> ' . $products['supplier_stock'];
                                }
                                ?>
                            </h6>

                            <!-- Quantity Input Section -->
                            <div class="product-details-qty-list">
                                <form action="product-cart.php" method="post">
                                    <div class="pro-qty">
                                        <input type="number" name="num-product" value="1" min="1"
                                            max="<?php echo $products['supplier_stock']; ?>"
                                            data-product-id="<?php echo $products['id']; ?>" title="Quantity"
                                            class="qty-input">
                                    </div>
                                    <input type="hidden" name="productId" value="<?php echo $products['id']; ?>">
                                    <input type="hidden" name="productName"
                                        value="<?php echo htmlspecialchars($products['name']); ?>">
                                    <input type="hidden" name="productPrice" value="<?php echo $products['price']; ?>">
                                    <input type="hidden" name="productImage"
                                        value="<?php echo htmlspecialchars($products['image']); ?>">

                                    <div class="product-details-action">
                                        <h4 class="price">$<?php echo $products['price']; ?></h4>
                                        <div class="product-details-cart">
                                            <button type="submit" name="addToCart"
                                                class="btn ml-4 <?php echo $products['supplier_stock'] <= 0 ? 'btn-secondary' : 'btn-primary'; ?>"
                                                <?php echo $products['supplier_stock'] <= 0 ? 'disabled' : ''; ?>>
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    echo 'Product not found';
                }
                ?>
            </div>

        </div>
    </section>

    <!--== End Product Details Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="section-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="title">Random Products</h2>
                        <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit ut aliquam, purus sit
                            amet luctus venenatis</p>
                    </div>
                </div>
            </div>

            <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">
                <?php
                $query = $pdo->query('SELECT products.*, suppliers.product_qty as supQty FROM products INNER JOIN suppliers ON products.supplier_id = suppliers.id ORDER BY RAND() LIMIT 3');
                $allProducts = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($allProducts as $products) {
                    $productRating = (int) $products['rating']; // Assuming rating is an integer from 1 to 5
                    $isOutOfStock = $products['supQty'] <= 0; // Check if product is out of stock
                    ?>
                    <div class="col-6 col-lg-4 mb-4 mb-sm-9">
                        <div class="product-item">
                            <div class="product-thumb">
                                <?php if (!$isOutOfStock): ?>
                                    <a class="d-block"
                                        href="product-details.php?id=<?php echo htmlspecialchars($products['id']); ?>">
                                    <?php else: ?>
                                        <div class="d-block" style="cursor: not-allowed;">
                                        <?php endif; ?>
                                        <img src="assets/images/shop/<?php echo htmlspecialchars($products['image']); ?>"
                                            width="370" height="450" alt="Image-HasTech"
                                            style="<?php echo $isOutOfStock ? 'filter: grayscale(100%); opacity: 0.5;' : ''; ?>">
                                        <?php if (!$isOutOfStock): ?>
                                    </a>
                                <?php else: ?>
                                </div>
                            <?php endif; ?>

                            <div class="product-action">
                                <?php if ($isOutOfStock): ?>
                                    <button type="button" class="product-action-btn action-btn-cart"
                                        style="background-color: gray; cursor: not-allowed;" disabled>
                                        <span>Out of Stock</span>
                                    </button>
                                <?php else: ?>
                                    <!-- Add to Cart Button -->
                                    <button type="button" class="product-action-btn action-btn-cart"
                                        onclick="addToCart(<?php echo $products['id']; ?>)">
                                        <span>Add to cart</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="product-info">
                            <div class="product-header">
                                <h4 class="title">
                                    <?php if (!$isOutOfStock): ?>
                                        <a
                                            href="product-details.php?id=<?php echo htmlspecialchars($products['id']); ?>"><?php echo htmlspecialchars($products['name']); ?></a>
                                    <?php else: ?>
                                        <span style="color: gray;"><?php echo htmlspecialchars($products['name']); ?></span>
                                    <?php endif; ?>
                                </h4>
                                <div class="product-rating">
                                    <div class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="star">
                                                <i
                                                    class="fa <?php echo $i <= $productRating ? 'fa-star filled' : 'fa-star-o empty'; ?>"></i>
                                            </span>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="prices">
                                <span class="price" style="<?php echo $isOutOfStock ? 'color: gray;' : ''; ?>">
                                    $<?php echo htmlspecialchars($products['price']); ?>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
                }
                ?>
            <?php

            if (isset($_GET['p_id'])) {
                $productId = $_GET['p_id'];

                // Fetch product details from the database
                $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
                $stmt->execute(['id' => $productId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    $productId = $product['id'];
                    $productName = $product['name'];
                    $productPrice = $product['price'];
                    $productImage = $product['image'];
                    $productQuantity = 1; // Default to 1 for simplicity, you can modify based on input
            
                    // Initialize the cart if not already
                    if (!isset($_SESSION['finalCart'])) {
                        $_SESSION['finalCart'] = [];
                    }

                    // Check if the product is already in the cart
                    $productFound = false;
                    foreach ($_SESSION['finalCart'] as &$cartItem) {
                        if ($cartItem['p_id'] == $productId) {
                            $cartItem['p_qty'] += $productQuantity; // Increase quantity if already in cart
                            $productFound = true;
                            break;
                        }
                    }

                    // If product is not found in cart, add it
                    if (!$productFound) {
                        $_SESSION['finalCart'][] = [
                            'p_id' => $productId,
                            'p_name' => $productName,
                            'p_price' => $productPrice,
                            'p_image' => $productImage,
                            'p_qty' => $productQuantity
                        ];
                    }

                    // Redirect back to the cart page
                    header("Location: product-cart.php");
                    exit();
                }
            }
            ?>

        </div>

        <script>
            function addToCart(productId) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "product-details.php?p_id=" + productId, true);
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        // Use SweetAlert for feedback
                        Swal.fire({
                            title: 'Success!',
                            text: 'Product added to your cart.',
                            color: '#6b4e3d',
                            background: '#f5e6e0',
                            icon: 'success',
                            confirmButtonText: 'Continue Shopping',
                            timer: 2000, // Auto close after 2 seconds
                            timerProgressBar: true
                        });
                    }
                };
                xhr.send();
            }
        </script>

        </div>




        </div>
    </section>
    <!--== End Product Area Wrapper ==-->

    </div>
    </section>
    <!--== End Product Area Wrapper ==-->

</main>

<?php
include('components/footer.php');
?>

<script>
    var proQty = $(".pro-qty");
  proQty.append('<div class="dec qty-btn">-</div>');
  proQty.append('<div class="inc qty-btn">+</div>');

  $('.qty-btn').on('click', function (e) {
    e.preventDefault();
    var $button = $(this);
    var oldValue = $button.parent().find('input').val();
    if ($button.hasClass('inc')) {
      var newVal = parseFloat(oldValue) + 1;
    } else {
      if (oldValue > 1) {
        var newVal = parseFloat(oldValue) - 1;
      } else {
        newVal = 1;
      }
    }
    $button.parent().find('input').val(newVal);
  });
</script>