<?php
include('components/header.php');



if (!isset($_SESSION['stylistEmail'])) {
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


// Constants for income calculation
define('INCOME_PER_APPOINTMENT', 273.44); // This can be fetched from DB for flexibility

// Initialize income and appointments variables
$totalIncome = 0;
$totalAppointments = 0;
$totalTodayAppointments = 0;

try {
    // Get stylist_id from the session
    if (isset($_SESSION['stylistId'])) {
        $stylistId = intval($_SESSION['stylistId']);

        // Fetch completed appointments and commission rate for the stylist
        $stmt = $pdo->prepare("
            SELECT 
                (SELECT COUNT(*) FROM appointments WHERE stylist_id = :stylist_id AND status = 'Completed') AS completedAppointments,
                (SELECT commission_rate FROM stylists WHERE id = :stylist_id) AS commissionRate
        ");
        $stmt->execute(['stylist_id' => $stylistId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $completedAppointments = $result['completedAppointments'] ?? 0;
            $commissionRate = $result['commissionRate'] ?? 0;

            // Calculate total income
            $totalIncome = ($completedAppointments * INCOME_PER_APPOINTMENT) + $commissionRate;
        }

        // Fetch total appointments for the stylist
        $stmtTotalAppointments = $pdo->prepare("SELECT COUNT(*) AS total FROM appointments WHERE stylist_id = :stylist_id");
        $stmtTotalAppointments->execute(['stylist_id' => $stylistId]);
        $resultTotalAppointments = $stmtTotalAppointments->fetch(PDO::FETCH_ASSOC);
        $totalAppointments = $resultTotalAppointments['total'] ?? 0;

        // Fetch today's appointments for the stylist
        $today = date('Y-m-d');
        $stmtTodayAppointments = $pdo->prepare("SELECT COUNT(*) AS total_today FROM appointments WHERE stylist_id = :stylist_id AND appointment_date = :today");
        $stmtTodayAppointments->execute(['stylist_id' => $stylistId, 'today' => $today]);
        $resultTodayAppointments = $stmtTodayAppointments->fetch(PDO::FETCH_ASSOC);
        $totalTodayAppointments = $resultTodayAppointments['total_today'] ?? 0;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>


<!-- Content Body Start -->
<div class="content-body">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Dashboard <span>/ eCommerce</span></h3>
            </div>
        </div><!-- Page Heading End -->
    </div><!-- Page Headings End -->

    <!-- Top Report Wrap Start -->
    <div class="row">
        <!-- Display Per Head Income -->
        <div class="col-xlg-4 col-md-6 col-12 mb-30">
            <div class="top-report">
                <div class="head pt-10">
                    <h4>Per Head Income</h4>
                    <a href="" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>
                <div class="content pt-30 pb-20">
                    <h2 class="text-center">$<?php echo number_format($totalIncome, 2); ?></h2>
                </div>
            </div>
        </div>

        <!-- Display Total Appointments -->
        <div class="col-xlg-4 col-md-6 col-12 mb-30">
            <div class="top-report">
                <div class="head pt-10">
                    <h4>Total Appointments</h4>
                    <a href="viewuser.php" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>
                <div class="content pt-30 pb-20">
                    <h2 class="text-center"><?php echo number_format($totalAppointments); ?></h2>
                </div>
            </div>
        </div>

        <!-- Display Today's Appointments -->
        <div class="col-xlg-4 col-md-6 col-12 mb-30">
            <div class="top-report">
                <div class="head pt-10">
                    <h4>Today's Appointments</h4>
                    <a href="viewuser.php" class="view"><i class="zmdi zmdi-eye pt-10"></i></a>
                </div>
                <div class="content pt-30 pb-20">
                    <h2 class="text-center"><?php echo number_format($totalTodayAppointments); ?></h2>
                </div>
            </div>
        </div>
    </div><!-- Top Report Wrap End -->

    <div class="row mbn-30">
        <!-- Recent Transaction Start -->
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <h4 class="title">Recent Appointments</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-vertical-middle table-selectable">
                            <thead>
                                <tr>
                                    <th class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                                class="icon"></i></label></th>
                                    <th><span>Client Name</span></th>
                                    <th><span>Service Name</span></th>
                                    <th><span>Appointment ID</span></th>
                                    <th><span>Service Duration</span></th>
                                    <th><span>Status</span></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch appointments with service details
                                $stmt = $pdo->prepare("
                                    SELECT appointments.*, services.name AS serName, services.duration AS serDuration
                                    FROM appointments
                                    INNER JOIN services ON appointments.service_id = services.id
                                    WHERE appointments.stylist_id = :stylist_id
                                ");
                                $stmt->execute(['stylist_id' => $stylistId]);
                                $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($appointments as $appointment) {
                                    ?>
                                    <tr>
                                        <td class="selector"><label class="adomx-checkbox"><input type="checkbox"> <i
                                                    class="icon"></i></label></td>
                                        <td><a href="#"><?php echo htmlspecialchars($appointment['name']); ?></a></td>
                                        <td><?php echo htmlspecialchars($appointment['serName']); ?></td>
                                        <td>#<?php echo $appointment['id']; ?></td>
                                        <td><?php echo htmlspecialchars($appointment['serDuration']); ?></td>
                                        <td>
                                            <span
                                                class="badge
                                                <?php echo ($appointment['status'] == 'Paid') ? 'badge-success' :
                                                    ($appointment['status'] == 'Due' ? 'badge-warning' : 'badge-danger'); ?>">
                                                <?php echo htmlspecialchars($appointment['status']); ?>
                                            </span>
                                        </td>
                                        <td><a class="h3" href="#"><i class="zmdi zmdi-more"></i></a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Recent Transaction End -->
    </div><!-- Row End -->

</div><!-- Content Body End -->

<?php
include('components/footer.php');
?>
<?php
// Fetch the stylist's last schedule from the database
$sql = "SELECT * FROM schedule_list WHERE stylist_id = :stylist_id ORDER BY start_datetime DESC LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':stylist_id', $_SESSION['stylistId'], PDO::PARAM_INT);
$stmt->execute();
$schedule = $stmt->fetch(PDO::FETCH_ASSOC);
if ($schedule) {
    try {
        $current_date = new DateTime();
        $start_date = new DateTime($schedule['start_datetime']);
        $end_date = new DateTime($schedule['end_datetime']);

        if ($current_date >= $start_date && $current_date <= $end_date) {
            $title = htmlspecialchars($schedule['title']);
            $description = htmlspecialchars($schedule['description']);

            echo "<script>
                Swal.fire({
                    title: 'Schedule Reminder',
                    text: 'You have the schedule ' + " . json_encode($title) . " + 
                          '. Description: ' + " . json_encode($description) . " + 
                          ' from " . $start_date->format('Y-m-d H:i') . " to " . $end_date->format('Y-m-d H:i') . "!',
                    icon: 'info',
                    confirmButtonText: 'Got it!'
                });
            </script>";

            if (!$schedule['reminder_shown']) {
                $update_sql = "UPDATE schedule_list SET reminder_shown = 1 WHERE id = :schedule_id";
                $update_stmt = $pdo->prepare($update_sql);
                $update_stmt->bindParam(':schedule_id', $schedule['id'], PDO::PARAM_INT);
                $update_stmt->execute();
            }
        }
    } catch (Exception $e) {
        echo "<script>alert('Error processing schedule dates: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>
        Swal.fire({
            title: 'No Schedule',
            text: 'No upcoming schedules found for this stylist.',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    </script>";
}

?>