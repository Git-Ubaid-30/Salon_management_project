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

        <div id="notification" class="alert alert-danger alert-dismissible fade show" role="alert"
            style="display: none;">
            <strong>Warning!</strong> Some suppliers have low stock quantities (5 or less).
        </div>

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Suppliers</span></h3>
            </div>
        </div><!-- Page Heading End -->




    </div><!-- Page Headings End -->

    <div class="row">

        <!--Manage Supplier List Start-->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th scope="col">Supplier ID</th>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Selling Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Contact info</th>
                            <th scope="col">Address</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $lowStockAlert = false;

                        $query = $pdo->query("SELECT * FROM suppliers");
                        $allSuppliers = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($allSuppliers as $supplier) {
                            // Check if product_qty is 5 or less
                            if ($supplier['product_qty'] <= 5) {
                                $lowStockAlert = true; // Set flag if low stock is found
                            }
                            ?>
                            <tr>
                                <td scope="row"><?php echo $supplier['id'] ?></td>
                                <td><?php echo $supplier['name'] ?></td>
                                <td><?php echo $supplier['product_salling'] ?></td>
                                <td><?php echo $supplier['product_qty'] ?></td>
                                <td><?php echo $supplier['contact_info'] ?></td>
                                <td><?php echo $supplier['address'] ?></td>
                                <td>
                                    <div class="table-action-buttons">
                                        <a class="delete button button-box button-xs button-danger"
                                            href="javascript:void(0);"
                                            onclick="confirmDelete(<?php echo $supplier['id']; ?>)"><i
                                                class="zmdi zmdi-delete"></i></a>

                                    </div>
                                </td>
                            </tr>
                            <?php
                        }

                        // Show notification if low stock is present
                        if ($lowStockAlert) {
                            echo "<script>
                                    document.getElementById('notification').style.display = 'block';
                                  </script>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--Manage Supplier List End-->

    </div>

</div><!-- Content Body End -->

<?php
include('components/footer.php')
    ?>

<!-- JavaScript SweetAlert Delete Confirmation -->
<script>
    function confirmDelete(supplierId) {
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
                // Redirect to PHP deletion script with supplier ID
                window.location.href = "?sRemove=" + supplierId;
            }
        });
    }
    // Function to check the quantities and show/hide the notification accordingly
    function checkStockQuantities() {
        // Get all quantity cells in the table
        const qtyCells = document.querySelectorAll('tbody tr td:nth-child(4)'); // Adjust index based on your table structure
        let lowStockExists = false;

        qtyCells.forEach(cell => {
            const qty = parseInt(cell.textContent);
            if (qty <= 5) {
                lowStockExists = true; // If any quantity is 5 or less
            }
        });

        // Show or hide the notification based on the stock check
        const notification = document.getElementById('notification');
        if (lowStockExists) {
            notification.style.display = 'block'; // Show notification
        } else {
            notification.style.display = 'none'; // Hide notification if all quantities are above 5
        }
    }

    // Call the function on page load
    document.addEventListener('DOMContentLoaded', checkStockQuantities);
</script>