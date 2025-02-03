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
                <h3>eCommerce <span>/ Products</span></h3>
            </div>
        </div><!-- Page Heading End -->

      

    </div><!-- Page Headings End -->

    <div class="row">

        <!--Manage Product List Start-->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th scope="col">Product ID</th>
                            <th scope="col" class="pl-15">Photo</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Supplier Product</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Date</th>
                            <th scope="col">Description</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $pdo->query("SELECT products.*, categories.name AS catName, suppliers.product_salling AS supProduct
                                               FROM products 
                                               INNER JOIN categories ON products.category_id = categories.id 
                                               INNER JOIN suppliers ON products.supplier_id = suppliers.id");
                        $allProducts = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($allProducts as $product) {
                            ?>
                            <tr>
                                <td scope="row"><?php echo $product['id'] ?></td>

                                <td><img src="assets/images/<?php echo $product['image'] ?> "
                                        class="product-image rounded-circle" alt=""
                                        style="width: 65px; height: 65px; object-fit: cover;"></td>

                                <td><?php echo $product['name'] ?></td>

                                <td><?php echo $product['price'] ?></td>

                                <td><?php echo $product['qty'] ?></td>

                                <td><?php echo $product['catName'] ?></td>

                                <td><?php echo $product['supProduct'] ?></td>

                                <td><?php echo $product['rating'] ?></td>

                                <td><?php echo $product['date'] ?></td>

                                <td><?php echo $product['des'] ?></td>

                                <td>
                                    <div class="table-action-buttons">
                                        <a class="delete button button-box button-xs button-danger"
                                            href="javascript:void(0);"
                                            onclick="confirmDelete(<?php echo $product['id']; ?>)"><i
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
        <!--Manage Product List End-->

    </div>

</div><!-- Content Body End -->

<?php
include('components/footer.php')
    ?>

<!-- JavaScript SweetAlert Delete Confirmation -->
<script>
    function confirmDelete(productId) {
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
                // Redirect to PHP deletion script with product ID
                window.location.href = "?pRemove=" + productId;
            }
        });
    }
</script>