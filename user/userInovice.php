<?php
include('components/header.php');

// Check if the user is logged in
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

// Get user email from session
$userEmail = $_SESSION['userEmail'];
?>

<!-- Content Body Start -->
<div class="content-body">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ My Invoices</span></h3>
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
                            <th scope="col">Address</th>
                            <th scope="col">Town</th>
                            <th scope="col">Postcode</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Shipping Cost</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch invoices only for the logged-in user's email
                        $query = $pdo->prepare("SELECT * FROM invoice WHERE email = :email");
                        $query->execute(['email' => $userEmail]);
                        $userInvoices = $query->fetchAll(PDO::FETCH_ASSOC);

                        // Display each invoice for the user
                        foreach ($userInvoices as $invoice) {
                            ?>
                            <tr>
                                <td><?php echo $invoice['id'] ?></td>
                                <td><?php echo $invoice['street_address'] ?></td>
                                <td><?php echo $invoice['town'] ?></td>
                                <td><?php echo $invoice['postcode'] ?></td>
                                <td><?php echo $invoice['phone'] ?></td>
                                <td><?php echo $invoice['email'] ?></td>
                                <td><?php echo $invoice['subtotal'] ?></td>
                                <td><?php echo $invoice['shipping_cost'] ?></td>
                                <td><?php echo $invoice['total_amount'] ?></td>
                                <td><?php echo $invoice['payment_method'] ?></td>
                                <td><?php echo $invoice['order_status'] ?></td>
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