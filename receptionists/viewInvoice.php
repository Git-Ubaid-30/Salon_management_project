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
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Invoices</span></h3>
            </div>
        </div>
    </div><!-- Page Headings End -->

    <div class="row">

        <!--Manage Invoice List Start-->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th scope="col">Invoice ID</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Town</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Shipping Cost</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Order Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Assuming $pdo is your database connection object
                        $query = $pdo->query("SELECT * FROM invoice");
                        $allInvoices = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($allInvoices as $invoice) {
                            // Calculate total amount dynamically
                            $subtotal = $invoice['subtotal'];
                            $shipping_cost = $invoice['shipping_cost'];
                            $calculatedTotal = $subtotal + $shipping_cost;

                            ?>
                            <tr>
                                <td><?php echo $invoice['id'] ?></td>
                                <td><?php echo htmlspecialchars($invoice['first_name'] . ' ' . $invoice['last_name']) ?>
                                </td>
                                <td><?php echo htmlspecialchars($invoice['street_address']) ?></td>
                                <td><?php echo htmlspecialchars($invoice['town']) ?></td>
                                <td><?php echo htmlspecialchars($invoice['phone']) ?></td>
                                <td><?php echo htmlspecialchars($invoice['email']) ?></td>
                                <td><?php echo number_format($subtotal, 2) ?></td>
                                <td><?php echo number_format($shipping_cost, 2) ?></td>
                                <td><?php echo number_format($calculatedTotal, 2) ?></td>
                                <td><?php echo htmlspecialchars($invoice['payment_method']) ?></td>
                                <td><?php echo htmlspecialchars($invoice['order_status']) ?></td>
                                <td>
                                    <div class="table-action-buttons">
                                        <a class="delete button button-box button-xs button-danger"
                                            href="javascript:void(0);"
                                            onclick="confirmDelete(<?php echo $invoice['id']; ?>)"><i
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
        <!--Manage Invoice List End-->

    </div>

</div><!-- Content Body End -->

<?php
include('components/footer.php');
?>

<!-- JavaScript SweetAlert Delete Confirmation -->
<script>
    function confirmDelete(invoiceId) {
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
                // Redirect to PHP deletion script with invoice ID
                window.location.href = "?invoiceRemove=" + invoiceId;
            }
        });
    }
</script>