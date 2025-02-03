<?php
include('components/header.php');

// Check if stylist is logged in
if (!isset($_SESSION['stylistId'])) {
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

// Fetch stylistId from session
$stylistId = intval($_SESSION['stylistId']);
?>

<!-- Content Body Start -->
<div class="content-body">
    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Stylist Appointments</span></h3>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Manage Stylist Appointments Start -->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Contact Info</th>
                            <th scope="col">Service Name</th>
                            <th scope="col">Service Time</th>
                            <th scope="col">Appointment Date</th>
                            <th scope="col">Appointment Time</th>
                            <th scope="col">Commitment Rate</th> <!-- New Column -->
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch appointments for the logged-in stylist
                        $stmt = $pdo->prepare("
                            SELECT appointments.*, services.name AS serName, services.duration AS serDuration, stylists.commission_rate
                            FROM appointments
                            INNER JOIN services ON appointments.service_id = services.id
                            INNER JOIN stylists ON appointments.stylist_id = stylists.id
                            WHERE appointments.stylist_id = :stylist_id
                        ");
                        $stmt->execute(['stylist_id' => $stylistId]);
                        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($appointments as $appointment) {
                            ?>
                            <tr>
                                <td scope="row"><?php echo $appointment['id'] ?></td>
                                <td><?php echo htmlspecialchars($appointment['name']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['contact_info']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['serName']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['serDuration']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                                <td>
                                    <?php
                                    if ($appointment['status'] === 'Cancelled') {
                                        echo 'No Commission';
                                    } elseif ($appointment['commission_rate'] === null || $appointment['commission_rate'] == 0) {
                                        echo '273.44';
                                    } else {
                                        echo number_format($appointment['commission_rate'], 2);
                                    }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Manage Stylist Appointments End -->
    </div>
</div><!-- Content Body End -->

<?php
include('components/footer.php');
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
                window.location.href = "?appointmentRemove=" + appointmentId;
            }
        });
    }
</script>