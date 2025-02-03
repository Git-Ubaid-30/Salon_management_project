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

    .product-info {
        display: flex;
        flex-direction: column;
        /* Stack price under the header */

    }

    .product-header {
        display: flex;
        align-items: center;
        /* Align items vertically in the same line */
        justify-content: space-between;
        /* Space between name and rating */

    }

    .title {
        margin: 0;
        /* Remove default margin */
        padding: 0;
        /* Remove padding */
        font-size: 1.2em;
        /* Optional: Adjust font size for product name */
    }

    .product-rating {
        margin-left: 10px;
        /* Optional: Adjust space between product name and rating */
    }

    .prices {
        margin-top: 3px;
        /* Reduced space between product name and price */
    }

    .price {
        font-size: 1.2em;
        font-weight: bold;
        margin: 0;
        padding: 0;
    }
</style>
<main class="main-content">

    <!--== Start Hero Area Wrapper ==-->
    <section class="hero-slider-area position-relative">
        <div class="swiper hero-slider-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide hero-slide-item">
                    <div class="container">
                        <div class="row align-items-center position-relative">
                            <div class="col-12 col-md-6">
                                <div class="hero-slide-content">
                                    <div class="hero-slide-text-img"><img src="assets/images/slider/text-theme.webp"
                                            width="427" height="232" alt="Image"></div>
                                    <h2 class="hero-slide-title">CLEAN FRESH</h2>
                                    <p class="hero-slide-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit
                                        ut aliquam, purus sit amet luctus venenatis.</p>
                                    <a class="btn btn-border-dark" href="product.php">BUY NOW</a>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="hero-slide-thumb">
                                    <img src="assets/images/slider/slider1.webp" width="841" height="832" alt="Image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hero-slide-text-shape"><img src="assets/images/slider/text1.webp" width="70"
                            height="955" alt="Image"></div>
                    <div class="hero-slide-social-shape"></div>
                </div>
                <div class="swiper-slide hero-slide-item">
                    <div class="container">
                        <div class="row align-items-center position-relative">
                            <div class="col-12 col-md-6">
                                <div class="hero-slide-content">
                                    <div class="hero-slide-text-img"><img src="assets/images/slider/text-theme.webp"
                                            width="427" height="232" alt="Image"></div>
                                    <h2 class="hero-slide-title">Facial Cream</h2>
                                    <p class="hero-slide-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit
                                        ut aliquam, purus sit amet luctus venenatis.</p>
                                    <a class="btn btn-border-dark" href="product.php">BUY NOW</a>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="hero-slide-thumb">
                                    <img src="assets/images/slider/slider2.webp" width="841" height="832" alt="Image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hero-slide-text-shape"><img src="assets/images/slider/text1.webp" width="70"
                            height="955" alt="Image"></div>
                    <div class="hero-slide-social-shape"></div>
                </div>
            </div>
            <!--== Add Pagination ==-->
            <div class="hero-slider-pagination"></div>
        </div>
        <div class="hero-slide-social-media">
            <a href="https://www.instagram.com/" target="_blank" rel="noopener">
                <i class="fa fa-instagram" style="font-size: 30px; color: #E4405F;"></i>
            </a>
            <a href="https://www.facebook.com/" target="_blank" rel="noopener">
                <i class="fa fa-facebook" style="font-size: 30px; color: #3b5998;"></i>
            </a>
            <a href="https://wa.me/yourphonenumber" target="_blank" rel="noopener">
                <i class="fa fa-whatsapp" style="font-size: 30px; color: #25D366;"></i>
            </a>
        </div>

    </section>
    <!--== End Hero Area Wrapper ==-->

    <!--== Start Product Category Area Wrapper ==-->
    <section class="section-space pb-0">
        <div class="container">
            <div class="row g-3 g-sm-6">
                <?php
                // Define an array of background colors
                $bgColors = ['#FFEDB4', '#DFE4FF', '#FFEACC', '#FFDAE0', '#FFF3DA', '#E5F7C1'];

                // Fetch categories from the database
                $query = $pdo->query('SELECT * FROM categories');
                $categories = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <div class="row">
                    <?php foreach ($categories as $category): ?>
                        <?php
                        // Pick a random background color from the array
                        $bgColor = $bgColors[array_rand($bgColors)];
                        ?>
                        <div class="col-6 col-lg-4 col-lg-2 col-xl-2">
                            <!-- Start Product Category Item -->
                            <a href="product.php?category_id=<?php echo $category['id']; ?>" class="product-category-item"
                                style="background-color: <?php echo $bgColor; ?>;">
                                <img class="icon"
                                    src="admin/assets/images/<?php echo htmlspecialchars($category['image']); ?>" width="70"
                                    height="80" alt="Image-HasTech">
                                <h3 class="title"><?php echo htmlspecialchars($category['name']); ?></h3>
                            </a>
                            <!-- End Product Category Item -->
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>


        </div>
    </section>
    <!--== End Product Category Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="section-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Our Products</h2>
                        <p>Explore our curated selection of high-quality hair and skincare products. Elevate your beauty
                            routine with the best in the industry.</p>
                    </div>
                </div>
            </div>
            <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">
                <?php
                // Fetch products and their supplier quantities
                $query = $pdo->query('SELECT products.*, suppliers.product_qty AS supQty FROM products INNER JOIN suppliers ON products.supplier_id = suppliers.id LIMIT 6');
                $allProducts = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($allProducts as $product) {
                    $productRating = (int) $product['rating']; // Assuming rating is an integer from 1 to 5
                    $isOutOfStock = $product['supQty'] <= 0; // Check if product is out of stock
                    ?>
                    <div class="col-6 col-lg-4 mb-4 mb-sm-9">
                        <div class="product-item">
                            <div class="product-thumb">
                                <?php if (!$isOutOfStock): ?>
                                    <a class="d-block"
                                        href="product-details.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                                    <?php else: ?>
                                        <div class="d-block" style="cursor: not-allowed;">
                                        <?php endif; ?>
                                        <img src="assets/images/shop/<?php echo htmlspecialchars($product['image']); ?>"
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
                                    <button type="button" class="product-action-btn action-btn-cart"
                                        onclick="addToCart(<?php echo $product['id']; ?>)">
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
                                            href="product-details.php?id=<?php echo htmlspecialchars($product['id']); ?>"><?php echo htmlspecialchars($product['name']); ?></a>
                                    <?php else: ?>
                                        <span style="color: gray;"><?php echo htmlspecialchars($product['name']); ?></span>
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
                                    $<?php echo htmlspecialchars($product['price']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        </div>
        </div>
        <?php
        if (isset($_GET['p_id'])) {
            $productId = $_GET['p_id'];

            // Fetch product details along with supplier quantity
            $stmt = $pdo->prepare("SELECT products.*, suppliers.product_qty AS supQty FROM products INNER JOIN suppliers ON products.supplier_id = suppliers.id WHERE products.id = :id");
            $stmt->execute(['id' => $productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                $productId = $product['id'];
                $productName = $product['name'];
                $productPrice = $product['price'];
                $productImage = $product['image'];
                $productSupQty = $product['supQty']; // Use supplier's quantity
        
                // Ensure enough stock is available
                if ($productSupQty > 0) {
                    // Initialize the cart if not already
                    if (!isset($_SESSION['finalCart'])) {
                        $_SESSION['finalCart'] = [];
                    }

                    // Add or update the product in the cart
                    $productFound = false;
                    foreach ($_SESSION['finalCart'] as &$cartItem) {
                        if ($cartItem['p_id'] == $productId) {
                            $cartItem['p_qty'] += 1; // Increment quantity in the cart
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
                            'p_qty' => 1 // Start with 1 unit
                        ];
                    }

                    // Update supplier quantity
                    $updateQtyStmt = $pdo->prepare("UPDATE suppliers SET product_qty = product_qty - 1 WHERE id = :supplierId");
                    $updateQtyStmt->execute(['supplierId' => $product['supplier_id']]);

                    // Redirect back to the cart page
                    header("Location: product.php");
                    exit();
                }
            }
        }
        ?>
        <script>
            function addToCart(productId) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "index.php?p_id=" + productId, true);
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
    </section>

    <!--== End Product Area Wrapper ==-->

    <!--== Start Services Area Wrapper ==-->
    <section class="section-space pb-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Our Services</h2>
                        <p>Experience our curated range of beauty and wellness services tailored to help you look and
                            feel your best.</p>
                    </div>
                </div>
            </div>
            <div class="row mb-n9">
                <?php
                $query = $pdo->query("select * from services limit 3");
                $allServices = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($allServices as $service) {
                    ?>
                    <div class="col-sm-6 col-lg-4 mb-8">
                        <!--== Start Service Item ==-->
                        <div class="post-item">
                            <a href="service-detail.php?sId=<?php echo $service['id'] ?>" class="thumb">
                                <img src="admin/assets/images/<?php echo $service['image'] ?>" width="370" height="320"
                                    alt="Facial Service">
                            </a>
                            <div class="content">
                                <h4 class="title"><?php echo $service['name'] ?></h4>
                                <h4>$<?php echo $service['price'] ?></h4>
                            </div>
                        </div>
                        <!--== End Service Item ==-->
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <!--== End Services Area Wrapper ==-->

    <!--== Start Stylists Area Wrapper ==-->
    <section class="section-space pt-25">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Our Stylists</h2>
                        <p>Our experienced team of stylists brings a wealth of expertise, skill, and passion for beauty.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row mb-n9">
                <?php
                $query = $pdo->query("SELECT stylists.*, services.name as serName
                    FROM stylists
                    INNER JOIN services ON stylists.service_id = services.id limit 3");
                $allStylists = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($allStylists as $stylists) {
                    if ($stylists) {
                        $stylistsRating = (int) $stylists['rating']; // Ensure rating is an integer
                        ?>
                        <div class="col-sm-6 col-lg-4 mb-8">
                            <!--== Start Stylist Item ==-->
                            <div class="post-item">
                                <img src="admin/assets/images/<?php echo $stylists['image'] ?>" width="370" height="320"
                                    alt="Stylist Image">
                                <div class="content">
                                    <h4 class="title"><?php echo $stylists['name'] ?></h4>
                                    <p><?php echo $stylists['des'] ?></p>
                                    <ul class="meta">
                                        <li><span>Specialty:</span><?php echo $stylists['serName'] ?></li>
                                        <li><span>Rating:</span>
                                            <a style="color: #ff6565;">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <span class="star">
                                                        <i
                                                            class="fa <?php echo $i <= $stylistsRating ? 'fa-star filled' : 'fa-star-o empty'; ?>"></i>
                                                    </span>
                                                <?php endfor; ?>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="meta">
                                        <li><span>Contact_info:</span><?php echo $stylists['contact_info'] ?></li>
                                    </ul>
                                </div>


                            </div>
                            <!--== End Stylist Item ==-->
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <!--== End Stylists Area Wrapper ==-->


    <!--== Start News Letter Area Wrapper ==-->
    <section class="section-space pt-0">
        <div class="container">
            <div class="newsletter-content-wrap" data-bg-img="assets/images/photos/bg1.webp">
                <div class="newsletter-content">
                    <div class="section-title mb-0">
                        <h2 class="title">Our Beauty Community</h2>
                        <p>Stay connected with our exclusive beauty tips & services. Join us and let us bring out the
                            best in you!</p>
                    </div>
                </div>
                <div class="newsletter-form">
                    <div class="post-item">
                        <div class="content">
                            <a class="post-category" href="contact.php">Contact Us Today</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End News Letter Area Wrapper ==-->

</main>

<?php
include('components/footer.php');
?>