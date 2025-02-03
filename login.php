<?php
// Set session cookie to expire when the browser is closed
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => '',
  'secure' => isset($_SERVER['HTTPS']),
  'httponly' => true,
  'samesite' => 'Strict'
]);

// Include the database connection
include('query.php');


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Login | Elegance Salon</title>
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
    <!-- Content Body Start -->
    <div class="content-body m-0 p-0">
      <div class="login-register-wrap">
        <div class="row">
          <div class="d-flex align-self-center justify-content-center order-2 order-lg-1 col-lg-5 col-12">
            <div class="login-register-form-wrap">
              <div class="content">
                <h1>Sign in</h1>
                <p>Welcome back! Please login to your account.</p>
              </div>

              <div class="login-register-form">
                <form method="post">
                  <div class="row">
                    <div class="col-12 mb-20">
                      <input class="form-control" type="text" name="uEmail" placeholder="User ID / Email"
                        value="<?php echo htmlspecialchars($uEmail); ?>">
                      <?php if (!empty($uEmailErr)): ?>
                        <small class="text-danger"><?php echo $uEmailErr; ?></small>
                      <?php endif; ?>
                    </div>
                    <div class="col-12 mb-20">
                      <input class="form-control " type="password" name="uPassword" placeholder="Password">
                      <?php if (!empty($uPassErr)): ?>
                        <small class="text-danger"><?php echo $uPassErr; ?></small>
                      <?php endif; ?>
                    </div>

                    <div class="col-12">
                      <div class="row justify-content-between">

                        <div class="col-auto mb-15">Don't have an account? <a href="register.php">Create Now.</a></div>
                      </div>
                    </div>
                    <div class="col-12 mt-10">
                      <button class="button button-primary button-outline" type="submit" name="userLogin">Sign
                        in</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="login-register-bg order-1 order-lg-2 col-lg-7 col-12">
            <div class="content">
              <h1>Welcome Back!</h1>
              <p>We are glad to see you again. Sign in to continue managing your account.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Content Body End -->
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