<?php
include('components/header.php');

?>

<?php
if (!isset($_SESSION['receptionistsEmail'])) {
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
        <?php

        // Fetch the count of orders from the database
        $query = "SELECT COUNT(*) AS order_count FROM orders"; // Replace 'orders' with your actual orders table name
        $result = $pdo->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $order_count = $row['order_count'];

        ?>

        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head pt-10">
                    <h4>Total Orders</h4>
                    <a href="" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>

                <!-- Content -->
                <div class="content pt-30 pb-20">
                    <h2 class="text-center"><?php echo number_format($order_count); ?></h2>
                </div>

            </div>
        </div>
        <!-- Total Orders End -->




        <?php
        // Fetch the count of stylists from the database
        $query = "SELECT COUNT(*) AS appointment_count FROM appointments";
        $result = $pdo->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $appointment_count = $row['appointment_count'];
        ?>

        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head pt-10">
                    <h4>Total Appointment</h4>
                    <a href="" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>

                <!-- Content -->
                <div class="content pt-30 pb-20">
                    <h2 class="text-center"><?php echo number_format($appointment_count); ?></h2>
                </div>

            </div>
        </div>
        <!-- Total stylist End -->

        <!-- Total stylist Start -->

        <?php
        // Fetch the count of today's appointments from the database
        $query = "SELECT COUNT(*) AS appointment_count FROM appointments WHERE DATE(appointment_date) = CURDATE()"; // Replace 'appointments' with your actual table name
        $result = $pdo->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $appointment_count = $row['appointment_count'];
        ?>

        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head pt-10">
                    <h4>Today's Appointments</h4>
                    <a href="" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>

                <!-- Content -->
                <div class="content pt-30 pb-20">
                    <h2 class="text-center"><?php echo number_format($appointment_count); ?></h2>
                </div>

            </div>
        </div>
        <!-- Today's Appointments End -->
        <?php
        // Fetch the count of suppliers from the database
        $query = "SELECT COUNT(*) AS supplier_count FROM suppliers"; // Replace 'suppliers' with your actual suppliers table name
        $result = $pdo->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $supplier_count = $row['supplier_count'];
        ?>

        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head pt-10">
                    <h4>Total Suppliers</h4>
                    <a href="" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>

                <!-- Content -->
                <div class="content pt-30 pb-20">
                    <h2 class="text-center"><?php echo number_format($supplier_count); ?></h2>
                </div>

            </div>
        </div>
        <!-- Total Suppliers End -->



        <div class="row mbn-30">


            <!-- Recent Transaction Start -->
            <div class="col-12 mb-30">
                <div class="box">
                    <div class="box-head">
                        <h4 class="title">Recent Appoitments</h4>
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
            </div><!-- Recent Transaction End -->



        </div>

    </div><!-- Content Body End -->

    <?php
    include('components/footer.php');
    ?>