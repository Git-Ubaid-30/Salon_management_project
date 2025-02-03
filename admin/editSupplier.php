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
if (isset($_GET["sId"])) {
    $supplierId = $_GET["sId"];
    $query = $pdo->prepare("select * from suppliers where id = :sId");
    $query->bindParam("sId", $supplierId);
    $query->execute();
    $supplier = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- Content Body Start -->
<div class="content-body">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>eCommerce <span>/ Edit Supplier</span></h3>
            </div>
        </div><!-- Page Heading End -->

    </div><!-- Page Headings End -->

    <!-- Add or Edit Supplier Start -->
    <div class="add-edit-product-wrap col-12">

        <div class="add-edit-product-form">
            <form action="#" method="post" enctype="multipart/form-data">

                <h4 class="title">About Edit Supplier</h4>

                <div class="row">
                    <div class="col-lg-6 col-12 mb-30"><input value="<?php echo $supplier['name'] ?>" name="sName"
                            class="form-control" type="text" placeholder="Supplier Name / Title*" required>
                    </div>

                    <div class="col-lg-6 col-12 mb-30"><input value="<?php echo $supplier['product_salling'] ?>"
                            name="sSelling" class="form-control" type="text" placeholder="Supplier Name / Title*"
                            required>
                    </div>

                    <div class="col-12 mb-30">
                        <textarea name="sAddress" class="form-control" placeholder="Address*"
                            pattern="^(?=.*[a-zA-Z])[a-zA-Z0-9\s,.-]{10,}$"
                            title="Address must be at least 10 characters long, contain at least one letter, and can include letters, numbers, spaces, commas, periods, and hyphens only."
                            minlength="10" required><?php echo $supplier['address'] ?></textarea>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $supplier['contact_info'] ?>" name="sContact" class="form-control"
                            type="text" placeholder="Contact Info*" pattern="^\d{10,15}$"
                            title="Please enter a valid contact number with 10 to 15 digits." required>
                    </div>

                    
                    <div class="col-lg-6 col-12 mb-30">
                        <input value="<?php echo $supplier['product_qty'] ?>" name="sQty" class="form-control" type="text"
                            placeholder="Quantity*" pattern="^[1-9]\d*$"
                            title="Please enter a valid positive number/integer." required>
                    </div>

                </div>

                <!-- Button Group Start -->
                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0"
                            name="updateSupplier">Update
                            Supplier</button>
                    </div>
                </div><!-- Button Group End -->

            </form>
        </div>

    </div><!-- Add or Edit Supplier End -->

</div><!-- Content Body End -->

<?php
include('components/footer.php');
?>