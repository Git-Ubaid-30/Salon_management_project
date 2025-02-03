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

<?php
if (isset($_GET["pId"])) {
    $productId = $_GET["pId"];
    $query = $pdo->prepare("
        SELECT products.*, 
               categories.name AS catName, 
               categories.id AS catId, 
               suppliers.id AS supId, 
                suppliers.product_salling AS supProduct,
               suppliers.product_qty AS supQty
        FROM products 
        INNER JOIN categories ON products.category_id = categories.id 
        INNER JOIN suppliers ON products.supplier_id = suppliers.id 
        WHERE products.id = :product_Id
    ");
    $query->bindParam("product_Id", $productId);
    $query->execute();
    $product = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- Content Body Start -->
<div class="content-body">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Edit Product</span></h3>
            </div>
        </div><!-- Page Heading End -->

    </div><!-- Page Headings End -->

    <!-- Add or Edit Product Start -->
    <div class="add-edit-product-wrap col-12">

        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">

                <h4 class="title">About Edit Product</h4>

                <div class="row">
                    <div class="col-lg-6 col-12 mb-30"><input value="<?php echo $product['name'] ?>" name="pName"
                            class="form-control" type="text" placeholder="Product Name / Title*" required>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $product['price'] ?>" name="pPrice" class="form-control" type="text"
                            placeholder="Product Price*" pattern="^(?!0)\d+(\.\d{1,2})?$"
                            title="Please enter a valid positive number. Decimals up to two places are allowed."
                            required>
                    </div>


                    <div class="col-12 mb-30"><textarea name="pDes" class="form-control"
                            placeholder="Product Description*" required><?php echo $product['des'] ?></textarea>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <select name="pCategory_id" class="form-control select2">
                            <option value="<?php echo $product['catId'] ?>"><?php echo $product['catName'] ?></option>
                            <?php
                            $query = $pdo->prepare("Select * from categories where name != :cName");
                            $query->bindParam('cName', $product['catName']);
                            $query->execute();
                            $allCategories = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($allCategories as $category) {
                                ?>
                                <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <select name="pSupplier_id" class="form-control select2" id="supplier-select">
                            <option value="<?php echo $product['supId'] ?>" data-qty="<?php echo $product['supQty'] ?>">
                                <?php echo $product['supProduct'] ?></option>
                            <?php
                            $query = $pdo->prepare("SELECT * FROM suppliers WHERE product_salling != :sSelling");
                            $query->bindParam('sSelling', $product['supProduct']);
                            $query->execute();
                            $allSuppliers = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($allSuppliers as $supplier) {
                                ?>
                                <option value="<?php echo $supplier['id'] ?>"
                                    data-qty="<?php echo $supplier['product_qty'] ?>">
                                    <?php echo $supplier['product_salling'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-12 mb-30">
                        <input id="product-qty" value="<?php echo $product['qty'] ?>" name="pQty" class="form-control"
                            type="text" placeholder="Quantity*" readonly>
                    </div>

                    <!-- Product Rating -->
                    <h4 class="title">Product Rating</h4>
                    <div class="star-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star <?php echo $i <= $product['rating'] ? 'active' : ''; ?>"
                                data-value="<?php echo $i; ?>">
                                <i class="ti-star"></i>
                            </span>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="pRating" id="productRating"
                        value="<?php echo $product['rating']; ?>" required>

                </div>

                <h4 class="title">Product Image</h4>
                <div class="product-upload-gallery row flex-wrap">
                    <div class="col-12 mb-30">
                        <p class="form-help-text mt-0">Upload Image</p>
                        <input name="pImage" class="file-pond" type="file" accept=".jpg,.jpeg,.png,.webp,.jfif,.avif">
                    </div>
                    <img src="assets/images/<?php echo $product['image'] ?> " class="product-image rounded-circle"
                        alt="" style="width: 110px; height: 90px; object-fit: cover;">
                </div>

                <!-- Button Group Start -->
                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0"
                            name="updateProduct">Update
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
    document.addEventListener('DOMContentLoaded', function () {
        const supplierSelect = document.getElementById('supplier-select');
        const productQtyInput = document.getElementById('product-qty');

        supplierSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const qty = selectedOption.getAttribute('data-qty');

            // Update the quantity input field with the selected supplier's quantity
            productQtyInput.value = qty;
        });
    });

    // JavaScript for Dynamic Service-Shift Integration and Rating System
    document.addEventListener("DOMContentLoaded", function () {
        const stars = document.querySelectorAll(".star");
        const ratingInput = document.getElementById("productRating");

        // Set initial rating from database
        const currentRating = parseInt(ratingInput.value);

        // Highlight the stars up to the current rating
        stars.forEach((star, index) => {
            if (index < currentRating) {
                star.classList.add("active");
            }

            // Enable clicking to change rating
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