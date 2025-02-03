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
if (isset($_GET["stylistId"])) {
    $stylistId = $_GET["stylistId"];
    $query = $pdo->prepare("
        SELECT stylists.*, 
               services.name AS serName, 
               services.id AS serId, 
               services.duration AS serDuration, 
               services.price AS serPrice
        FROM stylists 
        INNER JOIN services ON stylists.service_id = services.id 
        WHERE stylists.id = :stylistId
    ");
    $query->bindParam("stylistId", $stylistId, PDO::PARAM_INT);
    $query->execute();
    $stylist = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- Content Body Start -->
<div class="content-body">
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Edit Stylist</span></h3>
            </div>
        </div>
    </div>

    <!-- Add or Edit Stylist Start -->
    <div class="add-edit-product-wrap col-12">
        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">
                <h4 class="title">About Edit Stylist</h4>

                <div class="row">
                    <!-- Stylist Name -->
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $stylist['name'] ?>" name="stylistName" class="form-control"
                            type="text" placeholder="Stylist Name / Title*" required>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $stylist['contact_info'] ?>" name="stylistContact" class="form-control"
                            type="text" placeholder="Contact Info*" required pattern="^[0-9]{10,15}$"
                            title="Contact must be 10-15 numeric characters only">
                    </div>

                    <!-- Stylist Description -->
                    <div class="col-12 mb-30">
                        <textarea name="stylistDes" class="form-control" placeholder="Stylist Description*"
                            required><?php echo $stylist['des'] ?></textarea>
                    </div>

                    <!-- Service Selection -->
                    <div class="col-lg-6 col-12 mb-30">
                        <select name="stylistService_id" class="form-control select2" id="service-select">
                            <option value="<?php echo $stylist['serId'] ?>"
                                data-price="<?php echo $stylist['serPrice'] ?>">
                                <?php echo $stylist['serName'] ?>
                            </option>
                            <?php
                            $query = $pdo->prepare("SELECT * FROM services WHERE name != :stylistName");
                            $query->bindParam('stylistName', $stylist['serName']);
                            $query->execute();
                            $services = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($services as $service) {
                                echo "<option value='{$service['id']}' data-price='{$service['price']}'>{$service['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Shift Schedule -->
                    <div class="col-lg-6 col-12 mb-30">
                        <select name="stylistShift_schedule" class="form-control select2">
                            <option value="<?php echo $stylist['serId'] ?>"><?php echo $stylist['serDuration'] ?>
                            </option>
                            <?php
                            $query = $pdo->prepare("SELECT * FROM services WHERE duration != :stylistDuration");
                            $query->bindParam('stylistDuration', $stylist['serDuration']);
                            $query->execute();
                            $services = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($services as $service) {
                                echo "<option value='{$service['id']}'>{$service['duration']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Commission Rate -->
                    <div class="col-12 mb-30">
                        <input value="<?php echo $stylist['commission_rate']; ?>" name="stylistCommission_rate"
                            class="form-control" type="text" placeholder="Commission Rate*" readonly
                            id="commission-rate">
                    </div>

                    <!-- Stylist Rating -->
                    <h4 class="title">Stylist Rating</h4>
                    <div class="star-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star <?php echo $i <= $stylist['rating'] ? 'active' : ''; ?>"
                                data-value="<?php echo $i; ?>">
                                <i class="ti-star"></i>
                            </span>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="stylistRating" id="stylistRating"
                        value="<?php echo $stylist['rating']; ?>" required>
                </div>

                <h4 class="title pt-20">Stylist Image</h4>
                <div class="product-upload-gallery row flex-wrap">
                    <div class="col-12 mb-30">
                        <p class="form-help-text mt-0">Upload Image</p>
                        <input name="stylistImage" class="file-pond" type="file"
                            accept=".jpg,.jpeg,.png,.webp,.jfif,.avif">
                    </div>
                    <img src="assets/images/<?php echo $stylist['image'] ?> " class="product-image rounded-circle"
                        alt="" style="width: 110px; height: 90px; object-fit: cover;">
                </div>

                <!-- Submit Button -->
                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0"
                            name="updateStylist">Update Stylist</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include('components/footer.php');
?>

<!-- JavaScript for Dynamic Service-Shift Integration and Rating System -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stars = document.querySelectorAll(".star");
        const ratingInput = document.getElementById("stylistRating");

        // Set initial rating from database
        const currentRating = parseInt(ratingInput.value);

        // Highlight the stars up to the current rating
        stars.forEach((star, index) => {
            if (index < currentRating) {
                star.classList.add("active");
            }

            // Enable clicking to change rating
            star.addEventListener("click", function () {
                const ratingValue = parseInt(this.getAttribute("data-value"));
                ratingInput.value = ratingValue;

                // Reset all stars
                stars.forEach((s) => s.classList.remove("active"));

                // Set active stars up to the selected one
                for (let i = 0; i < ratingValue; i++) {
                    stars[i].classList.add("active");
                }
            });
        });
    });

    $(document).ready(function () {
        // Function to calculate commission
        function calculateCommission() {
            const selectedOption = $('#service-select').find('option:selected');
            const servicePrice = parseFloat(selectedOption.data('price'));

            if (!isNaN(servicePrice)) {
                const commissionRate = (servicePrice / 1.28) * 0.05;
                $('#commission-rate').val(commissionRate.toFixed(2));
            } else {
                $('#commission-rate').val(''); // Clear if no valid service selected
            }
        }

        // Calculate commission on service change
        $('#service-select').on('change', function () {
            calculateCommission();
        });

        // Initial commission calculation on page load
        calculateCommission();
    });
</script>