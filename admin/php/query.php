<?php

include('../query.php');

?>

<!-- admin-profile -->

<?php

$adminName = $_SESSION['adminName'] ?? '';
$adminEmail = $_SESSION['adminEmail'] ?? '';
$adminId = $_SESSION['adminId'] ?? '';
$lastLogin = 'No login record found';
$currentPassword = $newPassword = $confirmPassword = "";
$passwordErr = $passwordMsg = $profileMsg = "";

// Update Profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["updateProfileAdmin"])) {
        $adminName = trim($_POST['adminName']);
        $adminEmail = trim($_POST['adminEmail']);

        // Update name and email in the database
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['name' => $adminName, 'email' => $adminEmail, 'id' => $adminId]);

        // Update session variables
        $_SESSION["adminName"] = $adminName;
        $_SESSION["adminEmail"] = $adminEmail;

        $profileMsg = "Profile updated successfully!";
    }

    if (isset($_POST['changePassword'])) {
        $adminId = $_SESSION['adminId'];
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        $query = $pdo->prepare("SELECT * FROM users WHERE id = :adminId");
        $query->bindParam('adminId', $adminId);
        $query->execute();
        $changePassword = $query->fetch(PDO::FETCH_ASSOC);
        $data_password = $changePassword['password'];

        if ($data_password == $currentPassword) {
            if ($newPassword == $confirmPassword) {
                $query = $pdo->prepare("UPDATE users SET password = :newPassword WHERE id = :adminId");
                $query->bindParam('newPassword', $newPassword);
                $query->bindParam('adminId', $adminId);
                $query->execute();
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Password Updated!',
                            text: 'Your password has been changed successfully.',
                            background: '#333',
                            color: '#fff',
                            confirmButtonColor: '#3085d6'
                        });
                    });
                </script>";
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'New password and Confirm Password do not match.',
                            background: '#333',
                            color: '#fff',
                            confirmButtonColor: '#3085d6'
                        });
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Invalid current password.',
                        background: '#333',
                        color: '#fff',
                        confirmButtonColor: '#3085d6'
                    });
                });
            </script>";
        }
    }
}
?>


<!-- category -->

<?php

// Initialize variables
$cNameErr = $cDesErr = $cImageNameErr = "";
$cName = $cDes = $cImageName = "";

// Check if the form has been submitted
if (isset($_POST["addCategory"])) {
    $cName = htmlspecialchars(trim($_POST["cName"]));
    $cDes = htmlspecialchars(trim($_POST["cDes"]));
    $cImageName = $_FILES["cImage"]["name"];
    $cImageTmpName = $_FILES["cImage"]["tmp_name"];

    // Set the destination path for the uploaded image
    $destination = "assets/images/" . basename($cImageName); // Use basename to avoid path traversal issues

    // Validate inputs
    if (empty($cName)) {
        $cNameErr = "Category name is required.";
    }
    if (empty($cDes)) {
        $cDesErr = "Category description is required.";
    }
    $arrayFormat = ["png", "jpg", "webp", "jpeg", 'avif', 'jfif'];
    $fileExtension = strtolower(pathinfo($cImageName, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $arrayFormat)) {
        $cImageNameErr = "Image is required/Invalid format. Allowed formats: jpg, png, jpeg, webp, avif, jfif.";
    }

    if (empty($cNameErr) && empty($cDesErr) && empty($cImageNameErr)) {
        if (move_uploaded_file($cImageTmpName, $destination)) {
            $query = $pdo->prepare("INSERT INTO categories(name, des, image) VALUES(:cName, :cDes, :cImage)");
            $query->bindParam(":cName", $cName);
            $query->bindParam(":cDes", $cDes);
            $query->bindParam(":cImage", $cImageName);
            $query->execute();

            // Success SweetAlert message
            echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Category Added!',
                text: 'Category added successfully.',
                background: '#333',
                color: '#fff',
                confirmButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'viewCategory.php';
                }
            });
        });
    </script>";
        }
    } else {
        // SweetAlert for validation errors
        echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fix the errors and try again!',
            background: '#333',
            color: '#fff',
            confirmButtonColor: '#d33'
        });
    });
    </script>";
    }
}
?>


<!-- remove category -->

<?php
if (isset($_GET['cRemove'])) {
    $cid = $_GET['cRemove'];
    $query = $pdo->prepare("delete from categories where id = :categoryId");
    $query->bindParam("categoryId", $cid);
    $query->execute();
    echo '<script>location.assign("viewCategory.php")</script>';
}
?>

<!-- edit category -->

<?php

if (isset($_POST["updateCategory"])) {

    $categoryId = htmlspecialchars(trim($_GET["id"]));
    $cName = htmlspecialchars(trim($_POST["cName"]));
    $cDes = htmlspecialchars(trim($_POST["cDes"]));
    $query = $pdo->prepare("update categories set name = :cName , des = :cDes where id = :cId");
    if (!empty($_FILES["cImage"]["name"])) {
        $cImageName = $_FILES["cImage"]["name"];
        $cImageTmpName = $_FILES["cImage"]["tmp_name"];
        $destination = "assets/images/" . basename($cImageName);
        $extension = strtolower(pathinfo($cImageName, PATHINFO_EXTENSION));
        $extensionArray = ["png", "jpg", "webp", "jpeg", 'avif', 'jfif'];
        if (in_array($extension, $extensionArray)) {
            if (move_uploaded_file($cImageTmpName, $destination)) {
                $query = $pdo->prepare("update categories set name = :cName , des = :cDes , image = :cImage where id = :cId");
                $query->bindParam("cImage", $cImageName);
            } else {
                // SweetAlert for validation errors
                echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Image upload failed!',
                    background: '#333',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                });
            });
            </script>";
            }
        } else {
            echo '<script> alert("Invalid image format. Allowed formats: png, jpg, jpeg, webp, avif, jfif."); </script>';
            exit;
        }
    }

    $query->bindParam("cId", $categoryId);
    $query->bindParam("cName", $cName);
    $query->bindParam("cDes", $cDes);
    $query->execute();
    // Success SweetAlert message
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Category updated!',
            text: 'Category updated successfully.',
            background: '#333',
            color: '#fff',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'viewCategory.php';
            }
        });
    });
