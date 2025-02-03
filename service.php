<?php

include('components/header.php');

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

<main class="main-content">

    <!--== Start Page Header Area Wrapper ==-->
    <section class="page-header-area page-header-style2-area" data-bg-img="assets/images/blog/blog-detail1.webp">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="page-header-content page-header-st2-content">
                        <div class="title-img"><img src="assets/images/photos/page-header-text1.webp" alt="Image"></div>
                        <h2 class="page-header-title">Discover Our Beauty Secrets</h2>
                        <p class="page-header-desc">Unveil the best of beauty with our tailored services and expert stylists, designed to bring out the best in you.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Page Header Area Wrapper ==-->

    <!--== Start Services Area Wrapper ==-->
    <section class="section-space pb-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Our Services</h2>
                        <p>Experience our curated range of beauty and wellness services tailored to help you look and feel your best.</p>
                    </div>
                </div>
            </div>
            <div class="row mb-n9">
                <?php
                $query = $pdo->query("select * from services");
                $allServices = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($allServices as $service) {
                ?>
                    <div class="col-sm-6 col-lg-4 mb-8">
                        <!--== Start Service Item ==-->
                        <div class="post-item">
                            <a href="service-detail.php?sId=<?php echo $service['id'] ?>" class="thumb">
                                <img src="admin/assets/images/<?php echo $service['image'] ?>" width="370" height="320" alt="Facial Service">
                            </a>
                            <div class="content">
                                <h4 class="title"><?php echo $service['name'] ?></h4>
                                <h4>$<?php echo $service['price'] ?></h4>
                            </div>
                        </div>
                        <!--== End Service Item ==-->
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <!--== End Services Area Wrapper ==-->

    <!--== Start Stylists Area Wrapper ==-->
    <section class="section-space pt-25">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Meet Our Stylists</h2>
                        <p>Our experienced team of stylists brings a wealth of expertise, skill, and passion for beauty.</p>
                    </div>
                </div>
            </div>
            <div class="row mb-n9">
                <?php
                $query = $pdo->query("SELECT stylists.*, services.name as serName
                    FROM stylists
                    INNER JOIN services ON stylists.service_id = services.id");
                $allStylists = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($allStylists as $stylists) {
                    if ($stylists) {
                        $stylistsRating = (int) $stylists['rating']; // Ensure rating is an integer
                ?>
                        <div class="col-sm-6 col-lg-4 mb-8">
                            <!--== Start Stylist Item ==-->
                            <div class="post-item">
                                <div class="stylist-image-wrapper">
                                    <img src="admin/assets/images/<?php echo $stylists['image'] ?>" alt="Stylist Image">
                                </div>
                                <div class="content">
                                    <h4 class="title"><?php echo $stylists['name'] ?></h4>
                                    <p><?php echo $stylists['des'] ?></p>
                                    <ul class="meta">
                                        <li><span>Specialty:</span><?php echo $stylists['serName'] ?></li>
                                        <li><span>Rating:</span>
                                            <a style="color: #ff6565;">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <span class="star">
                                                        <i class="fa <?php echo $i <= $stylistsRating ? 'fa-star filled' : 'fa-star-o empty'; ?>"></i>
                                                    </span>
                                                <?php endfor; ?>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="meta">
                                        <li><span>Contact_info:</span><?php echo $stylists['contact_info'] ?></li>
                                    </ul>
                                </div>
                            </div>

                            <!--== End Stylist Item ==-->
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <!--== End Stylists Area Wrapper ==-->

    <!--== Start News Letter Area Wrapper ==-->
    <section class="section-space pt-0">
        <div class="container">
            <div class="newsletter-content-wrap" data-bg-img="assets/images/photos/bg1.webp">
                <div class="newsletter-content">
                    <div class="section-title mb-0">
                        <h2 class="title">Our Beauty Community</h2>
                        <p>Stay connected with our exclusive beauty tips & services. Join us and let us bring out the best in you!</p>
                    </div>
                </div>
                <div class="newsletter-form">
                    <div class="post-item">
                        <div class="content">
                            <a class="post-category" href="contact.php">Contact Us Today</a>
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