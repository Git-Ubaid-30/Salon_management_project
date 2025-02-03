<?php

include('components/header.php');

?>



<?php
if (isset($_GET["sId"])) {
    $sId = $_GET["sId"];
    $query = $pdo->prepare("select * from services where id = :sId");
    $query->bindParam("sId", $sId);
    $query->execute();
    $service = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<style>
    .post-item .content .post-category {
        background-color: #ff9c9c;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
        border-radius: 50px;
        padding: 10px 31px;
        transition: all .5s ease 0s
    }
</style>


<main class="main-content" style="padding: 140px 0;">

    <!--== Start Blog Area Wrapper ==-->
    <section class="section-space pt-0">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6 col-xl-12 mb-8">
                            <!--== Start Blog Item ==-->
                            <div class="post-item">
                                <img src="admin/assets/images/<?php echo $service['image'] ?>" width="770" height="320" alt="Image-HasTech">
                                <div class="content">
                                    <h4 class="title"><?php echo $service['name'] ?></h4>
                                    <p><?php echo $service['des'] ?></p>
                                    <p><?php echo $service['price'] ?></p>
                                    <p><?php echo $service['duration'] ?></p>
                                </div>
                            </div>
                            <!--== End Blog Item ==-->
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="blog-sidebar-widget">
                        <div class="blog-widget">
                            <h4 class="blog-widget-title">Services</h4>
                            <ul class="blog-widget-category">
                                <?php
                                // Fetch all services from the 'services' table
                                $query = $pdo->query("SELECT id, name FROM services");
                                $services = $query->fetchAll(PDO::FETCH_ASSOC);

                                // Loop through each service and create a link
                                foreach ($services as $service) {
                                    echo '<li><a href="service-detail.php?sId=' . $service['id'] . '">' . htmlspecialchars($service['name']) . '</a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="blog-widget">
                            <h4 class="blog-widget-title">Professionals</h4>
                            <div class="blog-widget-post">
                                <?php
                                $query = $pdo->query("SELECT stylists.*, services.name as serName
                                    FROM stylists
                                    INNER JOIN services ON stylists.service_id = services.id limit 3");
                                $allStylists = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($allStylists as $stylists) {
                                ?>
                                    <div class="blog-widget-single-post">
                                        <img src="admin/assets/images/<?php echo $stylists['image'] ?>" width="75" height="78" alt="Images">
                                        <span class="title"><?php echo $stylists['name'] ?></span> </br>
                                        <span>Specialty:<span class="date"><?php echo $stylists['serName'] ?></span></span>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="blog-widget mb-0">
                            <h4 class="blog-widget-title">Book Appointment Here</h4>
                            <div class="post-item">
                                <div class="content">
                                    <a href="user/addAppointment.php" style="border : none;" class="post-category" href="feedback.php">Book Appointment</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Blog Area Wrapper ==-->

    <!--== Start News Letter Area Wrapper ==-->
    <section class="section-space pt-0 pb-0">
        <div class="container">
            <div class="newsletter-content-wrap" data-bg-img="assets/images/photos/bg1.webp">
                <div class="newsletter-content">
                    <div class="section-title mb-0">
                        <h2 class="title">Give your Feedback</h2>
                        <p>Your experience matters to us! Share your thoughts to help us serve you better.</p>
                    </div>
                </div>
                <div class="newsletter-form">
                    <div class="post-item">
                        <div class="content">
                            <a class="post-category" href="feedback.php">Share your Feedback</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End News Letter Area Wrapper ==-->

</main>

<?php

include('components/footer.php');

?>