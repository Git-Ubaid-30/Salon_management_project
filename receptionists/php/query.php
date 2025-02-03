<?php

include('../query.php');

?>

<?php

$receptionistsName = $_SESSION['receptionistsName'] ?? '';
$receptionistsEmail = $_SESSION['receptionistsEmail'] ?? '';
$receptionistsId = $_SESSION['receptionistsId'] ?? '';
$lastLogin = 'No login record found';
$currentPassword = $newPassword = $confirmPassword = "";
$passwordErr = $passwordMsg = $profileMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["updateProfileReceptionists"])) {
        $receptionistsName = trim($_POST['receptionistsName']);
        $receptionistsEmail = trim($_POST['receptionistsEmail']);

        // Update name and email in the database
        $stmt = $pdo->prepare("UPDATE receptionists SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['name' => $receptionistsName, 'email' => $receptionistsEmail, 'id' => $receptionistsId]);

        // Update session variables
        $_SESSION["receptionistsName"] = $receptionistsName;
        $_SESSION["receptionistsEmail"] = $receptionistsEmail;

        $profileMsg = "Profile updated successfully!";
    }

    if (isset($_POST['changePassword'])) {
        $receptionistsId = $_SESSION['receptionistsId'];
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        $query = $pdo->prepare("SELECT * FROM receptionists WHERE id = :receptionistsId");
        $query->bindParam('receptionistsId', $receptionistsId);
        $query->execute();
        $changePassword = $query->fetch(PDO::FETCH_ASSOC);
        $data_password = $changePassword['password'];

        if ($data_password == $currentPassword) {
            if ($newPassword == $confirmPassword) {
                $query = $pdo->prepare("UPDATE receptionists SET password = :newPassword WHERE id = :receptionistsId");
                $query->bindParam('newPassword', $newPassword);
                $query->bindParam('receptionistsId', $receptionistsId);
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