</script>";
}

?>

<!-- product -->

<?php

// Initialize variables
$pName = $pDes = $pPrice = $pQty = $pRating = $pImageName = $pCategory_id = $pSupplier_id = "";
$pNameErr = $pDesErr = $pPriceErr = $pQtyErr = $pRatingErr = $pImageNameErr = $pCategory_idErr = $pSupplier_idErr = "";

if (isset($_POST["addProduct"])) {
    // Trim and sanitize inputs
    $pName = htmlspecialchars(trim($_POST["pName"]));
    $pDes = htmlspecialchars(trim($_POST["pDes"]));
    $pPrice = htmlspecialchars(trim($_POST["pPrice"]));
    $pQty = htmlspecialchars(trim($_POST["pQty"]));
    $pRating = htmlspecialchars(trim($_POST['pRating']));
    $pCategory_id = htmlspecialchars(trim($_POST["pCategory_id"]));
    $pSupplier_id = htmlspecialchars(trim($_POST["pSupplier_id"]));
    $pImageName = $_FILES["pImage"]["name"];
    $pImageTmpName = $_FILES["pImage"]["tmp_name"];
    $destination = "assets/images/" . basename($pImageName);

    // Validate fields
    if (empty($pName)) {
        $pNameErr = "Name is Required";
    }
    if (empty($pDes)) {
        $pDesErr = "Description is Required";
    }
    if (empty($pPrice)) {
        $pPriceErr = "Price is required";
    } elseif (!is_numeric($pPrice) || $pPrice <= 0) {
        $pPriceErr = "Price must be a positive number";
    }
    if (empty($pCategory_id)) {
        $pCategory_idErr = "Must select Category";
    }
    if (empty($pSupplier_id)) {
        $pSupplier_idErr = "Must select Supplier";
    }
    if (empty($pQty)) {
        $pQtyErr = "Must select product first to see the Quantity";
    }
    if (empty($pRating)) {
        $pRatingErr = "Rating is required";
    } elseif (!is_numeric($pRating) || $pRating < 0 || $pRating > 5) {
        $pRatingErr = "Rating must be between 0 and 5";
    }
    // Validate image format
    $arrayFormatProduct = ["png", "jpg", "webp", "jpeg", 'avif', 'jfif'];
    $fileExtensionProduct = pathinfo($pImageName, PATHINFO_EXTENSION);
    if (!in_array($fileExtensionProduct, $arrayFormatProduct)) {
        $pImageNameErr = "Image is Required/Invalid format. Allowed formats: jpg, png, jpeg, webp, avif, jfif.";
    }

    // If no errors, process the form
    if (empty($pNameErr) && empty($pDesErr) && empty($pImageNameErr) && empty($pPriceErr) && empty($pQtyErr) && empty($pRatingErr) && empty($pCategory_idErr) && empty($pSupplier_idErr)) {
        if (move_uploaded_file($pImageTmpName, $destination)) {
            $query = $pdo->prepare("INSERT INTO products(name, des, image, price, qty, rating, category_id, supplier_id) VALUES (:pName, :pDes, :pImage, :pPrice, :pQty, :pRating, :pCategory_id, :pSupplier_id)");
            $query->bindParam("pName", $pName);
            $query->bindParam("pDes", $pDes);
            $query->bindParam("pImage", $pImageName);
            $query->bindParam("pPrice", $pPrice);
            $query->bindParam("pQty", $pQty);
            $query->bindParam(":pRating", $pRating);
            $query->bindParam("pCategory_id", $pCategory_id);
            $query->bindParam("pSupplier_id", $pSupplier_id);
            $query->execute();
            // Success SweetAlert message
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Product Added!',
                        text: 'Product added successfully.',
                        background: '#333',
                        color: '#fff',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'viewProduct.php';
                        }
                    });
                });
            </script>";
        }
    } else {
        // SweetAlert for validation errors
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fix the errors and try again!',
                    background: '#333',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                });
            });
        </script>";
    }
}
?>


<!-- remove product -->

<?php
if (isset($_GET['pRemove'])) {
    $pid = $_GET['pRemove'];
    $query = $pdo->prepare("delete from products where id = :productId");
    $query->bindParam("productId", $pid);
    $query->execute();
    echo '<script>location.assign("viewProduct.php")</script>';
}
?>

<!-- update product -->

<?php

