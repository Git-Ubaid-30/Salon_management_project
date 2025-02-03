<?php
include('components/header.php');
?>

<?php
if (!isset($_SESSION['userEmail'])) {
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

// Get the logged-in user's userId from the session
$userId = $_SESSION['userId'];

?>

<!-- Content Body Start -->
<div class="content-body">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Appointment</span></h3>
            </div>
        </div><!-- Page Heading End -->

    </div><!-- Page Headings End -->

    <div class="row">

        <!-- Manage Stylist List Start-->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">user Id</th>
                            <th scope="col">Contact Info</th>
                            <th scope="col">Service Name</th>
                            <th scope="col">Service Time</th>
                            <th scope="col">Stylist Name</th>
                            <th scope="col">Appointment Date</th>
                            <th scope="col">Appointment Time</th>
                            <th scope="col">Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Modify the query to fetch appointments only for the logged-in user
                        $query = $pdo->prepare("SELECT appointments.*, services.name AS serName, services.duration AS serDuration, stylists.name AS styName
                                               FROM appointments
                                               INNER JOIN stylists ON appointments.stylist_id = stylists.id
                                               INNER JOIN services ON appointments.service_id = services.id
                                               WHERE appointments.user_id = :userId");

                        // Bind the user ID parameter to the query
                        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
                        $query->execute();

                        $Allappointments = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($Allappointments as $appointment) {
                            ?>
                            <tr>
                                <td scope="row"><?php echo $appointment['id'] ?></td>

                                <td><?php echo $appointment['name'] ?></td>

                                <td><?php echo $appointment['user_id'] ?></td>

                                <td><?php echo $appointment['contact_info'] ?></td>

                                <td><?php echo $appointment['serName'] ?></td>

                                <td><?php echo $appointment['serDuration'] ?></td>

                                <td><?php echo $appointment['styName'] ?></td>

                                <td><?php echo $appointment['appointment_date'] ?></td>

                                <td><?php echo $appointment['appointment_time'] ?></td>

                                <td><?php echo $appointment['status'] ?></td>

                                <td>
                                    <div class="table-action-buttons">
                                        <a class="delete button button-box button-xs button-danger"
                                            href="javascript:void(0);"
                                            onclick="confirmDelete(<?php echo $appointment['id']; ?>)"><i
                                                class="zmdi zmdi-delete"></i></a>

                                        <a class="edit button button-box button-xs button-info"
                                            href="editAppointment.php?appointmentId=<?php echo $appointment['id'] ?>"><i
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
        <!-- Manage Stylist List End-->

    </div>

</div><!-- Content Body End -->

<?php
include('components/footer.php')
    ?>

<!-- JavaScript SweetAlert Delete Confirmation -->
<script>
    function confirmDelete(appointmentId) {
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
                // Redirect to PHP deletion script with appointment ID
                window.location.href = "?appointmentRemove=" + appointmentId;
            }
        });
    }
</script>