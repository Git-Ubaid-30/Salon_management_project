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
                <h3>eCommerce <ist>/ Add Receptionist</span></h3>
            </div>
        </div>
    </div>

    <!-- Add or Edit Receptionist Start -->
    <div class="add-edit-product-wrap col-12">
        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">

                <h4 class="title">About Add Receptionist</h4>

                <div class="row">
                    <!-- Receptionist Name -->
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $receptionistName ?>" name="receptionistName" class="form-control"
                            type="text" placeholder="Receptionist Name / Title*">
                        <small class="text-danger"><?php echo $receptionistNameErr ?></small>
                    </div>

                    <!-- Receptionist Email -->
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $receptionistEmail ?>" name="receptionistEmail" class="form-control"
                            type="text" placeholder="Receptionist Email*">
                        <small class="text-danger"><?php echo $receptionistEmailErr ?></small>
                    </div>

                    <!-- Receptionist Password -->
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $receptionistPassword ?>" name="receptionistPassword"
                            class="form-control" type="password" placeholder="Password*">
                        <small class="text-danger"><?php echo $receptionistPasswordErr ?></small>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $receptionistContact ?>" name="receptionistContact"
                            class="form-control" type="text" placeholder="Contact Info*">
                        <small class="text-danger"><?php echo $receptionistContactErr ?></small>
                    </div>

                    <!-- Assign Task -->
                    <div class="col-12 mb-30">
                        <textarea name="receptionistAssigned_tasks" class="form-control"
                            placeholder="Assign Tasks To Receptionist*"><?php echo $receptionistAssigned_tasks ?></textarea>
                        <small class="text-danger"><?php echo $receptionistAssigned_tasksErr ?></small>
                    </div>

                    <!-- Shift Schedule -->
                    <div class="col-12 mb-30">
                        <input value="<?php echo $receptionistShift_schedule ?>" name="receptionistShift_schedule"
                            class="form-control" type="text" placeholder="Shift Schedule*">
                        <small class="text-danger"><?php echo $receptionistShift_scheduleErr ?></small>
                    </div>
                </div>

                <h4 class="title pt-20">Receptionist Image</h4>
                <div class="product-upload-gallery row flex-wrap">
                    <div class="col-12 mb-30">
                        <p class="form-help-text mt-0">Upload Image</p>
                        <input name="receptionistImage" class="file-pond" type="file"
                            accept=".jpg,.jpeg,.png,.webp,.jfif,.avif">
                        <small class="text-danger"><?php echo $receptionistImageNameErr; ?></small>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0" name="addReceptionist">Add
                            Receptionist</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include('components/footer.php');
?>