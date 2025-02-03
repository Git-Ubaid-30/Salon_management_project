<?php

include('../query.php');

?>

<?php

$stylistName = $_SESSION['stylistName'] ?? '';
$stylistEmail = $_SESSION['stylistEmail'] ?? '';
$stylistId = $_SESSION['stylistId'] ?? '';
$lastLogin = 'No login record found';
$currentPassword = $newPassword = $confirmPassword = "";
$passwordErr = $passwordMsg = $profileMsg = "";

// Update Profile and Image Upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["updateProfileStylist"])) {
        $stylistName = trim($_POST['stylistName']);
        $stylistEmail = trim($_POST['stylistEmail']);

        // Update name and email in the database
        $stmt = $pdo->prepare("UPDATE stylists SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['name' => $stylistName, 'email' => $stylistEmail, 'id' => $stylistId]);

        // Update session variables
        $_SESSION["stylistName"] = $stylistName;
        $_SESSION["stylistEmail"] = $stylistEmail;

        $profileMsg = "Profile updated successfully!";
        
    }

    if (isset($_POST['changePassword'])) {
        $stylistId = $_SESSION['stylistId'];

        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        $query = $pdo->prepare("SELECT * FROM stylists WHERE id = :stylistId");
        $query->bindParam('stylistId', $stylistId);
        $query->execute();
        $changePassword = $query->fetch(PDO::FETCH_ASSOC);
        $data_password = $changePassword['password'];

        if ($data_password == $currentPassword) {
            if ($newPassword == $confirmPassword) {
                $query = $pdo->prepare("UPDATE stylists SET password = :newPassword WHERE id = :stylistId");
                $query->bindParam('newPassword', $newPassword);
                $query->bindParam('stylistId', $stylistId);
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