if (isset($_POST["updateProduct"])) {
    $productId = htmlspecialchars(trim($_GET["pId"]));
    $pName = htmlspecialchars(trim($_POST["pName"]));
    $pDes = htmlspecialchars(trim($_POST["pDes"]));
    $pPrice = htmlspecialchars(trim($_POST["pPrice"]));
    $pQty = htmlspecialchars(trim($_POST["pQty"]));
    $pRating = htmlspecialchars(trim($_POST['pRating']));
    $category_id = htmlspecialchars(trim($_POST["pCategory_id"]));
    $supplier_id = htmlspecialchars(trim($_POST["pSupplier_id"]));

    // Prepare the initial query without image
    $query = $pdo->prepare("UPDATE products SET name = :pName, des = :pDes, price = :pPrice, rating = :pRating, qty = :pQty, category_id = :category_id, supplier_id = :supplier_id  WHERE id = :pId");

    // Image handling
    if (!empty($_FILES["pImage"]["name"])) {
        $pImageName = $_FILES["pImage"]["name"];
        $pImageTmpName = $_FILES["pImage"]["tmp_name"];
        $destination = "assets/images/" . basename($pImageName);
        $extensionProduct = strtolower(pathinfo($pImageName, PATHINFO_EXTENSION));
        $extensionArrayProduct = ["png", "jpg", "webp", "jpeg", "avif", "jfif"];

        if (in_array($extensionProduct, $extensionArrayProduct)) {
            if (move_uploaded_file($pImageTmpName, $destination)) {
                $query = $pdo->prepare("UPDATE products SET name = :pName, des = :pDes, price = :pPrice, qty = :pQty, rating = :pRating, category_id = :category_id, supplier_id = :supplier_id, image = :pImage WHERE id = :pId");
                $query->bindParam("pImage", $pImageName);
            } else {
                // SweetAlert for validation errors
                echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Image upload failed!',
                    background: '#333',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                });
            });
            </script>";
            }
        } else {
            echo '<script> alert("Invalid image format. Allowed formats: png, jpg, jpeg, webp, avif, jfif."); </script>';
            exit;
        }
    }

    // Bind and execute the query
    $query->bindParam("pId", $productId);
    $query->bindParam("pName", $pName);
    $query->bindParam("pDes", $pDes);
    $query->bindParam("pPrice", $pPrice);
    $query->bindParam("pQty", $pQty);
    $query->bindParam("pRating", $pRating);
    $query->bindParam("category_id", $category_id);
    $query->bindParam("supplier_id", $supplier_id);
    $query->execute();
    // Success SweetAlert message
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Product updated!',
            text: 'Product updated successfully.',
            background: '#333',
            color: '#fff',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'viewProduct.php';
            }
        });
    });
</script>";
}
?>

<!-- supplier -->

<?php

$sName = $sSelling = $sQty = $sAddress = $sContact = "";
$sNameErr = $sSellingErr = $sQtyErr = $sAddressErr = $sContactErr = "";

if (isset($_POST["addSupplier"])) {
    // Trim and sanitize inputs
    $sName = htmlspecialchars(trim($_POST["sName"]));
    $sSelling = htmlspecialchars(trim($_POST["sSelling"]));
    $sQty = htmlspecialchars(trim($_POST["sQty"]));
    $sAddress = htmlspecialchars(trim($_POST["sAddress"]));
    $sContact = htmlspecialchars(trim($_POST["sContact"]));

    // Validate Name (Only alphabets and spaces)
    if (empty($sName)) {
        $sNameErr = "Name is required";
    }

    // Validate Selling Description (Minimum length check)
    if (empty($sSelling)) {
        $sSellingErr = "ProductName is required";
    }
    if (empty($sQty)) {
        $sQtyErr = "Quantity is required";
    } elseif (!ctype_digit($sQty) || $sQty <= 0) {
        $sQtyErr = "Quantity must be a positive number";
    }
    // Validate Address (Minimum length and no special characters)
    if (empty($sAddress)) {
        $sAddressErr = "Address is required";
    } elseif (strlen($sAddress) < 10) {
        $sAddressErr = "Address must be at least 10 characters";
    } elseif (!preg_match("/^[a-zA-Z0-9\s,.-]*$/", $sAddress)) {
        $sAddressErr = "Invalid address format";
    }

    // Validate Contact Number (Only numbers and length check)
    if (empty($sContact)) {
        $sContactErr = "Contact number is required";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $sContact)) {
        $sContactErr = "Contact number must be 10-15 digits";
    }

    // If no errors, process the form
    if (empty($sNameErr) && empty($sSellingErr) && empty($sAddressErr)&& empty($sQtyErr) && empty($sContactErr)) {
        $query = $pdo->prepare("INSERT INTO suppliers(name, product_salling, product_qty, address, contact_info) VALUES (:sName, :sSelling, :sQty, :sAddress, :sContact)");
        $query->bindParam(":sName", $sName);
        $query->bindParam(":sSelling", $sSelling);
        $query->bindParam(":sQty", $sQty);
        $query->bindParam(":sAddress", $sAddress);
        $query->bindParam(":sContact", $sContact);
        $query->execute();

        // Success SweetAlert message
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Supplier Added!',
                text: 'Supplier added successfully.',
                background: '#333',
                color: '#fff',
                confirmButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'viewSupplier.php';
                }
            });
        });
    </script>";
    } else {
        // SweetAlert for validation errors
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fix the errors and try again!',
                background: '#333',
                color: '#fff',
                confirmButtonColor: '#d33'
            });
        });
        </script>";
    }
}
?>

<!-- remove Supplier -->

<?php
if (isset($_GET['sRemove'])) {
    $sid = $_GET['sRemove'];
    $query = $pdo->prepare("delete from suppliers where id = :supplierId");
    $query->bindParam("supplierId", $sid);
    $query->execute();
    echo '<script>location.assign("viewSupplier.php")</script>';
}
?>

