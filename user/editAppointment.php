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
?>

<?php
if (isset($_GET["appointmentId"])) {
    $appointmentId = $_GET["appointmentId"];
    $query = $pdo->prepare("
        SELECT appointments.*, 
               SUBSTRING_INDEX(appointments.name, ' ', 1) AS firstName, 
               SUBSTRING_INDEX(appointments.name, ' ', -1) AS lastName, 
               stylists.name AS styName, 
               stylists.id AS styId, 
               services.name AS serName, 
               services.id AS serId, 
               services.duration AS serDuration
        FROM appointments 
        INNER JOIN stylists ON appointments.stylist_id = stylists.id 
        INNER JOIN services ON appointments.service_id = services.id 
        WHERE appointments.id = :appointmentId
    ");
    $query->bindParam(":appointmentId", $appointmentId);
    $query->execute();
    $appointment = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<?php
if (isset($_POST['aSubmit'])) {
    $appointmentId = htmlspecialchars(trim($_GET['appointmentId']));
    $appointment_date = htmlspecialchars(trim($_POST['appointment_date']));

    $query = $pdo->prepare("
    UPDATE appointments 
    SET appointment_date = :appointment_date
    WHERE id = :appointmentId
");

    $query->bindParam(":appointment_date", $appointment_date);
    $query->bindParam(":appointmentId", $appointmentId);

    $query->execute();
    // Success SweetAlert message
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Appointment updated!',
            text: 'Appointment updated successfully.',
            background: '#333',
            color: '#fff',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'viewAppointment.php';
            }
        });
    });
</script>";
}
?>

<div class="content-body">
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Update Appointment</span></h3>
            </div>
        </div>
    </div>

    <div class="add-edit-product-wrap col-12">
        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">
                <h4 class="title">About Book Appointment</h4>

                <div class="row">

                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $appointment['firstName'] ?>" name="aName" class="form-control" type="text"
                            placeholder="First Name*" disabled>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <input value="<?php echo $appointment['lastName'] ?>" class="form-control" type="text"
                            name="aNamel" placeholder="Last Name*" disabled>
                    </div>

                    <div class="col-12 mb-30">
                        <input value="<?php echo $appointment['email'] ?>" class="form-control" type="email"
                            name="aEmail" placeholder="Example: zudfra@email.com" disabled
                            pattern="^[a-z][a-z0-9]*@gmail\.com$"
                            title="Please enter a valid Gmail address">
                    </div>

                    <div class="col-12 mb-30">
                        <input value="<?php echo $appointment['contact_info'] ?>" name="aContact" class="form-control"
                            type="text" placeholder="Contact Info*" pattern="^\d{10,15}$"
                            title="Please enter a valid contact number with 10 to 15 digits." disabled>
                    </div>

                    <div class="col-12 mb-30">
                        <input type="date" value="<?php echo $appointment['appointment_date'] ?>" id="appointment_date" name="appointment_date" class="form-control" required>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <select name="aService_id" class="form-control select2" disabled>
                            <option value="<?php echo $appointment['serId']; ?>"><?php echo $appointment['serName']; ?></option>
                            <?php
                            $query = $pdo->prepare("SELECT * FROM services WHERE name != :serviceName");
                            $query->bindParam('serviceName', $appointment['serName']);
                            $query->execute(); // Add this line
                            $services = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($services as $service) {
                                echo "<option value='{$service['id']}'>{$service['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <select name="aStylist_id" class="form-control select2" disabled>
                            <option value="<?php echo $appointment['styId']; ?>"><?php echo $appointment['styName']; ?></option>
                            <?php
                            $query = $pdo->prepare("SELECT * FROM stylists WHERE name != :stylistName");
                            $query->bindParam('stylistName', $appointment['styName']);
                            $query->execute(); // Add this line
                            $stylists = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($stylists as $stylist) {
                                echo "<option value='{$stylist['id']}'>{$stylist['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 mb-30">
                        <select name="aShift_schedule" class="form-control select2" disabled>
                            <option value="<?php echo $appointment['serId'] ?>"><?php echo $appointment['serDuration'] ?>
                            </option>
                            <?php
                            $query = $pdo->prepare("SELECT * FROM services WHERE duration != :aDuration");
                            $query->bindParam('aDuration', $appointment['serDuration']);
                            $query->execute();
                            $services = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($services as $service) {
                                echo "<option value='{$service['id']}'>{$service['duration']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0" name="aSubmit">update Appointment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include('components/footer.php');
?>

<script>
    document.getElementById('appointment_date').setAttribute('min', new Date().toISOString().split('T')[0]);
</script>