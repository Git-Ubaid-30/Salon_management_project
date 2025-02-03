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
                <h3>eCommerce <span>/ Receptionists</span></h3>
            </div>
        </div><!-- Page Heading End -->

        <!-- Page Button Group Start -->
        <div class="col-12 col-lg-auto mb-20 mr-70">
            <div class="buttons-group">
                <a href="addReceptionist.php" class="button button-outline button-primary">Add Receptionist</a>
            </div>
        </div><!-- Page Button Group End -->

    </div><!-- Page Headings End -->

    <div class="row">

        <!--Manage Receptionist List Start-->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th scope="col">Receptionist ID</th>
                            <th scope="col" class="pl-15">Photo</th>
                            <th scope="col">Receptionist Name</th>
                            <th scope="col">Contact Info</th>
                            <th scope="col">Receptionist Shift Schedule</th>
                            <th scope="col">Assigned Tasks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $pdo->query("SELECT * from receptionists");
                        $allReceptionists = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($allReceptionists as $receptionist) {
                            ?>
                            <tr>
                                <td scope="row"><?php echo $receptionist['id'] ?></td>

                                <td><img src="assets/images/<?php echo $receptionist['image'] ?> "
                                        class="product-image rounded-circle" alt=""
                                        style="width: 65px; height: 65px; object-fit: cover;"></td>

                                <td><?php echo $receptionist['name'] ?></td>

                                <td><?php echo $receptionist['contact_info'] ?></td>
                                
                                <td><?php echo $receptionist['shift_schedule'] ?></td>

                                <td><?php echo $receptionist['assigned_tasks'] ?></td>

                                <td>
                                    <div class="table-action-buttons">
                                        <a class="delete button button-box button-xs button-danger"
                                            href="javascript:void(0);"
                                            onclick="confirmDelete(<?php echo $receptionist['id']; ?>)"><i
                                                class="zmdi zmdi-delete"></i></a>

                                        <a class="edit button button-box button-xs button-info"
                                            href="editReceptionist.php?receptionistId=<?php echo $receptionist['id'] ?>"><i
                                                class="zmdi zmdi-edit"></i></a>

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
        <!--Manage Receptionist List End-->

    </div>

</div><!-- Content Body End -->

<?php
include('components/footer.php')
    ?>

<!-- JavaScript SweetAlert Delete Confirmation -->
<script>
    function confirmDelete(receptionistId) {
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
                // Redirect to PHP deletion script with Receptionist ID
                window.location.href = "?receptionistRemove=" + receptionistId;
            }
        });
    }
</script>