<style>
    .widget-about {
        text-align: center;
    }

    .widget-logo img {
        width: 150px;
        /* Adjust size as needed */
        height: auto;
        /* Keeps the aspect ratio */
        margin-right: 60px;
    }
</style>

<!--== Start Footer Area Wrapper ==-->
<footer class="footer-area">
    <!--== Start Footer Main ==-->
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="widget-item">
                        <div class="widget-about">
                            <a class="widget-logo" href="index.html">
                                <img src="assets/images/website-logo-1.png"
                                    alt="Logo">
                            </a>
                            <p class="desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                Lorem Ipsum has been.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 mt-md-0 mt-9">
                    <div class="widget-item">
                        <h4 class="widget-title">Information</h4>
                        <ul class="widget-nav">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="product.php">Shop</a></li>
                            <li><a href="service.php">Services</a></li>
                            <li><a href="contact.php">Contact</a></li>
                            <li><a href="feedback.php">Feedback</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mt-lg-0 mt-6">
                    <div class="widget-item">
                        <h4 class="widget-title">Social Info</h4>
                        <div class="widget-social">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== End Footer Main ==-->

    <!--== Start Footer Bottom ==-->
    <div class="footer-bottom">
        <div class="container pt-0 pb-0">
            <div class="footer-bottom-content">
                <p class="copyright">© 2024 Salon. Made with <i class="fa fa-heart"></i> by <a target="_blank"
                        href="index.php">Elegence Salon.</a></p>
            </div>
        </div>
    </div>
    <!--== End Footer Bottom ==-->
</footer>
<!--== End Footer Area Wrapper ==-->

<!--== Scroll Top Button ==-->
<div id="scroll-to-top" class="scroll-to-top"><span class="fa fa-angle-up"></span></div>

<aside class="product-action-modal modal fade" id="action-CartAddModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="product-action-view-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                    <div class="modal-action-messages">
                        <i class="fa fa-check-square-o"></i> Added to cart successfully!
                    </div>
                    <div class="modal-action-product">
                        <div class="thumb">
                            <img src="assets/images/shop/modal1.webp" alt="Organic Food Juice" width="466" height="320">
                        </div>
                        <h4 class="product-name"><a href="product-details.php">Readable content DX22</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
<!--== End Product Quick Add Cart Modal ==-->

<!--== Start Product Quick View Modal ==-->

<!--== End Product Quick View Modal ==-->

<!--== Start Aside Cart ==-->


<aside class="aside-cart-wrapper offcanvas offcanvas-end" tabindex="-1" id="AsideOffcanvasCart"
    aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h1 class="d-none" id="offcanvasRightLabel">Shopping Cart</h1>
        <button class="btn-aside-cart-close" data-bs-dismiss="offcanvas" aria-label="Close">Shopping Cart <i
                class="fa fa-chevron-right"></i></button>
    </div>
    <div class="offcanvas-body">
        <ul class="aside-cart-product-list">
            <?php
            $totalAmount = 0;

            if (!empty($_SESSION['finalCart'])) {
                foreach ($_SESSION['finalCart'] as $item) {
                    // Calculate subtotal for each item
                    $itemSubtotal = $item['p_price'] * $item['p_qty'];
                    $totalAmount += $itemSubtotal;

                    echo '
                <li class="aside-product-list-item">
                    <a href="product.php">
 <img src="assets/images/shop/' . htmlspecialchars($item['p_image']) . '" width="68" height="84" alt="Image-HasTech">                        <span class="product-title">' . htmlspecialchars($item['p_name']) . '</span>
                    </a>
                    <span class="product-price">' . $item['p_qty'] . ' × $' . number_format($item['p_price'], 2) . '</span>
                </li>';
                }
            } else {
                echo '<p>Your cart is empty.</p>';
            }
            ?>
        </ul>

        <p class="cart-total"><span>Total Products:</span><span
                class="amount"><?php echo count($_SESSION['finalCart'] ?? []); ?></span></p>
        <p class="cart-total"><span>Subtotal:</span><span
                class="amount">$<?php echo number_format($totalAmount, 2); ?></span></p>
        <a class="btn-total" href="product-cart.php">View cart</a>
        <a class="btn-total" href="product-checkout.php">Checkout</a>
    </div>

</aside>
<!--== End Aside Cart ==-->

<!--== Start Aside Menu ==-->
<aside class="off-canvas-wrapper offcanvas offcanvas-start" tabindex="-1" id="AsideOffcanvasMenu"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h1 class="d-none" id="offcanvasExampleLabel">Aside Menu</h1>
        <button class="btn-menu-close" data-bs-dismiss="offcanvas" aria-label="Close">menu <i
                class="fa fa-chevron-left"></i></button>
    </div>
    <div class="offcanvas-body">
        <div id="offcanvasNav" class="offcanvas-menu-nav">
            <ul>
                <li class="has-submenu"><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="product.php">Shop</a></li>
                <li><a href="service.php">Services</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="feedback.php">Feedback</a></li>
            </ul>
        </div>
    </div>
</aside>
<!--== End Aside Menu ==-->

</div>
<!--== Wrapper End ==-->

<!-- JS Vendor, Plugins & Activation Script Files -->

<!-- Vendors JS -->
<script src="assets/js/vendor/modernizr-3.11.7.min.js"></script>
<script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
<script src="assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
<script src="assets/js/jQuery/jquery-3.6.4.min.js"></script>
<script src="assets/js/vendor/bootstrap.bundle.min.js"></script>

<!-- Add Bootstrap CSS and JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Bootstrap 5 -->
<script src="assets/js/bootstrap/bootstrap.min.js"></script>

<!-- Plugins JS -->
<script src="assets/js/plugins/swiper-bundle.min.js"></script>
<script src="assets/js/plugins/fancybox.min.js"></script>
<script src="assets/js/plugins/jquery.nice-select.min.js"></script>

<!-- Custom Main JS -->
<script src="assets/js/main.js"></script>

</body>


<!-- Mirrored from template.hasthemes.com/brancy/brancy/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 25 Oct 2024 16:28:24 GMT -->

</html>

<!--== Start Footer Area Wrapper ==-->