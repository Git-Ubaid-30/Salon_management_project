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
if (isset($_GET["id"])) {
    $categoryId = $_GET["id"];
    $query = $pdo->prepare("select * from categories where id = :cId");
    $query->bindParam("cId", $categoryId);
    $query->execute();
    $category = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- Content Body Start -->
<div class="content-body">
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Edit Category</span></h3>
            </div>
        </div>
    </div>

    <div class="add-edit-product-wrap col-12">
        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">
                <h4 class="title">About Edit Category</h4>

                <div class="row">
                    <div class="col-12 mb-30">
                        <input value="<?php echo $category['name'] ?>" name="cName" class="form-control" type="text"
                            placeholder="Category Name*" required>
                    </div>

                    <div class="col-12 mb-30">
                        <textarea name="cDes" class="form-control"
                            placeholder="Category Description*" required><?php echo $category['des'] ?></textarea>
                    </div>
                </div>

                <h4 class="title">Category Image</h4>
                <div class="product-upload-gallery row flex-wrap">
                    <div class="col-12 mb-30">
                        <p class="form-help-text mt-0">Upload Image</p>
                        <input name="cImage" class="file-pond" type="file" accept=".jpg,.jpeg,.png,.webp,.jfif,.avif">
                    </div>
                    <img src="assets/images/<?php echo $category['image'] ?> " class="product-image rounded-circle"
                        alt="" style="width: 110px; height: 90px; object-fit: cover;">
                </div>

                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0"
                            name="updateCategory">Update Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('components/footer.php'); ?>