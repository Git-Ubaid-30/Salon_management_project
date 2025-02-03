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
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Receptionists Profile</h3>
            </div>
        </div>
    </div>

    <div class="row mbn-50">
        <!-- Profile Section -->
        <div class="col-xlg-12 col-lg-12 col-12 mb-15">
            <div class="box">
                <div class="box-head">
                    <h3 class="title">Profile Details</h3>
                </div>
                <div class="box-body">
                    <!-- Profile Image Display -->
                    <?php if (isset($_SESSION["receptionistsImage"]) && file_exists($_SESSION["receptionistsImage"])): ?>
                        <div class="text-center mb-3">
                            <img src="<?php echo $_SESSION["receptionistsImage"]; ?>" alt="Profile Image"
                                class="img-thumbnail" width="150" height="150">
                        </div>
                    <?php endif; ?>

                    <form method="post" enctype="multipart/form-data">
                        <div class="row row-10 mbn-20">
                            <div class="col-sm-6 col-12 mb-20">
                                <input type="text" name="receptionistsName" class="form-control"
                                    value="<?php echo htmlspecialchars($receptionistsName); ?>" required>
                            </div>
                            <div class="col-sm-6 col-12 mb-20">
                                <input type="email" name="receptionistsEmail" class="form-control"
                                    value="<?php echo htmlspecialchars($receptionistsEmail); ?>" required>
                            </div>
                           
                            <div class="col-12 mt-10 mb-20">
                                <button name="updateProfileReceptionists" class=" btn btn-success text-white ">Save
                                    Changes</button>
                                <small class="text-success"><?php echo $profileMsg; ?></small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Profile Section -->

        <!-- Change Password Section -->
        <div class="col-xlg-12 col-lg-12 col-12 mb-15">
            <div class="box">
                <div class="box-head">
                    <h3 class="title">Change Password</h3>
                </div>
                <div class="box-body">
                    <form method="post">
                        <div class="row row-10 mbn-20">
                            <div class="col-12 mb-20">
                                <input type="password" name="currentPassword" class="form-control"
                                    placeholder="Current Password">
                            </div>
                            <div class="col-6 mb-20">
                                <input type="password" name="newPassword" class="form-control"
                                    placeholder="New Password">
                            </div>
                            <div class="col-6 mb-20">
                                <input type="password" name="confirmPassword" class="form-control"
                                    placeholder="Confirm New Password">
                            </div>
                            <div class="col-12 mt-10 mb-20">
                                <button type="submit" name="changePassword" class=" btn btn-danger text-white ">Change
                                    Password</button>
                                <small class="text-danger"><?php echo $passwordErr; ?></small>
                                <small class="text-success"><?php echo $passwordMsg; ?></small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('components/footer.php'); ?>