<!-- update Supplier -->

<?php

if (isset($_POST["updateSupplier"])) {
    $supplierId = htmlspecialchars(trim($_GET["sId"]));
    $sName = htmlspecialchars(trim($_POST["sName"]));
    $sSelling = htmlspecialchars(trim($_POST["sSelling"]));
    $sQty = htmlspecialchars(trim($_POST["sQty"]));
    $sAddress = htmlspecialchars(trim($_POST["sAddress"]));
    $sContact = htmlspecialchars(trim($_POST["sContact"]));

    // Prepare the initial query without image
    $query = $pdo->prepare("UPDATE suppliers SET name = :sName, product_salling = :sSelling, product_qty = :sQty, address = :sAddress, contact_info = :sContact WHERE id = :sId");
    // Bind and execute the query
    $query->bindParam("sId", $supplierId);
    $query->bindParam("sName", $sName);
    $query->bindParam("sSelling", $sSelling);
    $query->bindParam("sQty", $sQty);
    $query->bindParam("sAddress", $sAddress);
    $query->bindParam("sContact", $sContact);
    $query->execute();
    // Success SweetAlert message
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Supplier updated!',
            text: 'Product updated successfully.',
            background: '#333',
            color: '#fff',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'viewSupplier.php';
            }
        });
    });
</script>";
}

?>

<!-- Service -->

<?php

// Initialize variables
$serviceName = $serviceDes = $servicePrice = $serviceImageName = $serviceDuration = "";
$serviceNameErr = $serviceDesErr = $servicePriceErr = $serviceImageNameErr = $serviceDurationErr = "";

if (isset($_POST["addService"])) {
    // Trim and sanitize inputs
    $serviceName = htmlspecialchars(trim($_POST["serviceName"]));
    $serviceDes = htmlspecialchars(trim($_POST["serviceDes"]));
    $servicePrice = htmlspecialchars(trim($_POST["servicePrice"]));
    $serviceDuration = htmlspecialchars(trim($_POST["serviceDuration"]));
    $serviceImageName = $_FILES["serviceImage"]["name"];
    $serviceImageTmpName = $_FILES["serviceImage"]["tmp_name"];
    $destination = "assets/images/" . basename($serviceImageName);

    // Validate fields
    if (empty($serviceName)) {
        $serviceNameErr = "Name is Required";
    }
    if (empty($serviceDes)) {
        $servicepDesErr = "Description is Required";
    }
    if (empty($servicePrice)) {
        $servicePriceErr = "Price is required";
    } elseif (!is_numeric($servicePrice) || $servicePrice <= 0) {
        $servicePriceErr = "Price must be a positive number";
    }
    // Validate service duration format
    $durationPattern = "/^(morning|afternoon|evening|night) \d{1,2}(am|pm) to \d{1,2}(am|pm)$/i";
    if (empty($serviceDuration)) {
        $serviceDurationErr = "Duration is required.";
    } elseif (!preg_match($durationPattern, $serviceDuration)) {
        $serviceDurationErr = "Invalid duration format. Use 'morning|afternoon|evening|night & Time Duration like (am/pm)'.";
    } else {
        // Further validate based on time rules for morning, afternoon, evening, and night
        list($period, $startTime, $endTime) = explode(' ', str_replace(' to ', ' ', strtolower($serviceDuration)));

        // Extract AM/PM part of start and end times
        $startPeriod = substr($startTime, -2);
        $endPeriod = substr($endTime, -2);

        // Additional checks based on the period
        if ($period === "morning" && ($startPeriod !== "am" || $endPeriod !== "am")) {
            $serviceDurationErr = "For morning, only 'am' times are allowed.";
        } elseif ($period === "afternoon" && ($startPeriod !== "pm" || $endPeriod !== "pm")) {
            $serviceDurationErr = "For afternoon, only 'pm' times are allowed.";
        } elseif ($period === "evening" && ($startPeriod !== "pm" || $endPeriod !== "pm")) {
            $serviceDurationErr = "For evening, only 'pm' times are allowed.";
        } elseif ($period === "night") {
            // Night should start in PM and can end in AM (crossing midnight), or stay within AM (early morning)
            if (!(($startPeriod === "pm" && $endPeriod === "am") || ($startPeriod === "am" && $endPeriod === "am"))) {
                $serviceDurationErr = "For night, the time should start in 'pm' and end in 'am', or be within 'am' for early morning.";
            }
        }
    }


    // Validate image format
    $arrayFormatService = ["png", "jpg", "webp", "jpeg", 'avif', 'jfif'];
    $fileExtensionService = pathinfo($serviceImageName, PATHINFO_EXTENSION);
    if (!in_array($fileExtensionService, $arrayFormatService)) {
        $serviceImageNameErr = "Image is Required/Invalid format. Allowed formats: jpg, png, jpeg, webp, avif, jfif.";
    }

    // If no errors, process the form
    if (empty($serviceNameErr) && empty($serviceDesErr) && empty($serviceImageNameErr) && empty($servicePriceErr) && empty($serviceDurationErr)) {
        if (move_uploaded_file($serviceImageTmpName, $destination)) {
            $query = $pdo->prepare("INSERT INTO services(name, des, image, price, duration) VALUES (:serviceName, :serviceDes, :serviceImage, :servicePrice, :serviceDuration)");
            $query->bindParam("serviceName", $serviceName);
            $query->bindParam("serviceDes", $serviceDes);
            $query->bindParam("serviceImage", $serviceImageName);
            $query->bindParam("servicePrice", $servicePrice);
            $query->bindParam("serviceDuration", $serviceDuration);
            $query->execute();
            // Success SweetAlert message
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'service Added!',
                        text: 'service added successfully.',
                        background: '#333',
                        color: '#fff',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'viewService.php';
                        }
                    });
                });
            </script>";
        }
    } else {
        // SweetAlert for validation errors
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fix the errors and try again!',
                    background: '#333',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                });
            });
        </script>";
    }
}
?>


