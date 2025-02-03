<?php

include('../query.php');

?>

<?php

$userName = $_SESSION['userName'] ?? '';
$userEmail = $_SESSION['userEmail'] ?? '';
$userId = $_SESSION['userId'] ?? '';
$lastLogin = 'No login record found';
$currentPassword = $newPassword = $confirmPassword = "";
$passwordErr = $passwordMsg = $profileMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["updateProfileUser"])) {
        $userName = trim($_POST['userName']);
        $userEmail = trim($_POST['userEmail']);

        // Update name and email in the database
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['name' => $userName, 'email' => $userEmail, 'id' => $userId]);

        // Update session variables
        $_SESSION["userName"] = $userName;
        $_SESSION["userEmail"] = $userEmail;

        $profileMsg = "Profile updated successfully!";

    }

    if (isset($_POST['changePassword'])) {
        $userId = $_SESSION['userId'];
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        $query = $pdo->prepare("SELECT * FROM users WHERE id = :userId");
        $query->bindParam('userId', $userId);
        $query->execute();
        $changePassword = $query->fetch(PDO::FETCH_ASSOC);
        $data_password = $changePassword['password'];

        if ($data_password == $currentPassword) {
            if ($newPassword == $confirmPassword) {
                $query = $pdo->prepare("UPDATE users SET password = :newPassword WHERE id = :userId");
                $query->bindParam('newPassword', $newPassword);
                $query->bindParam('userId', $userId);
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

<!-- remove appointment -->

<?php
if (isset($_GET['appointmentRemove'])) {
    $appointmentId = $_GET['appointmentRemove'];
    $query = $pdo->prepare("delete from appointments where id = :appointmentId");
    $query->bindParam("appointmentId", $appointmentId);
    $query->execute();
    echo '<script>location.assign("viewAppointment.php")</script>';
}
?>






