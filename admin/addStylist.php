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

<!-- Content Body Start -->
<div class="content-body">

    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Add Stylist</span></h3>
            </div>
        </div>
    </div>

    <!-- Add or Edit Stylist Start -->
    <div class="add-edit-product-wrap col-12">
        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">

                <h4 class="title">About Add Stylist</h4>

                <div class="row">
                    <!-- Stylist Name -->
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $stylistName ?>" name="stylistName" class="form-control" type="text"
                            placeholder="Stylist Name / Title*">
                        <small class="text-danger"><?php echo $stylistNameErr ?></small>
                    </div>

                    <!-- Stylist Email -->
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $stylistEmail ?>" name="stylistEmail" class="form-control" type="text"
                            placeholder="Stylist Email*">
                        <small class="text-danger"><?php echo $stylistEmailErr ?></small>
                    </div>

                    <!-- Stylist Password -->
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $stylistPassword ?>" name="stylistPassword" class="form-control"
                            type="password" placeholder="Password*">
                        <small class="text-danger"><?php echo $stylistPasswordErr ?></small>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $stylistContact ?>" name="stylistContact" class="form-control"
                            type="text" placeholder="Contact Info*">
                        <small class="text-danger"><?php echo $stylistContactErr ?></small>
                    </div>

                    <!-- Stylist Description -->
                    <div class="col-12 mb-30">
                        <textarea name="stylistDes" class="form-control"
                            placeholder="Stylist Description*"><?php echo $stylistDes ?></textarea>
                        <small class="text-danger"><?php echo $stylistDesErr ?></small>
                    </div>

                    <!-- Service Selection -->
                    <div class="col-lg-6 col-12 mb-30">
                        <select name="stylistService_id" class="form-control select2" id="service-select">
                            <option value="">Select Service*</option>
                            <?php
                            $query = $pdo->query("SELECT * FROM services");
                            $services = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($services as $service) {
                                echo "<option value='{$service['id']}' data-price='{$service['price']}'>{$service['name']}</option>";
                            }
                            ?>
                        </select>
                        <small class="text-danger"><?php echo $stylistService_idErr; ?></small>
                    </div>

                    <!-- Shift Schedule -->
                    <div class="col-lg-6 col-12 mb-30">
                        <select name="stylistShift_schedule" class="form-control select2">
                            <option value="">Select Shift Schedule*</option>
                            <?php
                            $query = $pdo->query("SELECT * FROM services");
                            $services = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($services as $service) {
                                echo "<option value='{$service['id']}'>{$service['duration']}</option>";
                            }
                            ?>
                        </select>
                        <small class="text-danger"><?php echo $stylistShift_scheduleErr; ?></small>
                    </div>

                    <!-- Commission Rate -->
                    <div class="col-12 mb-30">
                        <input value="<?php echo $stylistCommission_rate; ?>" name="stylistCommission_rate"
                            class="form-control" type="text" placeholder="Commission Rate*" readonly
                            id="commission-rate">
                        <small class="text-danger"><?php echo $stylistCommission_rateErr; ?></small>
                    </div>

                    <!-- Stylist Rating -->
                    <h4 class="title">Stylist Rating</h4>
                    <div class="star-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star" data-value="<?php echo $i; ?>"><i class="ti-star"></i></span>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="stylistRating" id="stylistRating">
                    <small class="text-danger"><?php echo $stylistRatingErr; ?></small>
                </div>

                <h4 class="title pt-20">Stylist Image</h4>
                <div class="product-upload-gallery row flex-wrap">
                    <div class="col-12 mb-30">
                        <p class="form-help-text mt-0">Upload Image</p>
                        <input name="stylistImage" class="file-pond" type="file"
                            accept=".jpg,.jpeg,.png,.webp,.jfif,.avif">
                        <small class="text-danger"><?php echo $stylistImageNameErr; ?></small>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0" name="addStylist">Add
                            Stylist</button>
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

        stars.forEach((star) => {
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
    $(document).ready(function() {
    $('#service-select').change(function() {
        // Get the selected option
        var selectedOption = $(this).find('option:selected');
        
        // Get the service price from the selected option's data attribute
        var servicePrice = parseFloat(selectedOption.data('price'));
        
        // Check if service price is a valid number
        if (!isNaN(servicePrice)) {
            // Calculate the commission (5% of the service price adjusted)
            var commissionRate = (servicePrice / 1.28) * 0.05;
            
            // Set the commission rate in the input field
            $('#commission-rate').val(commissionRate.toFixed(2));
        } else {
            // Clear the commission rate if no valid service is selected
            $('#commission-rate').val('');
        }
    });
});
</script>