<!-- remove Service -->

<?php
if (isset($_GET['serviceRemove'])) {
    $serviceid = $_GET['serviceRemove'];
    $query = $pdo->prepare("delete from services where id = :serviceId");
    $query->bindParam("serviceId", $serviceid);
    $query->execute();
    echo '<script>location.assign("viewService.php")</script>';
}
?>

<!-- update Service -->

<?php

if (isset($_POST["updateService"])) {
    $serviceId = htmlspecialchars(trim($_GET["serviceId"]));
    $serviceName = htmlspecialchars(trim($_POST["serviceName"]));
    $serviceDes = htmlspecialchars(trim($_POST["serviceDes"]));
    $servicePrice = htmlspecialchars(trim($_POST["servicePrice"]));
    $serviceDuration = htmlspecialchars(trim($_POST["serviceDuration"]));
    // Prepare the initial query without image
    $query = $pdo->prepare("UPDATE services SET name = :serviceName, des = :serviceDes, price = :servicePrice, duration = :serviceDuration WHERE id = :serviceId");

    // Image handling
    if (!empty($_FILES["serviceImage"]["name"])) {
        $serviceImageName = $_FILES["serviceImage"]["name"];
        $serviceImageTmpName = $_FILES["serviceImage"]["tmp_name"];
        $destination = "assets/images/" . basename($serviceImageName);
        $extensionService = strtolower(pathinfo($serviceImageName, PATHINFO_EXTENSION));
        $extensionArrayService = ["png", "jpg", "webp", "jpeg", "avif", "jfif"];

        if (in_array($extensionService, $extensionArrayService)) {
            if (move_uploaded_file($serviceImageTmpName, $destination)) {
                $query = $pdo->prepare("UPDATE services SET name = :serviceName, des = :serviceDes, price = :servicePrice, duration = :serviceDuration, image = :serviceImage WHERE id = :serviceId");
                $query->bindParam("serviceImage", $serviceImageName);
            } else {
                // SweetAlert for validation errors
                echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Image upload failed!',
                    background: '#333',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                });
            });
            </script>";
            }
        } else {
            echo '<script> alert("Invalid image format. Allowed formats: png, jpg, jpeg, webp, avif, jfif."); </script>';
            exit;
        }
    }

    // Bind and execute the query
    $query->bindParam("serviceId", $serviceId);
    $query->bindParam("serviceName", $serviceName);
    $query->bindParam("serviceDes", $serviceDes);
    $query->bindParam("servicePrice", $servicePrice);
    $query->bindParam("serviceDuration", $serviceDuration);

    $query->execute();
    // Success SweetAlert message
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Service updated!',
            text: 'Service updated successfully.',
            background: '#333',
            color: '#fff',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'viewService.php';
            }
        });
    });
</script>";
}

?>

<!-- Stylist -->

<?php

// Initialize variables
$stylistName = $stylistEmail = $stylistPassword = $stylistContact = $stylistDes = $stylistService_id = $stylistShift_schedule = $stylistCommission_rate = $stylistRating = $stylistImageName = "";
$stylistNameErr = $stylistEmailErr = $stylistPasswordErr = $stylistContactErr = $stylistDesErr = $stylistService_idErr = $stylistShift_scheduleErr = $stylistCommission_rateErr = $stylistRatingErr = $stylistImageNameErr = "";

