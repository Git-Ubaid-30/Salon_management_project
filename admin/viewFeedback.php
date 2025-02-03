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

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Feedbacks Form</span></h3>
            </div>
        </div><!-- Page Heading End -->

    </div><!-- Page Headings End -->

    <div class="row">

        <!--Manage feedback List Start-->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Review</th>
                            <th scope="col">Service_rating</th>
                            <th scope="col">Product_rating</th>
                            <th scope="col">Tital</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $pdo->query("select * from feedback");
                        $allFeedbacks = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($allFeedbacks as $feedback) {
                            ?>
                            <tr>
                                <td scope="row"><?php echo $feedback['id'] ?></td>

                                <td><?php echo $feedback['name'] ?></td>

                                <td><?php echo $feedback['email'] ?></td>

                                <td><?php echo $feedback['review'] ?></td>

                                <td><?php echo $feedback['service_rating'] ?></td>

                                <td><?php echo $feedback['product_rating'] ?></td>

                                <td><?php echo $feedback['tital'] ?></td>

                                <td>
                                    <div class="table-action-buttons">
                                        <a class="delete button button-box button-xs button-danger"
                                            href="javascript:void(0);"
                                            onclick="confirmDelete(<?php echo $feedback['id']; ?>)"><i
                                                class="zmdi zmdi-delete"></i>
                                            </a>

                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--Manage Category List End-->

    </div>

</div><!-- Content Body End -->

<?php
include('components/footer.php')
    ?>

<!-- JavaScript SweetAlert Delete Confirmation -->
<script>
    function confirmDelete(feedbackId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            background: '#333',
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to PHP deletion script with category ID
                window.location.href = "?fRemove=" + feedbackId;
            }
        });
    }
</script>

