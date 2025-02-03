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
                <h3>eCommerce <span>/ Services</span></h3>
            </div>
        </div><!-- Page Heading End -->

        <!-- Page Button Group Start -->
        <div class="col-12 col-lg-auto mb-20 mr-70">
            <div class="buttons-group">
                <a href="addService.php" class="button button-outline button-primary">Add Service</a>
            </div>
        </div><!-- Page Button Group End -->

    </div><!-- Page Headings End -->

    <div class="row">

        <!--Manage Service List Start-->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th scope="col">Service ID</th>
                            <th scope="col" class="pl-15">Photo</th>
                            <th scope="col">Service Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $pdo->query("select * from services");
                        $allServices = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($allServices as $service) {
                            ?>
                            <tr>
                                <td scope="row"><?php echo $service['id'] ?></td>

                                <td><img src="assets/images/<?php echo $service['image'] ?> "
                                        class="product-image rounded-circle" alt=""
                                        style="width: 65px; height: 65px; object-fit: cover;"></td>

                                <td><?php echo $service['name'] ?></td>

                                <td><?php echo $service['price'] ?></td>

                                <td><?php echo $service['duration'] ?></td>

                                <td><?php echo $service['des'] ?></td>

                                <td>
                                    <div class="table-action-buttons">
                                        <a class="delete button button-box button-xs button-danger"
                                            href="javascript:void(0);"
                                            onclick="confirmDelete(<?php echo $service['id']; ?>)"><i
                                                class="zmdi zmdi-delete"></i></a>

                                        <a class="edit button button-box button-xs button-info"
                                            href="editService.php?serviceId=<?php echo $service['id'] ?>"><i
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
        <!--Manage service List End-->

    </div>

</div><!-- Content Body End -->

<?php
include('components/footer.php')
    ?>

<!-- JavaScript SweetAlert Delete Confirmation -->
<script>
    function confirmDelete(serviceId) {
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
                // Redirect to PHP deletion script with service ID
                window.location.href = "?serviceRemove=" + serviceId;
            }
        });
    }
</script>