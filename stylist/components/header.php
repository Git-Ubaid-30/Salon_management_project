<?php
include('php/query.php');


?>


<!doctype html>
<html class="no-js" lang="en">
<!-- Custom Form Styles -->



<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Elegence Salon - Stylist</title>
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


    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script.js"></script>

</head>

<body class="skin-dark">

    <div class="main-wrapper">


        <!-- Header Section Start -->
        <div class="header-section">
            <div class="container-fluid">
                <div class="row justify-content-between align-items-center">

                    <!-- Header Logo (Header Left) Start -->
                    <div class="header-logo col-auto">
                        <a href="index.php">
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
                                                <a class="toggle" href="#" id="userDropdown" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <span class="user">
                                                        <!-- Avatar with the first letter of admin name -->
                                                        <span class="avatar"
                                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: #007bff; color: white; border-radius: 50%; font-size: 18px;">
                                                            <?php
                                                            if (isset($_SESSION["stylistName"])) {
                                                                echo strtoupper(substr($_SESSION["stylistName"], 0, 1));
                                                            } else {
                                                                echo "G"; // Default letter if admin name is not set
                                                            }
                                                            ?>
                                                            <span class="status"></span>
                                                        </span>

                                                        <span class="name">
                                                            <?php
                                                            if (isset($_SESSION["stylistName"])) {
                                                                echo htmlspecialchars($_SESSION["stylistName"]);
                                                            }
                                                            ?>
                                                        </span>


                                                    </span>
                                                </a>


                                            </span>
                                        </a>

                                        <!-- Dropdown -->
                                        <div class="adomx-dropdown-menu dropdown-menu-user">
                                            <div class="head">
                                                <h5 class="name"><a href="#">
                                                        <?php

                                                        if (isset($_SESSION["stylistName"])) {
                                                            echo $_SESSION["stylistName"];
                                                        }


                                                        ?>
                                                    </a></h5>
                                                <a class="mail" href="#">
                                                    <?php

                                                    if (isset($_SESSION["stylistEmail"])) {
                                                        echo $_SESSION["stylistEmail"];
                                                    }


                                                    ?>
                                                </a>
                                            </div>
                                            <div class="body">

                                                <ul>
                                                    <li><a href="stylist-profile.php"><i
                                                                class="zmdi zmdi-account"></i>Profile</a></li>
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
                        <li><a href="index.php"><i class="ti-dashboard"></i> <span>Dashboard</span></a></li>
                        <li><a href="viewAppointment.php"><i class="ti-agenda"></i> <span>Appintments</span></a></li>
                        <li><a href="history.php"><i class="ti-time"></i> <span>History</span></a></li>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                                <i class="ti-agenda"></i>
                                <span>Calendar</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title" id="scheduleModalLabel">Schedule Appointment</h5>
                                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="add-edit-product-wrap col-12">
                                    <div class="add-edit-product-form">
                                        <form action="save_schedule.php" method="post" id="schedule-form" class="schedule-form">
                                            <h4 class="title">Schedule Details</h4>
                                            <div class="row">
                                                <!-- Appointment Title -->
                                                <div class="col-12 mb-30">
                                                    <input type="text" name="title" class="form-control" id="title" placeholder="Appointment Title*" required>
                                                </div>

                                                <!-- Appointment Description -->
                                                <div class="col-12 mb-30">
                                                    <textarea name="description" class="form-control" id="description" placeholder="Appointment Description*" required></textarea>
                                                </div>

                                                <!-- Start Date and Time -->
                                                <div class="col-lg-6 col-12 mb-30">
                                                    <input type="datetime-local" name="start_datetime" class="form-control" id="start_datetime" placeholder="Start Date and Time*" required>
                                                </div>

                                                <!-- End Date and Time -->
                                                <div class="col-lg-6 col-12 mb-30">
                                                    <input type="datetime-local" name="end_datetime" class="form-control" id="end_datetime" placeholder="End Date and Time*" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Save Schedule Button -->
                                                <div class="d-flex flex-wrap justify-content-end col mbn-10">
                                                    <button type="submit" class="button button-outline button-primary">
                                                        Save Schedule
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </div><!-- Side Header Inner End -->
        </div><!-- Side Header End -->
        <?php

        ?>

        