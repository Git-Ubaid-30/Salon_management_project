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
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Orders</span></h3>
            </div>
        </div>
    </div><!-- Page Headings End -->

    <div class="row">

        <!--Manage Order List Start-->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">User ID</th>
                            <th scope="col">User Name</th>
                            <th scope="col">User Email</th>
                            <th scope="col">Product ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Price</th>
                            <th scope="col">Product Quantity</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Assuming $pdo is your database connection object
                        $query = $pdo->query("SELECT * FROM orders");
                        $allOrders = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($allOrders as $order) {
                            ?>
                            <tr>
                                <td><?php echo $order['id'] ?></td>
                                <td><?php echo $order['user_id'] ?></td>
                                <td><?php echo $order['user_name'] ?></td>
                                <td><?php echo $order['user_email'] ?></td>
                                <td><?php echo $order['product_id'] ?></td>
                                <td><?php echo $order['product_name'] ?></td>
                                <td><?php echo $order['product_price'] ?></td>
                                <td><?php echo $order['product_qty'] ?></td>
                                <td><?php echo $order['status'] ?></td>
                                <td>
                                    <div class="table-action-buttons">
                                        <a class="delete button button-box button-xs button-danger"
                                            href="javascript:void(0);"
                                            onclick="confirmDelete(<?php echo $order['id']; ?>)"><i
                                                class="zmdi zmdi-delete"></i></a>
                                      
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--Manage Order List End-->

    </div>

</div><!-- Content Body End -->

<?php
include('components/footer.php');
?>

<!-- JavaScript SweetAlert Delete Confirmation -->
<script>
    function confirmDelete(orderId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            background: '#333',
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to PHP deletion script with order ID
                window.location.href = "?orderRemove=" + orderId;
            }
        });
    }
</script>