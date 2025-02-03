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
        
        
        <div id="notification" class="alert alert-danger alert-dismissible fade show" role="alert"
            style="display: none;">
            <strong>Warning!</strong> Some products have low stock quantities (5 or less).
        </div>
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Inventory</span></h3>
            </div>
        </div>


    </div>
    <!-- Page Headings End -->

    <div class="row">

        <!--Manage Inventory List Start-->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col" class="pl-15">Photo</th>
                            <th scope="col">Product Price</th>
                            <th scope="col">Product Quantity</th>
                            <th scope="col">Product Category</th>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Supplier Contact Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $pdo->query("
                                SELECT 
                                    p.id AS product_id,
                                    p.name AS product_name, 
                                    p.image AS product_image, 
                                    p.price AS product_price, 
                                    c.name AS category_name, 
                                    s.product_qty AS product_qty, 
                                    s.name AS supplier_name, 
                                    s.contact_info AS supplier_contact 
                                FROM 
                                    products p
                                JOIN 
                                    suppliers s ON p.supplier_id = s.id
                                JOIN 
                                    categories c ON p.category_id = c.id
                                ");
                        $inventoryItems = $query->fetchAll(PDO::FETCH_ASSOC);
                        $lowStockAlert = false; // Flag to check for low stock
                        foreach ($inventoryItems as $item) {
                            // Check if product quantity is 5 or less
                            if ($item['product_qty'] <= 5) {
                                $lowStockAlert = true; // Set flag if low stock is found
                            }
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td>
                                    <img src="assets/images/<?php echo htmlspecialchars($item['product_image']); ?>"
                                        class="product-image rounded-circle" alt="Product Image"
                                        style="width: 65px; height: 65px; object-fit: cover;">
                                </td>
                                <td><?php echo htmlspecialchars($item['product_price']); ?></td>
                                <td><?php echo htmlspecialchars($item['product_qty']); ?></td>
                                <td><?php echo htmlspecialchars($item['category_name']); ?></td>
                                <td><?php echo htmlspecialchars($item['supplier_name']); ?></td>
                                <td><?php echo htmlspecialchars($item['supplier_contact']); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
        <!--Manage Inventory List End-->

    </div>

</div><!-- Content Body End -->

<?php
// Show notification if low stock is present
if ($lowStockAlert) {
    echo "<script>
            document.getElementById('notification').style.display = 'block';
          </script>";
}
include('components/footer.php');
?>

<script>
    // Function to check the quantities and show/hide the notification accordingly
    function checkStockQuantities() {
        const qtyCells = document.querySelectorAll('tbody tr td:nth-child(4)'); // Adjust index based on your table structure
        let lowStockExists = false;

        qtyCells.forEach(cell => {
            const qty = parseInt(cell.textContent);
            if (qty <= 5) {
                lowStockExists = true; // If any quantity is 5 or less
            }
        });

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