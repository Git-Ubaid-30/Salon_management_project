<?php
include('components/header.php');
?>

<?php
if (!isset($_SESSION['adminEmail'])) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Unauthorized Access!',
                text: 'You need to log in to access this page.',
                background: '#333',
                color: '#fff',
                confirmButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = '../login.php';
                }
            });
        });
    </script>";
    exit();
}
?>

<!-- Content Body Start -->
<div class="content-body">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Dashboard <span>/ eCommerce</span></h3>
            </div>
        </div><!-- Page Heading End -->

    </div><!-- Page Headings End -->

    <!-- Top Report Wrap Start -->
    <div class="row">
        <!-- Total users Start -->

        <?php

        // Fetch the count of users from the database
        $query = "SELECT COUNT(*) AS user_count FROM users";
        $result = $pdo->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $user_count = $row['user_count'];
        ?>

        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head pt-10">
                    <h4>Total Users</h4>
                    <a href="" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>

                <!-- Content -->
                <div class="content pt-30 pb-20">
                    <h2 class="text-center"><?php echo number_format($user_count); ?></h2>
                </div>

            </div>
        </div>
        <!-- Total users End -->


        <?php

        // Prepare a statement to get today's total sales
        $query = "SELECT SUM(total_amount) AS today_sales FROM invoice WHERE DATE(created_at) = CURDATE()";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get today's sales amount
        $todaySales = $result['today_sales'] ? number_format($result['today_sales'], 2) : '0.00';
        ?>

        <!-- Today sale Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head pt-10">
                    <h4>Today Sales</h4>
                    <a href="" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>

                <!-- Content -->
                <div class="content pt-30 pb-20">
                    <h2 class="text-center">$<?php echo $todaySales; ?></h2> <!-- Display today's sales amount -->
                </div>

            </div>
        </div><!-- Today sale End -->

        <!-- Total Receptionists Start -->
        <?php

        // Fetch the count of receptionists from the database
        $query = "SELECT COUNT(*) AS receptionist_count FROM receptionists";
        $result = $pdo->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $receptionist_count = $row['receptionist_count'];
        ?>


        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head pt-10">
                    <h4>Total Receptionists</h4>
                    <a href="viewReceptionist.php" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>

                <!-- Content -->
                <div class="content pt-30 pb-20">
                    <h2 class="text-center"><?php echo number_format($receptionist_count); ?></h2>
                </div>

            </div>
        </div>
        <!-- Total Receptionists End -->

        <!-- Total stylist Start -->

        <?php
        // Fetch the count of stylists from the database
        $query = "SELECT COUNT(*) AS stylist_count FROM stylists";
        $result = $pdo->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $stylist_count = $row['stylist_count'];
        ?>

        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head pt-10">
                    <h4>Total Stylists</h4>
                    <a href="viewStylist.php" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>

                <!-- Content -->
                <div class="content pt-30 pb-20">
                    <h2 class="text-center"><?php echo number_format($stylist_count); ?></h2>
                </div>

            </div>
        </div>
        <!-- Total stylist End -->

    </div><!-- Top Report Wrap End -->

    <div class="row mbn-30">


        <!-- Recent Transaction Start -->
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <h4 class="title">Recent Transaction</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        // Prepare a statement to get product data
                        $query = "SELECT id, product_name, product_qty, product_price, status FROM orders"; // Adjust the query based on your table structure
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <table class="table table-vertical-middle table-selectable">

                            <!-- Table Head Start -->
                            <thead>
                                <tr>
                                    <th class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                                class="icon"></i></label></th>
                                    <th><span>Product Name</span></th>
                                    <th><span>ID</span></th>
                                    <th><span>Quantity</span></th>
                                    <th><span>Price</span></th>
                                    <th><span>Status</span></th>
                                    <th></th>
                                </tr>
                            </thead><!-- Table Head End -->

                            <!-- Table Body Start -->
                            <tbody>
                                <?php foreach ($products as $product): ?> <!-- Use full PHP tag -->
                                    <tr>
                                        <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                                    class="icon"></i></label></td>
                                        <td><a href="#"><?php echo htmlspecialchars($product['product_name']); ?></a></td>
                                        <!-- Corrected key name -->
                                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                                        <td><?php echo htmlspecialchars($product['product_qty']) ?></td>
                                        <!-- Corrected key name -->
                                        <td>$<?php echo number_format($product['product_price'], 2); ?></td>
                                        <!-- Corrected key name -->
                                        <td><span
                                                class="badge badge-<?php echo $product['status'] == 'Paid' ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($product['status']); ?></span>
                                        </td>
                                        <td><a class="h3" href="#"><i class="zmdi zmdi-more"></i></a></td>
                                    </tr>
                                <?php endforeach; ?> <!-- Use full PHP tag -->
                            </tbody><!-- Table Body End -->

                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Recent Transaction End -->

        <!-- Daily Sale Report Start -->
        <div class="col-xlg-12 col-lg-12 col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <h4 class="title">Recent Appointments</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        // Prepare a statement to get product data
                        $query = "SELECT id, name, email, contact_info, appointment_date, appointment_time , status FROM appointments"; // Adjust the query based on your table structure
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <table class="table table-vertical-middle table-selectable">

                            <!-- Table Head Start -->
                            <thead>
                                <tr>
                                    <th class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                                class="icon"></i></label></th>
                                    <!--<th class="selector h5"><button class="button-check"></button></th>-->
                                    <th><span>Name</span></th>
                                    <th><span>ID</span></th>
                                    <th><span>Email</span></th>
                                    <th><span>Phone</span></th>
                                    <th><span>appointment_date</span></th>
                                    <th><span>appointment_time</span></th>
                                    <th><span>Status</span></th>
                                    <th></th>
                                </tr>
                            </thead><!-- Table Head End -->

                            <!-- Table Body Start -->
                            <tbody>
                                <?php foreach ($appointments as $appointment): ?> <!-- Use full PHP tag -->
                                    <tr>
                                        <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                                    class="icon"></i></label></td>

                                        <td><?php echo htmlspecialchars($appointment['name']); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($appointment['id']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['email']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['contact_info']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                                        <td><span
                                                class="badge badge-<?php echo $appointment['status'] == 'Paid' ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($appointment['status']); ?></span>
                                        </td>
                                        <td><a class="h3" href="#"><i class="zmdi zmdi-more"></i></a></td>
                                    </tr>
                                <?php endforeach; ?> <!-- Use full PHP tag -->
                            </tbody><!-- Table Body End -->

                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Daily Sale Report End -->

    </div>

</div><!-- Content Body End -->

<?php
include('components/footer.php');
?>