if (isset($_POST["addStylist"])) {
    // Clean and assign inputs
    $stylistName = htmlspecialchars(trim($_POST['stylistName']));
    $stylistEmail = htmlspecialchars(trim($_POST['stylistEmail']));
    $stylistPassword = htmlspecialchars(trim($_POST['stylistPassword']));
    $stylistContact = htmlspecialchars(trim($_POST['stylistContact']));
    $stylistDes = htmlspecialchars(trim($_POST['stylistDes']));
    $stylistService_id = $_POST['stylistService_id'];
    $stylistShift_schedule = htmlspecialchars(trim($_POST['stylistShift_schedule']));
    $stylistCommission_rate = htmlspecialchars(trim($_POST['stylistCommission_rate']));
    $stylistRating = htmlspecialchars(trim($_POST['stylistRating']));
    $stylistImageName = $_FILES['stylistImage']['name'];
    $stylistImageTmpName = $_FILES['stylistImage']['tmp_name'];
    $destination = "assets/images/" . basename($stylistImageName);

    // Validate fields
    if (empty($stylistName)) {
        $stylistNameErr = "Name is required";
    }
    if (empty($stylistEmail)) {
        $stylistEmailErr = "Email is required";
    } elseif (!filter_var($stylistEmail, FILTER_VALIDATE_EMAIL)) {
        $stylistEmailErr = "Invalid email format";
    } else {
        // Check if email already exists
        $checkEmailQuery = $pdo->prepare("SELECT COUNT(*) FROM stylists WHERE email = :stylistEmail");
        $checkEmailQuery->bindParam(":stylistEmail", $stylistEmail);
        $checkEmailQuery->execute();
        if ($checkEmailQuery->fetchColumn() > 0) {
            $stylistEmailErr = "Email already exists";
        }
    }
    if (empty($stylistPassword)) {
        $stylistPasswordErr = "Password is required";
    } elseif (strlen($stylistPassword) < 6) {
        $stylistPasswordErr = "Password must be at least 6 characters";
    }
    if (empty($stylistContact)) {
        $stylistContactErr = "Contact number is required";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $stylistContact)) {
        $stylistContactErr = "Contact number must be 10-15 digits";
    }
    if (empty($stylistDes)) {
        $stylistDesErr = "Description is required";
    }
    if (empty($stylistService_id)) {
        $stylistService_idErr = "Must select service";
    }
    if (empty($stylistShift_schedule)) {
        $stylistShift_scheduleErr = "Must select schedule";
    }
    if (empty($stylistCommission_rate)) {
        $stylistCommission_rateErr = "Must select service first to see the commision";
    }
    if (empty($stylistRating)) {
        $stylistRatingErr = "Rating is required";
    } elseif (!is_numeric($stylistRating) || $stylistRating < 0 || $stylistRating > 5) {
        $stylistRatingErr = "Rating must be between 0 and 5";
    }
    // Validate image format
    $allowedFormatsStylist = ["png", "jpg", "webp", "jpeg", "avif", "jfif"];
    $fileExtensionStylist = pathinfo($stylistImageName, PATHINFO_EXTENSION);
    if (empty($stylistImageName) || !in_array(strtolower($fileExtensionStylist), $allowedFormatsStylist)) {
        $stylistImageNameErr = "Valid image is required (jpg, png, jpeg, webp, avif, jfif)";
    }

    // If no errors, process the form
    if (empty($stylistNameErr) && empty($stylistEmailErr) && empty($stylistPasswordErr) && empty($stylistContactErr) && empty($stylistDesErr) && empty($stylistService_idErr) && empty($stylistShift_scheduleErr) && empty($stylistRatingErr) && empty($stylistImageNameErr)) {
        if (move_uploaded_file($stylistImageTmpName, $destination)) {
            $query = $pdo->prepare("INSERT INTO stylists (name, email, password, contact_info, des, service_id, shift_schedule, commission_rate, rating, image) VALUES (:stylistName, :stylistEmail, :stylistPassword, :stylistContact, :stylistDes, :stylistService_id, :stylistShift_schedule, :stylistCommission_rate, :stylistRating, :stylistImageName)");

            // Bind parameters
            $query->bindParam(":stylistName", $stylistName);
            $query->bindParam(":stylistEmail", $stylistEmail);
            $query->bindParam(":stylistPassword", $stylistPassword);
            $query->bindParam(":stylistContact", $stylistContact);
            $query->bindParam(":stylistDes", $stylistDes);
            $query->bindParam(":stylistService_id", $stylistService_id);
            $query->bindParam(":stylistShift_schedule", $stylistShift_schedule);
            $query->bindParam(":stylistCommission_rate", $stylistCommission_rate);
            $query->bindParam(":stylistRating", $stylistRating);
            $query->bindParam(":stylistImageName", $stylistImageName);

            $query->execute();

            // Success SweetAlert message
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Stylist Added!',
                        text: 'Stylist added successfully.',
                        background: '#333',
                        color: '#fff',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'viewStylist.php';
                        }
                    });
                });
            </script>";
        }
    } else {
        // SweetAlert for validation errors
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fix the errors and try again!',
                    background: '#333',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                });
            });
        </script>";
    }
}
?>

<!-- remove Stylist -->

<?php
if (isset($_GET['stylistRemove'])) {
    $stylistid = $_GET['stylistRemove'];
    $query = $pdo->prepare("delete from stylists where id = :stylistId");
    $query->bindParam("stylistId", $stylistid);
    $query->execute();
    echo '<script>location.assign("viewStylist.php")</script>';
}
?>

<!-- update Stylist -->

<?php

if (isset($_POST["updateStylist"])) {
    // Clean and assign inputs
    $stylistId = htmlspecialchars(trim($_GET["stylistId"]));
    $stylistName = htmlspecialchars(trim($_POST['stylistName']));
    $stylistContact = htmlspecialchars(trim($_POST['stylistContact']));
    $stylistDes = htmlspecialchars(trim($_POST['stylistDes']));
    $stylistService_id = $_POST['stylistService_id'];
    $stylistShift_schedule = htmlspecialchars(trim($_POST['stylistShift_schedule']));
    $stylistCommission_rate = htmlspecialchars(trim($_POST['stylistCommission_rate']));
    $stylistRating = htmlspecialchars(trim($_POST['stylistRating']));

    $query = $pdo->prepare("UPDATE stylists SET name = :stylistName, contact_info = :stylistContact, des = :stylistDes, service_id = :stylistService_id, shift_schedule = :stylistShift_schedule, commission_rate = :stylistCommission_rate, rating = :stylistRating WHERE id = :stylistId");

    // Image handling
    if (!empty($_FILES["stylistImage"]["name"])) {
        $stylistImageName = $_FILES["stylistImage"]["name"];
        $stylistImageTmpName = $_FILES["stylistImage"]["tmp_name"];
        $destination = "assets/images/" . basename($stylistImageName);
        $extensionStylist = strtolower(pathinfo($stylistImageName, PATHINFO_EXTENSION));
        $extensionArrayStylist = ["png", "jpg", "webp", "jpeg", "avif", "jfif"];

        if (in_array($extensionStylist, $extensionArrayStylist)) {
            if (move_uploaded_file($stylistImageTmpName, $destination)) {
                $query = $pdo->prepare("UPDATE stylists SET name = :stylistName, contact_info = :stylistContact, des = :stylistDes, service_id = :stylistService_id, shift_schedule = :stylistShift_schedule, commission_rate = :stylistCommission_rate, rating = :stylistRating, image = :stylistImage WHERE id = :stylistId");
                $query->bindParam("stylistImage", $stylistImageName);
            } else {
                // SweetAlert for validation errors
                echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Image upload failed!',
                    background: '#333',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                });
            });
            </script>";
            }
        } else {
            echo '<script> alert("Invalid image format. Allowed formats: png, jpg, jpeg, webp, avif, jfif."); </script>';
            exit;
        }
    }

    $query->bindParam(":stylistName", $stylistName);
    $query->bindParam(":stylistContact", $stylistContact);
    $query->bindParam(":stylistDes", $stylistDes);
    $query->bindParam(":stylistService_id", $stylistService_id);
    $query->bindParam(":stylistShift_schedule", $stylistShift_schedule);
    $query->bindParam(":stylistCommission_rate", $stylistCommission_rate);
    $query->bindParam(":stylistRating", $stylistRating);
    $query->bindParam(":stylistId", $stylistId);
    $query->execute();

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Stylist updated!',
            text: 'Stylist updated successfully.',
            background: '#333',
            color: '#fff',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'viewStylist.php';
            }
        });
    });
