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

// Query to fetch appointments for the logged-in stylist
$query = "
    SELECT 
        appointments.id,
        appointments.name,
        appointments.email AS contact_info,
        services.name AS serName,
        services.duration AS serDuration,
        appointments.appointment_date,
        appointments.appointment_time,
        appointments.status
    FROM 
        appointments
    INNER JOIN 
        services ON appointments.service_id = services.id
    WHERE 
        appointments.stylist_id = :stylist_id
";

$stmt = $pdo->prepare($query);
$stmt->execute(['stylist_id' => $stylistId]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Content Body Start -->
<div class="content-body">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Stylist Appointments</span></h3>
            </div>
        </div><!-- Page Heading End -->
    </div><!-- Page Headings End -->

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
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display each appointment
                        foreach ($appointments as $appointment) {
                            ?>
                            <tr>
                                <td scope="row"><?php echo $appointment['id']; ?></td>
                                <td><?php echo htmlspecialchars($appointment['name']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['contact_info']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['serName']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['serDuration']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                                <td>
                                    <form method="POST" action="updateStatus.php" class="status-form">
                                        <input type="hidden" name="appointment_id"
                                            value="<?php echo $appointment['id']; ?>" />
                                        <div class="select-wrapper">
                                            <select name="status" onchange="this.form.submit()"
                                                class="styled-select select2">
                                                <option value="Approve" <?php echo $appointment['status'] == 'Approve' ? 'selected' : ''; ?>>Approve</option>
                                                <option value="Approved" <?php echo $appointment['status'] == 'Approved' ? 'selected' : ''; ?>>Approved</option>
                                                <option value="Cancelled" <?php echo $appointment['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                <option value="Completed" <?php echo $appointment['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                            </select>
                                        </div>
                                    </form>
                                </td>
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