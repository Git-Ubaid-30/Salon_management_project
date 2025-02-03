<?php
include('query.php');
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">


<!-- Mirrored from template.hasthemes.com/brancy/brancy/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 25 Oct 2024 16:28:24 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Brancy - Cosmetic & Beauty Salon Website Template</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="Brancy - Cosmetic & Beauty Salon Website Template">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords"
        content="bootstrap, ecommerce, ecommerce html, beauty, cosmetic shop, beauty products, cosmetic, beauty shop, cosmetic store, shop, beauty store, spa, cosmetic, cosmetics, beauty salon" />
    <meta name="author" content="codecarnival" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/web-favicon.png">


    <!-- CSS (Font, Vendor, Icon, Plugins & Style CSS files) -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Font CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS (Bootstrap & Icon Font) -->
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="admin/assets/css/vendor/material-design-iconic-font.min.css">

    <!-- Plugins CSS (All Plugins Files) -->
    <link rel="stylesheet" href="assets/css/plugins/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/plugins/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/plugins/fancybox.min.css">
    <link rel="stylesheet" href="assets/css/plugins/nice-select.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/css/feedback.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/animation.css">
    <link rel="stylesheet" href="assets/css/style.min.css">

</head>

<style>
    .header-logo {
        padding-left: 10px;
        /* Adjust this value as needed for desired left padding */
        margin: 0;
        /* Keep margin adjustments if necessary */
    }

    .header-logo img.logo-main {
        width: 112px;
        /* Set to your desired width */
        height: auto;
        /* Maintain aspect ratio */
        max-width: none;
        /* Ensure it doesn't scale down */
        margin-left: 7px;
        margin-top: 5px;
    }

    .header-action-btn {
        margin-right: 10px;
        /* Adjust the right margin to add space between the cart icon and the user profile */
    }

    .user-buttons {
        margin-left: 10px;
        /* Add a margin to the left of the user button to ensure some space */
    }
</style>

<body>

    <!--== Wrapper Start ==-->
    <div class="wrapper">

        <!--== Start Header Wrapper ==-->
        <header class="header-area sticky-header header-transparent ">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-5 col-lg-3 col-xl-1"> <!-- Adjust the column width here -->
                        <div class="header-logo custom">
                            <a href="index.php">
                                <img class="logo-main" src="assets/images/website-logo-1.png" alt="">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-7 col-xl-7 d-none d-lg-block">
                        <div class="header-navigation ps-7">
                            <ul class="main-nav justify-content-start">
                                <li class="has-submenu"><a href="index.php">Home</a></li>
                                <li><a href="about.php">About</a></li>
                                <li><a href="product.php">Shop</a></li>
                                <li><a href="service.php">Services</a></li>
                                <li><a href="contact.php">Contact</a></li>
                                <li><a href="feedback.php">Feedback</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-7 col-lg-3 col-xl-4">
                        <div class="header-action justify-content-end">
                            <button class="header-action-btn" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#AsideOffcanvasCart" aria-controls="AsideOffcanvasCart">
                                <span class="icon">
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <rect class="icon-rect" width="30" height="30" fill="url(#pattern2)" />
                                        <defs>
                                            <pattern id="pattern2" patternContentUnits="objectBoundingBox" width="1"
                                                height="1">
                                                <use xlink:href="#image0_504:9" transform="scale(0.0333333)" />
                                            </pattern>
                                            <image id="image0_504:9" width="30" height="30"
                                                xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAABmJLR0QA/wD/AP+gvaeTAAABFUlEQVRIie2VMU7DMBSGvwAqawaYuAmKxCW4A1I5Qg4AA93KBbp1ZUVUlQJSVVbCDVhgzcTQdLEVx7WDQ2xLRfzSvzzb+d6zn2MYrkugBBYevuWsHKiFn2JBMwH8Bq6Aw1jgBwHOYwGlPgT4LDZ4I8BJDNiEppl034UEJ8DMAJ0DByHBACPgUYEugePQUKkUWAmnsaB/Ry/YO9aXCwlT72AdrqaWEohwBWxSwc8ReIVtYIr5bM5pXqO+Men7rozGlkVSv4lJj1WQfsbvXVkNVNk1eEK4ik9/yuwzAPhLh5iuU4jtftMDR4ZJJXChxTJ2H3zXGDgWc43/X2Wro8G81a8u2fXU2nXiLVAxvNIKuPGW/r/2SltF+a3Rkw4pmwAAAABJRU5ErkJggg==" />
                                        </defs>
                                    </svg>
                                </span>
                            </button>

                            <!-- Profile Dropdown Icon -->
                            <div class="user-buttons mr-4">
                                <?php if (isset($_SESSION["userName"]) && isset($_SESSION["userEmail"])): ?>
                                    <!-- Display user information if logged in -->
                                    <a class="toggle" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span class="user">
                                            <!-- Avatar with the first letter of the user name -->
                                            <span class="avatar"
                                                style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: #007bff; color: white; border-radius: 50%; font-size: 18px; font-weight: bold;">
                                                <?php
                                                // Display the first letter of the user's name or "G" if not set
                                                echo strtoupper(substr($_SESSION["userName"] ?? 'Guest', 0, 1));
                                                ?>
                                                <span class="status"></span>
                                            </span>
                                        </span>
                                    </a>

                                    <!-- Dropdown menu with smooth animation -->
                                    <div class="dropdown-menu dropdown-menu-right animate__animated animate__fadeIn"
                                        aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="user/user-profile.php"><i
                                                class="zmdi zmdi-account pr-1"></i>Profile</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="user_logout.php"><i
                                                class="zmdi zmdi-power pr-1"></i>Log Out</a>
                                    </div>





                                    <!-- Dropdown menu -->
                                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                                        <div class="user-info">
                                            <a href="user/user-profile.php" class="dropdown-item text-dark">Profile</a>
                                            <a href="user_logout.php" class="dropdown-item text-dark">Logout</a>
                                        </div>
                                    </div>

                                <?php else: ?>
                                    <!-- Display Login and Register buttons if not logged in -->
                                    <a href="login.php" class="text-dark" style="margin-right: 15px; margin-left: 15px;">
                                        <i class="zmdi zmdi-account pr-1"></i>Login
                                    </a>
                                    <a href="register.php" class="text-dark" style="margin-left: 15px;">
                                        <i class="zmdi zmdi-account pr-1"></i>Register
                                    </a>
                                <?php endif; ?>
                            </div>



                            <button class="header-menu-btn" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#AsideOffcanvasMenu" aria-controls="AsideOffcanvasMenu">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--== End Header Wrapper ==-->