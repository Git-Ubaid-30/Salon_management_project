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
if (isset($_GET["receptionistId"])) {
    $receptionistId = $_GET["receptionistId"];
    $query = $pdo->prepare("select * from receptionists where id = :receptionistId");
    $query->bindParam("receptionistId", $receptionistId);
    $query->execute();
    $receptionist = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- Content Body Start -->
<div class="content-body">
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Edit Receptionist</span></h3>
            </div>
        </div>
    </div>

    <!-- Add or Edit Receptionist Start -->
    <div class="add-edit-product-wrap col-12">
        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">
                <h4 class="title">About Edit Receptionist</h4>

                <div class="row">
                    <!-- Receptionist Name -->
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $receptionist['name'] ?>" name="receptionistName" class="form-control"
                            type="text" placeholder="Receptionist Name / Title*" required>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $receptionist['contact_info'] ?>" name="receptionistContact" class="form-control"
                            type="text" placeholder="Contact Info*" required pattern="^[0-9]{10,15}$"
                            title="Contact must be 10-15 numeric characters only">
                    </div>

                    <!-- Receptionist Description -->
                    <div class="col-12 mb-30">
                        <textarea name="receptionistAssigned_tasks" class="form-control" placeholder="Assign Tasks To Receptionist*"
                            required><?php echo $receptionist['assigned_tasks'] ?></textarea>
                    </div>

                    <!-- Shift Schedule -->
                    <div class="col-12 mb-30">
                        <input value="<?php echo $receptionist['shift_schedule'] ?>" name="receptionistShift_schedule"
                            class="form-control" type="text" placeholder="Shift Schedule*" required>
                    </div>
                </div>

                <h4 class="title pt-20">Receptionist Image</h4>
                <div class="product-upload-gallery row flex-wrap">
                    <div class="col-12 mb-30">
                        <p class="form-help-text mt-0">Upload Image</p>
                        <input name="receptionistImage" class="file-pond" type="file"
                            accept=".jpg,.jpeg,.png,.webp,.jfif,.avif">
                    </div>
                    <img src="assets/images/<?php echo $receptionist['image'] ?> " class="product-image rounded-circle"
                        alt="" style="width: 110px; height: 90px; object-fit: cover;">
                </div>

                <!-- Submit Button -->
                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0"
                            name="updateReceptionist">Update Receptionist</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include('components/footer.php');
?>