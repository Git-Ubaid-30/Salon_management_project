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
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Add Category</span></h3>
            </div>
        </div>
    </div>

    <div class="add-edit-product-wrap col-12">
        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">
                <h4 class="title">About Add Category</h4>

                <div class="row">
                    <div class="col-12 mb-30">
                        <input value="<?php echo $cName ?>" name="cName" class="form-control" type="text" placeholder="Category Name / Title*">
                        <small class="text-danger"><?php echo $cNameErr ?></small>
                    </div>

                    <div class="col-12 mb-30">
                        <textarea  name="cDes" class="form-control" placeholder="Category Description*"><?php echo $cDes ?></textarea>
                        <small class="text-danger"><?php echo $cDesErr ?></small>
                    </div>
                </div>

                <h4 class="title">Category Image</h4>
                <div class="product-upload-gallery row flex-wrap">
                    <div class="col-12 mb-30">
                        <p class="form-help-text mt-0">Upload Image</p>
                        <input name="cImage" class="file-pond" type="file" accept=".jpg,.jpeg,.png,.webp,.jfif,.avif">
                        <small class="text-danger"><?php echo $cImageNameErr ?></small>
                    </div>
                </div>

                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0" name="addCategory">Add Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('components/footer.php'); ?>
