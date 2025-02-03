<?php

include('components/header.php');

?>

<?php
if (!isset($_SESSION['userEmail'])) {
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
        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head pt-10">
                    <h4>Total Users</h4>
                    <a href="viewuser.php" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>

                <!-- Content -->
                <div class="content pt-30 pb-20">
                    <h2 class="text-center">100,560.00</h2>
                </div>

            </div>
        </div><!-- Top Report End -->

        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head pt-10">
                    <h4>Total Sales</h4>
                    <a href="viewuser.php" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>

                <!-- Content -->
                <div class="content pt-30 pb-20">
                    <h2 class="text-center">100,560.00</h2>
                </div>

            </div>
        </div><!-- Top Report End -->

        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head pt-10">
                    <h4>Total Receptinist</h4>
                    <a href="viewuser.php" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>

                <!-- Content -->
                <div class="content pt-30 pb-20">
                    <h2 class="text-center">100,560.00</h2>
                </div>

            </div>
        </div><!-- Top Report End -->

        <!-- Top Report Start -->
        <div class="col-xlg-3 col-md-6 col-12 mb-30">
            <div class="top-report">

                <!-- Head -->
                <div class="head pt-10">
                    <h4>Total Stylist</h4>
                    <a href="viewuser.php" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>

                <!-- Content -->
                <div class="content pt-30 pb-20">
                    <h2 class="text-center">100,560.00</h2>
                </div>

            </div>
        </div><!-- Top Report End -->
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
                        <table class="table table-vertical-middle table-selectable">

                            <!-- Table Head Start -->
                            <thead>
                                <tr>
                                    <th class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                                class="icon"></i></label></th>
                                    <!--<th class="selector h5"><button class="button-check"></button></th>-->
                                    <th><span>Image</span></th>
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
                                <tr>
                                    <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                                class="icon"></i></label></td>
                                    <td><img src="assets/images/product/list-product-1.jpg" alt=""
                                            class="table-product-image rounded-circle"></td>
                                    <td><a href="#">Microsoft surface pro 4</a></td>
                                    <td>#MSP40022</td>
                                    <td>05 - Products</td>
                                    <td>$60000000.00</td>
                                    <td><span class="badge badge-success">Paid</span></td>
                                    <td><a class="h3" href="#"><i class="zmdi zmdi-more"></i></a></td>
                                </tr>
                                <tr class="selected">
                                    <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                                class="icon"></i></label></td>
                                    <td><img src="assets/images/product/list-product-2.jpg" alt=""
                                            class="table-product-image rounded-circle"></td>
                                    <td><a href="#">Microsoft surface pro 4</a></td>
                                    <td>#MSP40022</td>
                                    <td>05 - Products</td>
                                    <td>$60000000.00</td>
                                    <td><span class="badge badge-success">Paid</span></td>
                                    <td><a class="h3" href="#"><i class="zmdi zmdi-more"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                                class="icon"></i></label></td>
                                    <td><img src="assets/images/product/list-product-3.jpg" alt=""
                                            class="table-product-image rounded-circle"></td>
                                    <td><a href="#">Microsoft surface pro 4</a></td>
                                    <td>#MSP40022</td>
                                    <td>05 - Products</td>
                                    <td>$60000000.00</td>
                                    <td><span class="badge badge-warning">Due</span></td>
                                    <td><a class="h3" href="#"><i class="zmdi zmdi-more"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                                class="icon"></i></label></td>
                                    <td><img src="assets/images/product/list-product-4.jpg" alt=""
                                            class="table-product-image rounded-circle"></td>
                                    <td><a href="#">Microsoft surface pro 4</a></td>
                                    <td>#MSP40022</td>
                                    <td>05 - Products</td>
                                    <td>$60000000.00</td>
                                    <td><span class="badge badge-danger">Reject</span></td>
                                    <td><a class="h3" href="#"><i class="zmdi zmdi-more"></i></a></td>
                                </tr>
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
                    <h4 class="title">Daily Sale Report</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table daily-sale-report">

                            <!-- Table Head Start -->
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Detail</th>
                                    <th>Payment</th>
                                </tr>
                            </thead><!-- Table Head End -->

                            <!-- Table Body Start -->
                            <tbody>
                                <tr>
                                    <td class="fw-600">Alexander</td>
                                    <td>
                                        <p>Sed do eiusmod tempor <br>incididunt ut labore.</p>
                                    </td>
                                    <td><span class="text-success d-flex justify-content-between fw-600">$500.00<span
                                                class="tippy"
                                                data-tippy-content="Sed do eiusmod tempor <br/> incididunt ut labore."><i
                                                    class="zmdi zmdi-info-outline"></i></span></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-600">Linda</td>
                                    <td>
                                        <p>Sed do eiusmod tempor <br>incididunt ut labore.</p>
                                    </td>
                                    <td><span class="text-success d-flex justify-content-between fw-600">$20.00<span
                                                class="tippy"
                                                data-tippy-content="Sed do eiusmod tempor <br/> incididunt ut labore."><i
                                                    class="zmdi zmdi-info-outline"></i></span></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-600">Patrick</td>
                                    <td>
                                        <p>Sed do eiusmod tempor <br>incididunt ut labore.</p>
                                    </td>
                                    <td><span class="text-danger d-flex justify-content-between fw-600">$120.00<span
                                                class="tippy"
                                                data-tippy-content="Sed do eiusmod tempor <br/> incididunt ut labore."><i
                                                    class="zmdi zmdi-info-outline"></i></span></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-600">Jose</td>
                                    <td>
                                        <p>Sed do eiusmod tempor <br>incididunt ut labore.</p>
                                    </td>
                                    <td><span class="text-success d-flex justify-content-between fw-600">$1750.00<span
                                                class="tippy"
                                                data-tippy-content="Sed do eiusmod tempor <br/> incididunt ut labore."><i
                                                    class="zmdi zmdi-info-outline"></i></span></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-600">Amber</td>
                                    <td>
                                        <p>Sed do eiusmod tempor <br>incididunt ut labore.</p>
                                    </td>
                                    <td><span class="text-warning d-flex justify-content-between fw-600">$165.00<span
                                                class="tippy"
                                                data-tippy-content="Sed do eiusmod tempor <br/> incididunt ut labore."><i
                                                    class="zmdi zmdi-info-outline"></i></span></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-600">Linda</td>
                                    <td>
                                        <p>Sed do eiusmod tempor <br>incididunt ut labore.</p>
                                    </td>
                                    <td><span class="text-success d-flex justify-content-between fw-600">$20.00<span
                                                class="tippy"
                                                data-tippy-content="Sed do eiusmod tempor <br/> incididunt ut labore."><i
                                                    class="zmdi zmdi-info-outline"></i></span></span></td>
                                </tr>
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