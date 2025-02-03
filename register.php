<?php include('query.php'); ?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Register | Elegance Salon</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="admin/assets/images/favicon.png">

    <!-- CSS
    ============================================ -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="admin/assets/css/vendor/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="admin/assets/css/vendor/font-awesome.min.css">
    <link rel="stylesheet" href="admin/assets/css/vendor/themify-icons.css">
    <link rel="stylesheet" href="admin/assets/css/vendor/cryptocurrency-icons.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="admin/assets/css/plugins/plugins.css">

    <!-- Helper CSS -->
    <link rel="stylesheet" href="admin/assets/css/helper.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="admin/assets/css/style.css">

    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="admin/assets/css/style-primary.css">
</head>

<style>
  .login-register-bg {
    background-image: url('admin/assets/images/bg/login-bg.jpg');
    background-size: cover;
    background-position: center;
  }
</style>

<body class="skin-dark">

    <div class="main-wrapper">
        <div class="content-body m-0 p-0">
            <div class="login-register-wrap">
                <div class="row">

                    <div class="d-flex align-self-center justify-content-center order-2 order-lg-1 col-lg-5 col-12">
                        <div class="login-register-form-wrap">
                            <div class="content">
                                <h1>Sign up</h1>
                                <p>Join us by creating an account.</p>
                            </div>

                            <div class="login-register-form">
                                <form method="post">
                                    <!-- CSRF Token Field (Optional for security) -->
                                    <input type="hidden" name="csrf_token"
                                        value="<?php echo htmlspecialchars($csrfToken); ?>">

                                    <div class="row">
                                        <div class="col-12 mb-20">
                                            <input class="form-control" type="text" name="uName"
                                                placeholder="User ID / Email"
                                                value="<?php echo htmlspecialchars($userName ?? ''); ?>" required pattern="^[A-Za-z\s]+$" 
                                                title="Only letters and spaces are allowed.">
                                            <?php if (!empty($userNameErr)): ?>
                                                <small class="text-danger"><?php echo $userNameErr; ?></small>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-12 mb-20">
                                            <input class="form-control" type="email" name="uEmail" placeholder="Email"
                                                value="<?php echo htmlspecialchars($userEmail ?? ''); ?>">
                                            <?php if (!empty($userEmailErr)): ?>
                                                <small class="text-danger"><?php echo $userEmailErr; ?></small>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-12 mb-20">
                                            <input class="form-control" type="password" name="uPassword"
                                                placeholder="Password">
                                            <?php if (!empty($userPasswordErr)): ?>
                                                <small class="text-danger"><?php echo $userPasswordErr; ?></small>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-12 mb-20">
                                            <input class="form-control" type="password" name="uConfirmPassword"
                                                placeholder="Retype Password">
                                            <?php if (!empty($userConfirmPasswordErr)): ?>
                                                <small class="text-danger"><?php echo $userConfirmPasswordErr; ?></small>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-12 mt-15">
                                            <button class="button button-primary button-outline"
                                                name="userRegister">Sign up</button>
                                        </div>

                                        <div class="col-12 mt-10">
                                            <div class="row justify-content-between">
                                                <div class="col-auto mb-15">Already have an account? <a
                                                        href="login.php">Login Now.</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="login-register-bg order-1 order-lg-2 col-lg-7 col-12">
                        <div class="content">
                            <h1>Welcome</h1>
                            <p>We're excited to have you join us!</p>
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- Content Body End -->
    </div>

    <!-- JS
============================================ -->

    <!-- Global Vendor, plugins & Activation JS -->
    <script src="admin/assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="admin/assets/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="admin/assets/js/vendor/popper.min.js"></script>
    <script src="admin/assets/js/vendor/bootstrap.min.js"></script>
    <!--Plugins JS-->
    <script src="admin/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="admin/assets/js/plugins/tippy4.min.js.js"></script>
    <!--Main JS-->
    <script src="admin/assets/js/main.js"></script>

    <!-- Plugins & Activation JS For Only This Page -->

    <!--Moment-->
    <script src="admin/assets/js/plugins/moment/moment.min.js"></script>

    <!--Daterange Picker-->
    <script src="admin/assets/js/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="admin/assets/js/plugins/daterangepicker/daterangepicker.active.js"></script>

    <!--Echarts-->
    <script src="admin/assets/js/plugins/chartjs/Chart.min.js"></script>
    <script src="admin/assets/js/plugins/chartjs/chartjs.active.js"></script>

    <!--VMap-->
    <script src="admin/assets/js/plugins/vmap/jquery.vmap.min.js"></script>
    <script src="admin/assets/js/plugins/vmap/maps/jquery.vmap.world.js"></script>
    <script src="admin/assets/js/plugins/vmap/maps/samples/jquery.vmap.sampledata.js"></script>
    <script src="admin/assets/js/plugins/vmap/vmap.active.js"></script>
</body>

</html>