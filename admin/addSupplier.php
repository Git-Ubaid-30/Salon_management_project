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
                <h3>eCommerce <span>/ Add Supplier</span></h3>
            </div>
        </div><!-- Page Heading End -->

    </div><!-- Page Headings End -->

    <!-- Add or Edit Supplier Start -->
    <div class="add-edit-product-wrap col-12">

        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">

                <h4 class="title">About Add Supplier</h4>

                <div class="row">
                    <div class="col-lg-6 col-12 mb-30"><input value="<?php echo $sName ?>" name="sName" class="form-control" type="text"
                            placeholder="Supplier Name / Title*">
                        <small id="helpId" class="text-danger"><?php echo $sNameErr ?></small>
                    </div>

                    <div class="col-lg-6 col-12 mb-30"><input value="<?php echo $sSelling ?>" name="sSelling" class="form-control" type="text"
                            placeholder="Product Selling*">
                        <small id="helpId" class="text-danger"><?php echo $sSellingErr ?></small>
                    </div>


                    <div class="col-12 mb-30"><textarea name="sAddress" class="form-control"
                            placeholder="Address*"><?php echo $sAddress ?></textarea>
                        <small id="helpId" class="text-danger"><?php echo $sAddressErr ?></small>
                    </div>

                    <div class="col-lg-6 col-12 mb-30"><input value="<?php echo $sContact ?>" name="sContact" class="form-control" type="text" placeholder="Contact Info*">
                        <small id="helpId" class="text-danger"><?php echo $sContactErr ?></small>
                    </div>

                    <div class="col-lg-6 col-12 mb-30"><input value="<?php echo $sQty ?>" name="sQty" class="form-control" type="text" placeholder="Quantity*">
                        <small id="helpId" class="text-danger"><?php echo $sQtyErr ?></small>
                    </div>

                </div>

                <!-- Button Group Start -->
                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0" name="addSupplier">Add
                        Supplier</button>
                    </div>
                </div><!-- Button Group End -->

            </form>
        </div>

    </div><!-- Add or Edit Supplier End -->

</div><!-- Content Body End -->

<?php
include('components/footer.php');
?>