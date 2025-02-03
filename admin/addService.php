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
                <h3>eCommerce <span>/ Add Service</span></h3>
            </div>
        </div><!-- Page Heading End -->

    </div><!-- Page Headings End -->

    <!-- Add or Edit Service Start -->
    <div class="add-edit-product-wrap col-12">

        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">

                <h4 class="title">About Add Service</h4>

                <div class="row">
                    <div class="col-lg-6 col-12 mb-30"><input value="<?php echo $serviceName ?>" name="serviceName" class="form-control" type="text"
                            placeholder="Service Name / Title*">
                        <small id="helpId" class="text-danger"><?php echo $serviceNameErr ?></small>
                    </div>

                    <div class="col-lg-6 col-12 mb-30"><input value="<?php echo $servicePrice ?>" name="servicePrice" class="form-control" type="text"
                            placeholder="Service Price*">
                        <small id="helpId" class="text-danger"><?php echo $servicePriceErr ?></small>
                    </div>


                    <div class="col-12 mb-30"><textarea name="serviceDes" class="form-control"
                            placeholder="Service Description*"><?php echo $serviceDes ?></textarea>
                        <small id="helpId" class="text-danger"><?php echo $serviceDesErr ?></small>
                    </div>

                    <div class="col-12 mb-30"><input value="<?php echo $serviceDuration ?>" name="serviceDuration" class="form-control" type="text"
                            placeholder="Service Duration (e.g., morning/afternoon/evening/night & Time Duration like (am/pm)).">
                        <small id="helpId" class="text-danger"><?php echo $serviceDurationErr ?></small>
                    </div>

                </div>

                <h4 class="title">Service Image</h4>
                <div class="product-upload-gallery row flex-wrap">
                    <div class="col-12 mb-30">
                        <p class="form-help-text mt-0">Upload Image</p>
                        <input name="serviceImage" class="file-pond" type="file" accept=".jpg,.jpeg,.png,.webp,.jfif,.avif">
                        <small class="text-danger"><?php echo $serviceImageNameErr; ?></small>
                    </div>
                </div>

                <!-- Button Group Start -->
                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0" name="addService">Add
                            Service</button>
                    </div>
                </div><!-- Button Group End -->

            </form>
        </div>

    </div><!-- Add or Edit Service End -->

</div><!-- Content Body End -->

<?php
include('components/footer.php');
?>