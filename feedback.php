<?php
include('components/header.php');
?>

<!-- category -->

<?php
$isLoggedIn = isset($_SESSION['userEmail']); // Check if the user is logged in based on the 'user_d' session variable

// Initialize variables
$fName = $cRating = $pRating = $fTital = $fReview = $fEmail = "";

// Check if the form has been submitted
if (isset($_POST["fSubmit"])) {
    $fName = htmlspecialchars(trim($_POST["fName"]));
    $cRating = htmlspecialchars(trim($_POST["cRating"]));
    $pRating = htmlspecialchars(trim($_POST["pRating"]));
    $fTital = htmlspecialchars(trim($_POST["fTital"]));
    $fReview = htmlspecialchars(trim($_POST["fReview"]));
    $fEmail = htmlspecialchars(trim($_POST["fEmail"]));

    if ($isLoggedIn) {
        $userId = $_SESSION['userId'];
        // Database insertion
        $query = $pdo->prepare("INSERT INTO feedback (name, service_rating, product_rating, review, tital, email, user_id) VALUES (:fName, :cRating, :pRating, :fReview, :fTital, :fEmail, :userId)");
        $query->bindParam(":fName", $fName);
        $query->bindParam(":cRating", $cRating);
        $query->bindParam(":pRating", $pRating);
        $query->bindParam(":fTital", $fTital);
        $query->bindParam(":fReview", $fReview);
        $query->bindParam(":fEmail", $fEmail);
        $query->bindParam(":userId", $userId);  // Ensure you're binding the userId
        $query->execute();

        // SweetAlert Success Message
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Form Submitted!',
                text: 'Thank you for your feedback!',
                background: '#f5e6e0',
                color: '#6b4e3d',
                confirmButtonColor: '#d4a373',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'feedback.php';
                }
            });
        });
    </script>";
    } else {
        // If not logged in, show the login prompt
        echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  icon: 'warning',
                  background: '#f5e6e0',
                  color: '#6b4e3d',
                  title: 'Please log in',
                  text: 'You need to be logged in to submit the form.',
                  confirmButtonText: 'OK',
                  preConfirm: () => {
                      window.location.href = 'login.php'; // Redirect to login page
                  }
              });
          });
      </script>";
    }
}
?>

<style>
    .starRating {
        display: flex;
        align-items: center;
        gap: 40px;
        /* Adds spacing between stars */
        margin-bottom: 1rem;
    }

    .rating {
        border-radius: 30px;
        background-color: rgb(255, 255, 255);
        box-shadow: 0px 0px 90px 0px rgba(19, 19, 19, 0.11);
        width: 100%;
        min-height: 300px;
        overflow: hidden;
        display: grid;
    }

    /* Star icons */
    .p_star i,
    .c_star i {
        color: rgb(235, 233, 255);
        font-size: 30px;
        cursor: pointer;
        transition: color 0.3s;
    }

    /* Active star */
    .p_star.active i,
    .c_star.active i {
        color: gold;
    }

    .ratingWrapper p {
        margin: 0;
        color: #555;
        font-size: 14px;
    }

    /* Positioning adjustments */
    .starRating p {
        margin-left: 10px;
        /* Aligns rating prompt with stars */
        font-size: 14px;
        color: #333;
    }

    .starRating span i {
        border: solid 3px rgb(235, 233, 255);
        background-color: rgb(255, 255, 255);
        width: 210%;
        border-radius: 5px;
        height: 60px;
        font-size: 30px;
        color: rgb(230, 230, 230);
        display: grid;
        place-content: center;
        cursor: pointer;
    }

    .sub {
        width: 100%;
        background-color: rgb(18, 22, 51);
        height: 61px;
        font-size: 14px;
        color: rgb(255, 255, 255);
        font-weight: bold;
        position: relative;
        z-index: 10;
        border: solid 2px transparent;
    }

    .sub i {
        font-size: 15px;
        color: rgb(254, 198, 78);
        margin: 0 10px;
        position: relative;
        top: 1px;
        position: absolute;
        top: 53%;
        right: 35%;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: 0.4s;
    }

    .sub:hover i {
        right: 28%;
        opacity: 1;
    }
