<?php

include('components/header.php');

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

$aName = $aNamel = $aEmail = $aContact = $appointment_date = $aStylist_id = $aService_id = "";

// Check if the form has been submitted
if (isset($_POST['aSubmit'])) {
    $aName = htmlspecialchars(trim($_POST['aName']));
    $aNamel = htmlspecialchars(trim($_POST['aNamel']));
    $aEmail = htmlspecialchars(trim($_POST['aEmail']));
    $aContact = htmlspecialchars(trim($_POST['aContact']));
    $appointment_date = htmlspecialchars(trim($_POST['appointment_date']));
    $aStylist_id = htmlspecialchars(trim($_POST['aStylist_id']));
    $aService_id = htmlspecialchars(trim($_POST['aService_id']));

    $fullName = $aName . ' ' . $aNamel;

    // Check if user_id is in session
    if (isset($_SESSION['userId'])) {
        $user_id = $_SESSION['userId'];  // Get user_id from session
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Unauthorized Access!',
                    text: 'User ID is missing!',
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

    // Check for duplicate email
    $checkEmailQuery = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE email = :aEmail");
    $checkEmailQuery->bindParam(":aEmail", $aEmail);
    $checkEmailQuery->execute();
    $emailExists = $checkEmailQuery->fetchColumn();

    // Prepare and execute the query
    $query = $pdo->prepare("INSERT INTO appointments (name, email, contact_info, appointment_date, stylist_id, service_id, user_id) 
                            VALUES (:fullName, :aEmail, :aContact, :appointment_date, :aStylist_id, :aService_id, :user_id)");

    $query->bindParam(":fullName", $fullName);
    $query->bindParam(":aEmail", $aEmail);
    $query->bindParam(":aContact", $aContact);
    $query->bindParam(":appointment_date", $appointment_date);
    $query->bindParam(":aStylist_id", $aStylist_id);
    $query->bindParam(":aService_id", $aService_id);
    $query->bindParam(":user_id", $user_id);  // Bind user_id

    $query->execute();

    // Success SweetAlert message
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Appointment Booked!',
                    text: 'Your appointment has been booked successfully.',
                    background: '#333',
                    color: '#fff',
                    confirmButtonColor: '#3085d6',
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
                <h3>eCommerce <span>/ Book Appointment</span></h3>
            </div>
        </div>
    </div>

    <div class="add-edit-product-wrap col-12">
        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">
                <h4 class="title">About Book Appointment</h4>

                <div class="row">
                    <!-- Form fields for appointment details -->
                    <div class="col-lg-6 col-12 mb-30">
                        <label for="">First Name</label>
                        <input value="<?php echo $aName ?>" name="aName" class="form-control" type="text"
                            placeholder="First Name*" required>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <label for="">Last Name</label>
                        <input value="<?php echo $aNamel ?>" class="form-control" type="text" name="aNamel"
                            placeholder="Last Name*" required>
                    </div>

                    <div class="col-12 mb-30">
                        <label for="">Email</label>
                        <input value="<?php echo $aEmail ?>" class="form-control" type="email" name="aEmail"
                            placeholder="Example: zudfra@email.com" required pattern="^[a-z][a-z0-9]*@gmail\.com$"
                            title="Please enter a valid Gmail address">
                    </div>

                    <div class="col-12 mb-30">
                        <label for="">Contact info</label>
                        <input value="<?php echo $aContact ?>" name="aContact" class="form-control" type="text"
                            placeholder="Contact Info*" pattern="^\d{10,15}$"
                            title="Please enter a valid contact number with 10 to 15 digits." required>
                    </div>

                    <div class="col-12 mb-30">
                        <label for="appointment_date">Appointment Date</label>
                        <input type="date" id="appointment_date" name="appointment_date" class="form-control" required>
                    </div>


                    <div class="col-lg-6 col-12 mb-30">
                        <label for="">Service</label>
                        <select name="aService_id" class="form-control select2" id="service-select" required>
                            <option value="">Select Service*</option>
                            <?php
                            // Fetch and display services from the database
                            $query = $pdo->query("SELECT * FROM services");
                            $services = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($services as $service) {
                                echo "<option value='{$service['id']}'>{$service['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-6 col-12 mb-30">
                        <label for="service_id">Stylist</label>
                        <select name="aStylist_id" class="form-control select2" id="stylist-select" required>
                            <option value="">Select Stylist*</option>
                        </select>
                    </div>

                    <script>
                        // Function to update stylists based on selected service
                        document.getElementById('service-select').addEventListener('change', function () {
                            var serviceId = this.value;  // Get the selected service ID
                            var stylistSelect = document.getElementById('stylist-select');

                            // Clear the previous stylist options
                            stylistSelect.innerHTML = "<option value=''>Select Stylist*</option>";

                            if (serviceId) {
                                // Make an AJAX request to fetch stylists for the selected service
                                var xhr = new XMLHttpRequest();
                                xhr.open('GET', 'getStylists.php?service_id=' + serviceId, true);
                                xhr.onload = function () {
                                    if (xhr.status === 200) {
                                        // Update the stylist select options with the response
                                        stylistSelect.innerHTML += xhr.responseText;
                                    }
                                };
                                xhr.send();
                            }
                        });
                    </script>

                    <div class="col-12 mb-30">
                        <button name="aSubmit" class="btn btn-outline-primary">Book Appointment</button>
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