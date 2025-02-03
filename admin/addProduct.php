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
                <h3>eCommerce <span>/ Add Product</span></h3>
            </div>
        </div><!-- Page Heading End -->

    </div><!-- Page Headings End -->

    <!-- Add or Edit Product Start -->
    <div class="add-edit-product-wrap col-12">

        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">

                <h4 class="title">About Add Product</h4>

                <div class="row">
                    <div class="col-lg-6 col-12 mb-30"><input value="<?php echo $pName ?>" name="pName"
                            class="form-control" type="text" placeholder="Product Name / Title*">
                        <small id="helpId" class="text-danger"><?php echo $pNameErr ?></small>
                    </div>

                    <div class="col-lg-6 col-12 mb-30"><input value="<?php echo $pPrice ?>" name="pPrice"
                            class="form-control" type="text" placeholder="Product Price*">
                        <small id="helpId" class="text-danger"><?php echo $pPriceErr ?></small>
                    </div>


                    <div class="col-12 mb-30"><textarea name="pDes" class="form-control"
                            placeholder="Product Description*"><?php echo $pDes ?></textarea>
                        <small id="helpId" class="text-danger"><?php echo $pDesErr ?></small>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <select name="pCategory_id" class="form-control select2">
                            <option value="">Category</option>
                            <?php
                            $query = $pdo->query("Select * from categories");
                            $allCategories = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($allCategories as $category) {
                                ?>
                                <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <small id="helpId" class="text-danger"><?php echo $pCategory_idErr ?></small>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <select name="pSupplier_id" class="form-control select2" id="supplier-product-select">
                            <option value="">Select Product*</option>
                            <?php
                            // Fetch all suppliers with their product quantities
                            $query = $pdo->query("SELECT * FROM suppliers");
                            $suppliers = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($suppliers as $supplier) {
                                echo "<option value='{$supplier['id']}' data-qty='{$supplier['product_qty']}'>{$supplier['product_salling']}</option>";
                            }
                            ?>
                        </select>
                        <small id="helpId" class="text-danger"><?php echo $pSupplier_idErr; ?></small>
                    </div>

                    <div class="col-12 mb-30">
                        <input id="product-qty" value="<?php echo $pQty ?>" name="pQty" class="form-control" type="text"
                            placeholder="Quantity*" readonly>
                        <small id="helpId" class="text-danger"><?php echo $pQtyErr ?></small>
                    </div>

                    <!-- Product Rating -->
                    <h4 class="title">Product Rating</h4>
                    <div class="star-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star" data-value="<?php echo $i; ?>"><i class="ti-star"></i></span>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="pRating" id="pRating">
                    <small class="text-danger"><?php echo $pRatingErr; ?></small>

                </div>

                <h4 class="title">Product Image</h4>
                <div class="product-upload-gallery row flex-wrap">
                    <div class="col-12 mb-30">
                        <p class="form-help-text mt-0">Upload Image</p>
                        <input name="pImage" class="file-pond" type="file" accept=".jpg,.jpeg,.png,.webp,.jfif,.avif">
                        <small class="text-danger"><?php echo $pImageNameErr; ?></small>
                    </div>
                </div>

                <!-- Button Group Start -->
                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0" name="addProduct">Add
                            Product</button>
                    </div>
                </div><!-- Button Group End -->

            </form>
        </div>

    </div><!-- Add or Edit Product End -->

</div><!-- Content Body End -->

<?php
include('components/footer.php');
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const supplierProductSelect = document.getElementById('supplier-product-select');
        const productQtyInput = document.getElementById('product-qty');

        supplierProductSelect.addEventListener('change', function () {
            // Get the selected option
            const selectedOption = this.options[this.selectedIndex];
            
            // Get the product quantity from the data attribute
            const productQty = selectedOption.getAttribute('data-qty');
            
            // Update the readonly input with the product quantity
            productQtyInput.value = productQty ? productQty : '';
        });
    });

// JavaScript for Dynamic Service-Shift Integration and Rating System
    document.addEventListener("DOMContentLoaded", function () {
        const stars = document.querySelectorAll(".star");
        const ratingInput = document.getElementById("pRating");

        stars.forEach((star) => {
            star.addEventListener("click", function () {
                const ratingValue = parseInt(this.getAttribute("data-value"));
                ratingInput.value = ratingValue;

                // Reset all stars
                stars.forEach((s) => s.classList.remove("active"));

                // Set active stars up to the selected one
                for (let i = 0; i < ratingValue; i++) {
                    stars[i].classList.add("active");
                }
            });
        });
    });
</script>