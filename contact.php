<?php
include('components/header.php');
?>
<?php
$isLoggedIn = isset($_SESSION['userEmail']); // Check if the user is logged in based on the 'user_d' session variable
?>
<?php
// Initialize form variables
$cName = $cNamel = $cEmail = $cNote = "";

// Check if the form has been submitted
if (isset($_POST["cSubmit"])) {
    $cName = htmlspecialchars(trim($_POST["cName"]));
    $cNamel = htmlspecialchars(trim($_POST["cNamel"]));
    $cEmail = htmlspecialchars(trim($_POST["cEmail"]));
    $cNote = htmlspecialchars(trim($_POST["cNote"]));

    $fullName = $cName . ' ' . $cNamel;

    if ($isLoggedIn) {
        // Get the logged-in user's ID from session (user_d stores user_id)
        $userId = $_SESSION['userId'];

        // Prepare and execute the query to insert data into the 'contact' table
        $query = $pdo->prepare("INSERT INTO contact(name, email, note, user_id) VALUES(:fullName, :cEmail, :cNote, :userId)");
        $query->bindParam(":fullName", $fullName);
        $query->bindParam(":cEmail", $cEmail);
        $query->bindParam(":cNote", $cNote);
        $query->bindParam(":userId", $userId);
        $query->execute();

        // Success SweetAlert message if form is successfully submitted
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Message Sent!',
                    text: 'Thank you for reaching out! We will get back to you shortly.',
                    background: '#f5e6e0',
                    color: '#6b4e3d',
                    confirmButtonColor: '#d4a373',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = 'contact.php'; // Redirect to contact page after successful submission
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

<main class="main-content" style="padding: 80px 0;">
    <!--== Start Contact Area Wrapper ==-->
    <section class="contact-area">
        <div class="container">
            <div class="row">
                <div class="offset-lg-6 col-lg-6">
                    <div class="section-title position-relative">
                        <h2 class="title">Get in touch</h2>
                        <p class="m-0">Have questions or anything in your mind? We’re here to help! Contact us, and we’ll get back to you as soon as possible.</p>
                        <div class="line-left-style mt-4 mb-1" style="width : 80% !important;"></div>
                    </div>
                    <!--== Start Contact Form ==-->
                    <div class="contact-form">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input value="<?php echo $cName ?>" class="form-control" type="text" name="cName" placeholder="First Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input value="<?php echo $cNamel ?>" class="form-control" type="text" name="cNamel" placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input value="<?php echo $cEmail ?>" class="form-control" type="email" name="cEmail" placeholder="Email address" required pattern="^[a-z][a-z0-9]*@gmail\.com$" title="Please enter a valid Gmail address">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="cNote" placeholder="Message" required><?php echo $cNote ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <button class="btn btn-sm" type="submit" name="cSubmit" id="submitBtn">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="contact-left-img" data-bg-img="assets/images/contact.jpg"></div>
                    </div>
                    <!--== End Contact Form ==-->
                </div>
            </div>
        </div>
    </section>
    <!--== Start Contact Area Wrapper ==-->
    <section class="section-space">
        <div class="container">
            <div class="contact-info">
                <div class="contact-info-item">
                    <img class="icon" src="assets/images/icons/1.webp" width="30" height="30" alt="Icon">
                    <a href="tel://+11020303023">+92 3676440986</a>
                    <a href="tel://+11020303023">+92 3672849337</a>
                </div>
                <div class="contact-info-item">
                    <img class="icon" src="assets/images/icons/2.webp" width="30" height="30" alt="Icon">
                    <a href="mailto://ubaidakhter52@gmail.com">ubaidakhter52@gmail.com</a>
                    <a href="mailto://ayan@gmail.com">ayan@gmail.com</a>
                </div>
                <div class="contact-info-item mb-0">
                    <img class="icon" src="assets/images/icons/3.webp" width="30" height="30" alt="Icon">
                    <p>Aptech, Shahra-e-faisal, 28468</p>
                </div>
            </div>
        </div>
    </section>

    <!--== End Contact Area Wrapper ==-->

    <div class="map-area">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d802879.9165497769!2d144.83475730949783!3d-38.180874157285366!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad646b5d2ba4df7%3A0x4045675218ccd90!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2sbd!4v1636803638401!5m2!1sen!2sbd"></iframe>
    </div>
</main>

<?php
include('components/footer.php');
?>