</style>

<main class="overflow-hidden">

    <!-- background -->
    <div class="rating_bg">
        <img src="assets/images/img/bg.jpg" alt="bg">
        <img src="assets/images/img/lines.png" alt="line">
    </div>
    <div class="container">
        <div class="wrapper">
            <div class="row" style="padding: 80px 0;">
                <div class="col-md-6 order_c">

                    <!-- side -->
                    <div class="side">
                        <h2>
                            Refresh Your Look
                            <br />
                            Share Your Experience
                        </h2>
                    </div>

                </div>
                <div class="ms-auto col-md-6 tab-100">
                    <div class="rating rating-reveal">
                        <div class="ratingWrapper">

                            <!-- form -->
                            <form method="post" action="">
                                <h1 class="mainHeading">Salon Rating</h1>

                                <!-- star Rating -->
                                <div class="starRating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="p_star" data-value="<?php echo $i; ?>"><i
                                                class="zmdi zmdi-star"></i></span>
                                    <?php endfor; ?>
                                </div>
                                <p>Click to rate your salon experience</p>
                                <input type="hidden" name="pRating" id="pRating">


                                <!-- star Rating -->
                                <div class="starRating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="c_star" data-value="<?php echo $i; ?>"><i
                                                class="zmdi zmdi-star"></i></span>
                                    <?php endfor; ?>
                                </div>
                                <p>Click to rate the product you purchased</p>
                                <input type="hidden" name="cRating" id="cRating">



                                <!-- Fields -->
                                <div class="inputField">
                                    <label class="labelTxt" for="title">Review Title</label>
                                    <input value="<?php echo $fTital ?>" class="textField" type="text" name="fTital"
                                        placeholder="Example : Amazing service/product!" required>
                                </div>
                                <div class="inputField">
                                    <label class="labelTxt" for="message">Product/Service Review</label>
                                    <textarea class="textField" name="fReview" col="50"
                                        placeholder="Tell us about your visit, services, or products you purchased."
                                        required><?php echo $fReview ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 lap-100">
                                        <div class="inputField">
                                            <label class="labelTxt" for="name">Nickname</label>
                                            <input value="<?php echo $fName ?>" class="textField" type="text"
                                                name="fName" placeholder="Example : Zudfra" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 lap-100">
                                        <div class="inputField">
                                            <label class="labelTxt" for="email">Email address</label>
                                            <input value="<?php echo $fEmail ?>" class="textField" type="email"
                                                name="fEmail" placeholder="Example: zudfra@email.com" required
                                                pattern="^[a-z][a-z0-9]*@gmail\.com$"
                                                title="Please enter a valid Gmail address">
                                        </div>
                                    </div>
                                </div>
                                <h5 class=" formTxt">
                                    We value your feedback! Let us know how we can improve your experience, and
                                    feel
                                    free to share any suggestions.
                                </h5>

                                <!-- shapes -->
                                <img class="shape1" src="assets/images/img/shape1.png" alt="shape" />
                                <img class="shape2" src="assets/images/img/shape1.png" alt="shape" />
                        </div>

                        <!-- submit button -->
                        <button class="sub" type="submit" name="fSubmit">Submit Feedback</button>

                        </form>





                    </div>
                </div>
            </div>
        </div>
    </div>

</main>


<?php
include('components/footer.php');
?>

<script>
    // JavaScript for Dynamic Service-Shift Integration and Rating System
    document.addEventListener("DOMContentLoaded", function() {
        const stars = document.querySelectorAll(".p_star");
        const ratingInput = document.getElementById("pRating");

        stars.forEach((star) => {
            star.addEventListener("click", function() {
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
    document.addEventListener("DOMContentLoaded", function() {
        const stars = document.querySelectorAll(".c_star");
        const ratingInput = document.getElementById("cRating");

        stars.forEach((star) => {
            star.addEventListener("click", function() {
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
</script>