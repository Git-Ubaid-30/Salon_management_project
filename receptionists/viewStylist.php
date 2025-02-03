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

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Stylists</span></h3>
            </div>
        </div><!-- Page Heading End -->

      

    </div><!-- Page Headings End -->

    <div class="row">

        <!--Manage Stylist List Start-->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th scope="col">Stylist ID</th>
                            <th scope="col" class="pl-15">Photo</th>
                            <th scope="col">Stylist Name</th>
                            <th scope="col">Contact Info</th>
                            <th scope="col">Service Name</th>
                            <th scope="col">Service Shift Schedule</th>
                            <th scope="col">Commission Rate</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $pdo->query("SELECT stylists.*, services.name AS serName, services.duration AS serDuration, services.price
                                               FROM stylists 
                                               INNER JOIN services ON stylists.service_id = services.id");
                        $allStylists = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($allStylists as $stylist) {
                            ?>
                            <tr>
                                <td scope="row"><?php echo $stylist['id'] ?></td>

                                <td><img src="assets/images/<?php echo $stylist['image'] ?> "
                                        class="product-image rounded-circle" alt=""
                                        style="width: 65px; height: 65px; object-fit: cover;"></td>

                                <td><?php echo $stylist['name'] ?></td>

                                <td><?php echo $stylist['contact_info'] ?></td>

                                <td><?php echo $stylist['serName'] ?></td>

                                <td><?php echo $stylist['serDuration'] ?></td>

                                <td><?php echo $stylist['commission_rate'] ?></td>

                                <td><?php echo $stylist['rating'] ?></td>

                                <td><?php echo $stylist['des'] ?></td>

                                <td>
                                    <div class="table-action-buttons">
                                        <a class="delete button button-box button-xs button-danger"
                                            href="javascript:void(0);"
                                            onclick="confirmDelete(<?php echo $stylist['id']; ?>)"><i
                                                class="zmdi zmdi-delete"></i></a>


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
        <!--Manage Stylist List End-->

    </div>

</div><!-- Content Body End -->

<?php
include('components/footer.php')
    ?>

<!-- JavaScript SweetAlert Delete Confirmation -->
<script>
    function confirmDelete(stylistId) {
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
                // Redirect to PHP deletion script with stylist ID
                window.location.href = "?stylistRemove=" + stylistId;
            }
        });
    }
</script>