</script>";

}
?>

<!-- Receptionist -->

<?php

// Initialize variables
$receptionistName = $receptionistEmail = $receptionistPassword = $receptionistContact = $receptionistAssigned_tasks = $receptionistShift_schedule = $receptionistImageName = "";
$receptionistNameErr = $receptionistEmailErr = $receptionistPasswordErr = $receptionistContactErr = $receptionistAssigned_tasksErr = $receptionistShift_scheduleErr = $receptionistImageNameErr = "";

if (isset($_POST["addReceptionist"])) {
    // Clean and assign inputs
    $receptionistName = htmlspecialchars(trim($_POST['receptionistName']));
    $receptionistEmail = htmlspecialchars(trim($_POST['receptionistEmail']));
    $receptionistPassword = htmlspecialchars(trim($_POST['receptionistPassword']));
    $receptionistContact = htmlspecialchars(trim($_POST['receptionistContact']));
    $receptionistAssigned_tasks = htmlspecialchars(trim($_POST['receptionistAssigned_tasks']));
    $receptionistShift_schedule = htmlspecialchars(trim($_POST['receptionistShift_schedule']));
    $receptionistImageName = $_FILES['receptionistImage']['name'];
    $receptionistImageTmpName = $_FILES['receptionistImage']['tmp_name'];
    $destination = "assets/images/" . basename($receptionistImageName);

    // Validate fields
    if (empty($receptionistName)) {
        $receptionistNameErr = "Name is required";
    }
    if (empty($receptionistEmail)) {
        $receptionistEmailErr = "Email is required";
    } elseif (!filter_var($receptionistEmail, FILTER_VALIDATE_EMAIL)) {
        $receptionistEmailErr = "Invalid email format";
    } else {
        // Check if email already exists
        $checkEmailQuery = $pdo->prepare("SELECT COUNT(*) FROM receptionists WHERE email = :receptionistEmail");
        $checkEmailQuery->bindParam(":receptionistEmail", $receptionistEmail);
        $checkEmailQuery->execute();
        if ($checkEmailQuery->fetchColumn() > 0) {
            $receptionistEmailErr = "Email already exists";
        }
    }
    if (empty($receptionistPassword)) {
        $receptionistPasswordErr = "Password is required";
    } elseif (strlen($receptionistPassword) < 6) {
        $receptionistPasswordErr = "Password must be at least 6 characters";
    }
    if (empty($receptionistContact)) {
        $receptionistContactErr = "Contact number is required";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $receptionistContact)) {
        $receptionistContactErr = "Contact number must be 10-15 digits";
    }
    if (empty($receptionistAssigned_tasks)) {
        $receptionistAssigned_tasksErr = "Assigned Tasks is required";
    }
    if (empty($receptionistShift_schedule)) {
        $receptionistShift_scheduleErr = "Shift Schedule is required";
    }
    // Validate image format
    $allowedFormatsReceptionist = ["png", "jpg", "webp", "jpeg", "avif", "jfif"];
    $fileExtensionReceptionist = pathinfo($receptionistImageName, PATHINFO_EXTENSION);
    if (empty($receptionistImageName) || !in_array(strtolower($fileExtensionReceptionist), $allowedFormatsReceptionist)) {
        $receptionistImageNameErr = "Valid image is required (jpg, png, jpeg, webp, avif, jfif)";
    }

    // If no errors, process the form
    if (empty($receptionistNameErr) && empty($receptionistEmailErr) && empty($receptionistPasswordErr) && empty($receptionistContactErr) && empty($receptionistAssigned_tasksErr) && empty($receptionistShift_scheduleErr) && empty($receptionistImageNameErr)) {
        if (move_uploaded_file($receptionistImageTmpName, $destination)) {
            $query = $pdo->prepare("INSERT INTO receptionists (name, email, password, contact_info, assigned_tasks, shift_schedule, image) VALUES (:receptionistName, :receptionistEmail, :receptionistPassword, :receptionistContact, :receptionistAssigned_tasks, :receptionistShift_schedule, :receptionistImageName)");

            // Bind parameters
            $query->bindParam(":receptionistName", $receptionistName);
            $query->bindParam(":receptionistEmail", $receptionistEmail);
            $query->bindParam(":receptionistPassword", $receptionistPassword);
            $query->bindParam(":receptionistContact", $receptionistContact);
            $query->bindParam(":receptionistAssigned_tasks", $receptionistAssigned_tasks);
            $query->bindParam(":receptionistShift_schedule", $receptionistShift_schedule);
            $query->bindParam(":receptionistImageName", $receptionistImageName);

            $query->execute();

            // Success SweetAlert message
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Receptionist Added!',
                        text: 'Receptionist added successfully.',
                        background: '#333',
                        color: '#fff',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'viewReceptionist.php';
                        }
                    });
                });
            </script>";
        }
    } else {
        // SweetAlert for validation errors
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fix the errors and try again!',
                    background: '#333',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                });
            });
        </script>";
    }
}
?>

