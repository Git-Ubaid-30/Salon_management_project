<?php
include('php/query.php');
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Adomx - Responsive Bootstrap 4 Admin Template</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png">

    <!-- CSS
    ============================================ -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="assets/css/vendor/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/css/vendor/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/vendor/themify-icons.css">
    <link rel="stylesheet" href="assets/css/vendor/cryptocurrency-icons.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins/plugins.css">

    <!-- Helper CSS -->
    <link rel="stylesheet" href="assets/css/helper.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="assets/css/style-primary.css">

</head>

<body class="skin-dark">

    <div class="main-wrapper">


        <!-- Header Section Start -->
        <div class="header-section">
            <div class="container-fluid">
                <div class="row justify-content-between align-items-center">

                    <!-- Header Logo (Header Left) Start -->
                    <div class="header-logo col-auto">
                        <a href="">
                            <img src="assets/images/logo/logo-web.png" height="110px" alt="">
                            <img src="assets/images/logo/logo-web.png" class="logo-light pt-10" alt="">
                        </a>
                    </div><!-- Header Logo (Header Left) End -->

                    <!-- Header Right Start -->
                    <div class="header-right flex-grow-1 col-auto">
                        <div class="row justify-content-between align-items-center">

                            <!-- Side Header Toggle & Search Start -->
                            <div class="col-auto">
                                <div class="row align-items-center">

                                    <!--Side Header Toggle-->
                                    <div class="col-auto"><button class="side-header-toggle"><i
                                                class="zmdi zmdi-menu"></i></button></div>

                                </div>
                            </div><!-- Side Header Toggle & Search End -->

                            <!-- Header Notifications Area Start -->
                            <div class="col-auto">

                                <ul class="header-notification-area">

                                    <!--User-->
                                    <li class="adomx-dropdown col-auto">
                                        <a class="toggle" href="#">
                                            <span class="user">
                                                <span class="avatar"
                                                    style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: #007bff; color: white; border-radius: 50%; font-size: 18px;">
                                                    <?php
                                                    if (isset($_SESSION["userName"])) {
                                                        // Display the first letter of the admin's name
                                                        echo strtoupper(substr($_SESSION["userName"], 0, 1));
                                                    } else {
                                                        echo "G"; // Default letter if name is not set
                                                    }
                                                    ?>
                                                    <span class="status"></span>
                                                </span>

                                                <span class="name">
                                                    <?php

                                                    if (isset($_SESSION["userName"])) {
                                                        echo htmlspecialchars($_SESSION["userName"]);
                                                    }


                                                    ?>
                                                </span>
                                            </span>
                                        </a>

                                        <!-- Dropdown -->
                                        <div class="adomx-dropdown-menu dropdown-menu-user">
                                            <div class="head">
                                                <h5 class="name"><a href="#">
                                                        <?php

                                                        if (isset($_SESSION["userName"])) {
                                                            echo $_SESSION["userName"];
                                                        }


                                                        ?>
                                                    </a></h5>
                                                <a class="mail" href="#">
                                                    <?php

                                                    if (isset($_SESSION["userEmail"])) {
                                                        echo $_SESSION["userEmail"];
                                                    }


                                                    ?>
                                                </a>
                                            </div>
                                            <div class="body">

                                                <ul>
                                                <li><a href="user-profile.php"><i
                                                class="zmdi zmdi-account"></i>Profile</a></li>
                                                    <li><a href="../index.php"><i class="zmdi zmdi-home"></i>Back to
                                                            website</a></li>
                                                    <li><a href="logout.php"><i class="zmdi zmdi-power"></i>logout</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                    </li>

                                </ul>

                            </div><!-- Header Notifications Area End -->

                        </div>
                    </div><!-- Header Right End -->

                </div>
            </div>
        </div><!-- Header Section End -->
        <!-- Side Header Start -->
        <div class="side-header show">
            <button class="side-header-close"><i class="zmdi zmdi-close"></i></button>
            <!-- Side Header Inner Start -->
            <div class="side-header-inner custom-scroll">

                <nav class="side-header-menu" id="side-header-menu">
                    <ul>

                        <li><a href="userInovice.php"><i class="zmdi zmdi-file"></i><span>Invoice</span></a></li>
                        <li><a href="viewAppointment.php"><i
                                    class="zmdi zmdi-calendar-check"></i><span>Appointments</span></a>
                        </li>
                        <li><a href="../index.php"><i class="zmdi zmdi-home"></i><span>Back To Website</span></a></li>


                    </ul>
                </nav>

            </div><!-- Side Header Inner End -->
        </div><!-- Side Header End -->