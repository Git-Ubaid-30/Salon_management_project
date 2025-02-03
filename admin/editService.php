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

<?php
if (isset($_GET["serviceId"])) {
    $serviceId = $_GET["serviceId"];
    $query = $pdo->prepare("select * from services where id = :serviceId");
    $query->bindParam("serviceId", $serviceId);
    $query->execute();
    $service = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- Content Body Start -->
<div class="content-body">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Edit Service</span></h3>
            </div>
        </div><!-- Page Heading End -->

    </div><!-- Page Headings End -->

    <!-- Add or Edit Service Start -->
    <div class="add-edit-product-wrap col-12">

        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">

                <h4 class="title">About Edit Service</h4>

                <div class="row">
                    <div class="col-lg-6 col-12 mb-30"><input value="<?php echo $service['name'] ?>" name="serviceName"
                            class="form-control" type="text" placeholder="Service Name / Title*" required>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $service['price'] ?>" name="servicePrice" class="form-control"
                            type="text" placeholder="Service Price*" pattern="^(?!0)\d+(\.\d{1,2})?$"
                            title="Please enter a valid positive number. Decimals up to two places are allowed."
                            required>
                    </div>

                    <div class="col-12 mb-30"><textarea name="serviceDes" class="form-control"
                            placeholder="Service Description*" required><?php echo $service['des'] ?></textarea>
                    </div>

                    <div class="col-12 mb-30">
                        <input value="<?php echo htmlspecialchars($service['duration']); ?>" name="serviceDuration"
                            class="form-control" type="text" id="serviceDuration"
                            placeholder="Service Duration (e.g., morning/afternoon/evening/night & Time Duration like (am/pm))"
                            required oninput="validateServiceDuration(this)">
                    </div>

                </div>

                <h4 class="title">Service Image</h4>
                <div class="product-upload-gallery row flex-wrap">
                    <div class="col-12 mb-30">
                        <p class="form-help-text mt-0">Upload Image</p>
                        <input name="serviceImage" class="file-pond" type="file" accept=".jpg,.jpeg,.png,.webp,.jfif,.avif">
                    </div>
                    <img src="assets/images/<?php echo $service['image'] ?> " class="product-image rounded-circle"
                        alt="" style="width: 110px; height: 90px; object-fit: cover;">
                </div>

                <!-- Button Group Start -->
                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0"
                            name="updateService">Update
                            Service</button>
                    </div>
                </div><!-- Button Group End -->

            </form>
        </div>

    </div><!-- Add or Edit Service End -->

</div><!-- Content Body End -->

<?php
include('components/footer.php');
?>

<script>
    function validateServiceDuration(input) {
        const durationPattern = /^(morning|afternoon|evening|night) \d{1,2}(am|pm) to \d{1,2}(am|pm)$/i;

        // Clear any previous validation errors
        input.setCustomValidity("");

        // Check if the duration format is correct
        if (!durationPattern.test(input.value)) {
            input.setCustomValidity("Invalid format. Use 'morning|afternoon|evening|night & Time Duration like (am/pm)'");
        } else {
            // Split the input into period, start time, and end time
            const [period, startTime, endTime] = input.value.trim().toLowerCase().replace(' to ', ' ').split(' ');
            const startPeriod = startTime.slice(-2);
            const endPeriod = endTime.slice(-2);

            // Additional validation based on the period
            if (period === "morning" && (startPeriod !== "am" || endPeriod !== "am")) {
                input.setCustomValidity("For morning, only 'am' times are allowed.");
            } else if (period === "afternoon" && (startPeriod !== "pm" || endPeriod !== "pm")) {
                input.setCustomValidity("For afternoon, only 'pm' times are allowed.");
            } else if (period === "evening" && (startPeriod !== "pm" || endPeriod !== "pm")) {
                input.setCustomValidity("For evening, only 'pm' times are allowed.");
            } else if (period === "night" && !((startPeriod === "pm" && endPeriod === "am") || (startPeriod === "am" && endPeriod === "am"))) {
                input.setCustomValidity("For night, the time should start in 'pm' and end in 'am', or be within 'am' for early morning.");
            }
        }

        // Display the custom validity message if any is set
        input.reportValidity();
    }
</script>