<!-- remove Receptionist -->

<?php
if (isset($_GET['receptionistRemove'])) {
    $receptionistid = $_GET['receptionistRemove'];
    $query = $pdo->prepare("delete from receptionists where id = :receptionistId");
    $query->bindParam("receptionistId", $receptionistid);
    $query->execute();
    echo '<script>location.assign("viewReceptionist.php")</script>';
}
?>

<!-- update Receptionist -->

<?php

if (isset($_POST["updateReceptionist"])) {
    // Clean and assign inputs
    $receptionistId = htmlspecialchars(trim($_GET["receptionistId"]));
    $receptionistName = htmlspecialchars(trim($_POST['receptionistName']));
    $receptionistContact = htmlspecialchars(trim($_POST['receptionistContact']));
    $receptionistAssigned_tasks = htmlspecialchars(trim($_POST['receptionistAssigned_tasks']));
    $receptionistShift_schedule = htmlspecialchars(trim($_POST['receptionistShift_schedule']));

    $query = $pdo->prepare("UPDATE receptionists SET name = :receptionistName, contact_info = :receptionistContact, assigned_tasks = :receptionistAssigned_tasks, shift_schedule = :receptionistShift_schedule WHERE id = :receptionistId");

    // Image handling
    if (!empty($_FILES["receptionistImage"]["name"])) {
        $receptionistImageName = $_FILES["receptionistImage"]["name"];
        $receptionistImageTmpName = $_FILES["receptionistImage"]["tmp_name"];
        $destination = "assets/images/" . basename($receptionistImageName);
        $extensionReceptionist = strtolower(pathinfo($receptionistImageName, PATHINFO_EXTENSION));
        $extensionArrayReceptionist = ["png", "jpg", "webp", "jpeg", "avif", "jfif"];

        if (in_array($extensionReceptionist, $extensionArrayReceptionist)) {
            if (move_uploaded_file($receptionistImageTmpName, $destination)) {
                $query = $pdo->prepare("UPDATE receptionists SET name = :receptionistName, contact_info = :receptionistContact, assigned_tasks = :receptionistAssigned_tasks, shift_schedule = :receptionistShift_schedule, image = :receptionistImage WHERE id = :receptionistId");
                $query->bindParam("receptionistImage", $receptionistImageName);
            } else {
                // SweetAlert for validation errors
                echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Image upload failed!',
                    background: '#333',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                });
            });
            </script>";
            }
        } else {
            echo '<script> alert("Invalid image format. Allowed formats: png, jpg, jpeg, webp, avif, jfif."); </script>';
            exit;
        }
    }

    $query->bindParam(":receptionistName", $receptionistName);
    $query->bindParam(":receptionistContact", $receptionistContact);
    $query->bindParam(":receptionistAssigned_tasks", $receptionistAssigned_tasks);
    $query->bindParam(":receptionistShift_schedule", $receptionistShift_schedule);
    $query->bindParam(":receptionistId", $receptionistId);
    $query->execute();

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Receptionist updated!',
            text: 'Receptionist updated successfully.',
            background: '#333',
            color: '#fff',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'viewReceptionist.php';
            }
        });
    });
</script>";

}
?>

<!-- remove feedback -->

<?php
if (isset($_GET['fRemove'])) {
    $feedbackid = $_GET['fRemove'];
    $query = $pdo->prepare("delete from feedback where id = :feedbackId");
    $query->bindParam("feedbackId", $feedbackid);
    $query->execute();
    echo '<script>location.assign("viewFeedback.php")</script>';
}
?>

<!-- remove contact -->

<?php
if (isset($_GET['contactRemove'])) {
    $contactid = $_GET['contactRemove'];
    $query = $pdo->prepare("delete from contact where id = :contactId");
    $query->bindParam("contactId", $contactid);
    $query->execute();
    echo '<script>location.assign("viewContact.php")</script>';
}
?>

<!-- remove invoice -->

<?php
if (isset($_GET['invoiceRemove'])) {
    $invoiceId = $_GET['invoiceRemove'];
    $query = $pdo->prepare("delete from invoice where id = :invoiceId");
    $query->bindParam("invoiceId", $invoiceId);
    $query->execute();
    echo '<script>location.assign("viewInvoice.php")</script>';
}
?>

<!-- remove order -->

<?php
if (isset($_GET['orderRemove'])) {
    $orderId = $_GET['orderRemove'];
    $query = $pdo->prepare("delete from orders where id = :orderId");
    $query->bindParam("orderId", $orderId);
    $query->execute();
    echo '<script>location.assign("viewOrders.php")</script>';
}
?>