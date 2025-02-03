<?php
include('components/header.php');
?>


<style>
    .nav {
        margin-top: 130px;
    }
</style>
<style>
    /* Style for the search container */
    .search-container {
        max-width: 400px;
        margin: 20px auto;
    }

    .search-container h4.title {
        font-size: 20px;
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }

    /* Style for the search box with an icon */
    .search-box {
        position: relative;
        width: 100%;
    }

    #productSearch {
        width: 100%;
        padding: 12px 40px 12px 20px;
        /* Extra padding on right for icon */
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 25px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    #productSearch:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
    }

    /* Style for the search icon */
    .search-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        color: #aaa;
        pointer-events: none;
        /* Icon should not be clickable */
    }

    /* Product Card Animation */
    .product-item {
        opacity: 0;
        transform: scale(0.95);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    /* Fade-in and scale animation when card is visible */
    .product-item.visible {
        opacity: 1;
        transform: scale(1);
    }
</style>

<main class="main-content">

    <!--== Start Page Header Area Wrapper ==-->
    <section class="page-header-area pt-10 pb-9  nav" data-bg-color="#FFF3DA">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="page-header-st3-content text-center text-md-start">
                        <h2 class="page-header-title mt-4">All Products</h2>
                    </div>
                </div>
                <div class="search-container">
                    <div class="search-box">
                        <input type="text" id="productSearch" placeholder="Search for products..."
                            onkeyup="searchProducts(this.value)">
                        <span class="search-icon">&#128269;</span>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Shop Top Bar Area Wrapper ==-->
    <div class="shop-top-bar-area">
        <div class="container">
            <div class="shop-top-bar">

            </div>
        </div>
    </div>
    <!--== End Shop Top Bar Area Wrapper ==-->

    <!--== Start Product Category Area Wrapper ==-->
    <section class="section-space pb-0">
        <div class="container">
            <div class="row g-3 g-sm-6">
                <?php
                $bgColors = ['#FFEDB4', '#DFE4FF', '#FFEACC', '#FFDAE0', '#FFF3DA', '#E5F7C1'];
                $query = $pdo->query('SELECT * FROM categories');
                $categories = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div class="row">
                    <?php foreach ($categories as $category): ?>
                        <?php $bgColor = $bgColors[array_rand($bgColors)]; ?>
                        <div class="col-6 col-lg-4 col-lg-2 col-xl-2">
                            <a href="javascript:void(0);" onclick="searchProducts('', <?php echo $category['id']; ?>)"
                                class="product-category-item" style="background-color: <?php echo $bgColor; ?>;">
                                <img class="icon"
                                    src="admin/assets/images/<?php echo htmlspecialchars($category['image']); ?>" width="70"
                                    height="80" alt="Image-HasTech">
                                <h3 class="title"><?php echo htmlspecialchars($category['name']); ?></h3>
                            </a>
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
            <div id="productResults" class="row">
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
            </div>

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
            <!-- Product results will be dynamically loaded here -->
        </div>
        </div>
    </section>
    <!--== End Product Area Wrapper ==-->

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


<!-- product page search work start here -->
<script>
    let currentCategoryId = 0; // Track the selected category ID

    function searchProducts(query = '', categoryId = 0) {
        // If a new category is selected, update the current category ID
        if (categoryId) {
            currentCategoryId = categoryId;
        }

        // Use currentCategoryId for filtering, even if only a query is provided
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('category_id', currentCategoryId || 0); // Default to 0 if no category
        urlParams.set('query', query);

        // Push the URL state to reflect search parameters
        window.history.pushState(null, '', '?' + urlParams.toString());

        // Send AJAX request to fetch filtered products
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "search_products.php?" + urlParams.toString(), true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById("productResults").innerHTML = xhr.responseText;
                animateCards();
            }
        };
        xhr.send();
    }

    // Initial load, using the last selected category or default
    searchProducts();

    // Function to animate cards on load or scroll
    function animateCards() {
        const cards = document.querySelectorAll('.product-item');
        cards.forEach(card => {
            const cardPosition = card.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            if (cardPosition < windowHeight - 50) {
                card.classList.add('visible');
            }
        });
    }

    window.addEventListener('load', animateCards);
    window.addEventListener('scroll', animateCards);
</script>

<!-- product page search work end here -->