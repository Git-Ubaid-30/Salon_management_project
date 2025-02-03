<?php
// Include the database connection
include('../query.php');

// Check if appointment ID and status are set
if (isset($_POST['appointment_id']) && isset($_POST['status'])) {
    $appointmentId = intval($_POST['appointment_id']);  // Get the appointment ID
    $newStatus = $_POST['status'];  // Get the new status

    // Fetch the current status and stylist_id of the appointment
    $stmt = $pdo->prepare("SELECT status, stylist_id FROM appointments WHERE id = :appointment_id");
    $stmt->execute(['appointment_id' => $appointmentId]);
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($appointment) {
        $currentStatus = $appointment['status'];
        $stylistId = $appointment['stylist_id'];

        // Fetch the commission rate for the stylist
        $stmt = $pdo->prepare("SELECT commission_rate FROM stylists WHERE id = :stylist_id");
        $stmt->execute(['stylist_id' => $stylistId]);
        $stylist = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stylist) {
            $commissionRate = $stylist['commission_rate'];  // Get the commission rate

            // Calculate income changes based on status change
            if ($currentStatus != $newStatus) {
                // Check if status was not 'Completed' and now is, add commission
                if ($newStatus == 'Completed' && $currentStatus != 'Completed') {
                    $stmt = $pdo->prepare("UPDATE stylists SET commission_rate = commission_rate + :commission_rate WHERE id = :stylist_id");
                    $stmt->execute(['commission_rate' => $commissionRate, 'stylist_id' => $stylistId]);
                }
                // Check if status was not 'Cancelled' and now is, subtract commission
                elseif ($newStatus == 'Cancelled' && $currentStatus != 'Cancelled') {
                    $stmt = $pdo->prepare("UPDATE stylists SET commission_rate = commission_rate - :commission_rate WHERE id = :stylist_id");
                    $stmt->execute(['commission_rate' => $commissionRate, 'stylist_id' => $stylistId]);
                }
            }
        }

        // Update the appointment status in the database
        $stmt = $pdo->prepare("UPDATE appointments SET status = :status WHERE id = :appointment_id");
        $stmt->execute([
            'status' => $newStatus,
            'appointment_id' => $appointmentId
        ]);
    }

    // Redirect back to the stylist appointments page to see the updated status
    header("Location: history.php");
    exit();
} else {
    // If no data is set, redirect back to appointments page
    header("Location: history.php");
    exit();
}
?>