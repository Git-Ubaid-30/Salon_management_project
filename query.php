<?php
session_start();
include('dbcon.php');

?>

<?php 

$userNameErr = $userEmailErr = $userPasswordErr = $userConfirmPasswordErr = "";
$userName = $userEmail = $userPassword = $userConfirmPassword = "";

if (isset($_POST["userRegister"])) {
    $userName = $_POST["uName"];
    $userEmail = $_POST["uEmail"];
    $userPassword = $_POST["uPassword"];
    $userConfirmPassword = $_POST["uConfirmPassword"];

    if (empty($userName)) {
        $userNameErr = "Name is required";
    }

    if (empty($userEmail)) {
        $userEmailErr = "Email is required";
    } else {
        $query = $pdo->prepare("SELECT * FROM users WHERE email = :userEmail");
        $query->bindParam(":userEmail", $userEmail);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $userEmailErr = "Email already exists";
        }
    }

    if (empty($userPassword)) {
        $userPasswordErr = "Password is required";
    }

    if (empty($userConfirmPassword)) {
        $userConfirmPasswordErr = "Confirm Password is required";
    } else {
        if ($userPassword != $userConfirmPassword) {
            $userConfirmPasswordErr = "Passwords do not match";
        }
    }

    if (empty($userNameErr) && empty($userEmailErr) && empty($userPasswordErr) && empty($userConfirmPasswordErr)) {
        $query = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:uName, :uEmail, :uPassword)");
        $query->bindParam(":uName", $userName);
        $query->bindParam(":uEmail", $userEmail);
        $query->bindParam(":uPassword", $userPassword);
        $query->execute();

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Successful',
                    text: 'You have been registered successfully!',
                    confirmButtonColor: '#3085d6',
                    background: '#333',
                    color: '#fff'
                }).then(function() {
                    window.location = 'login.php';
                });
            });
        </script>";
    }
}

?>

<?php

// Login process
$uEmail = $uPass = "";
$uEmailErr = $uPassErr = "";

if (isset($_POST["userLogin"])) {
    $uEmail = $_POST["uEmail"];
    $uPass = $_POST["uPassword"];

    if (empty($uName)) {
        $uNameErr = "Name is required.";
    }

    if (empty($uEmail)) {
        $uEmailErr = "Email is required.";
    }

    if (empty($uPass)) {
        $uPassErr = "Password is required.";
    }

    if (empty($uEmailErr) && empty($uPassErr)) {
        // Check in users table
        $query = $pdo->prepare("SELECT * FROM users WHERE email = :uEmail");
        $query->bindParam(":uEmail", $uEmail);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        // Check in receptionist table if not found in users table
        if (!$user) {
            $query = $pdo->prepare("SELECT * FROM receptionists WHERE email = :uEmail");
            $query->bindParam(":uEmail", $uEmail);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);
        }

        // Check in stylist table if not found in users or receptionist table
        if (!$user) {
            $query = $pdo->prepare("SELECT * FROM stylists WHERE email = :uEmail");
            $query->bindParam(":uEmail", $uEmail);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);
        }

        if ($user) {
            if ($uPass === $user["password"]) { // Directly compare plain-text password
                if ($user['role_id'] == 1) { // Admin
                    $_SESSION["adminId"] = $user["id"];
                    $_SESSION["adminEmail"] = $user["email"];
                    $_SESSION["adminName"] = $user["name"];
                    header('Location: admin/index.php');
                    exit();
                } elseif ($user['role_id'] == 2) { // User
                    $_SESSION["userId"] = $user["id"];
                    $_SESSION["userEmail"] = $user["email"];
                    $_SESSION["userName"] = $user["name"];
                    header('Location: index.php');
                    exit();
                } elseif ($user['role_id'] == 3) { // Receptionist
                    $_SESSION["receptionistsId"] = $user["id"];
                    $_SESSION["receptionistsEmail"] = $user["email"];
                    $_SESSION["receptionistsName"] = $user["name"];
                    header('Location: receptionists/index.php');
                    exit();
                } elseif ($user['role_id'] == 4) { // Stylist
                    $_SESSION["stylistId"] = $user["id"];
                    $_SESSION["stylistEmail"] = $user["email"];
                    $_SESSION["stylistName"] = $user["name"];
                    header('Location: stylist/index.php');
                    exit();
                }
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: 'Invalid password.',
                            confirmButtonColor: '#3085d6',
                            background: '#333',
                            color: '#fff'
                        }).then(function() {
                            window.location = 'login.php';
                        });
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: 'User not found.',
                        confirmButtonColor: '#3085d6',
                        background: '#333',
                        color: '#fff'
                    }).then(function() {
                        window.location = 'login.php';
                    });
                });
            </script>";
        }
    }
}

?>