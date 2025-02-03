<?php
include('components/header.php');  // Include your DB connection

// Check if service_id is passed via GET
if (isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];

    // Prepare the query to get stylists based on service_id
    $query = $pdo->prepare("SELECT * FROM stylists WHERE service_id = :service_id");
    $query->bindParam(':service_id', $service_id);
    $query->execute();

    // Fetch all matching stylists
    $stylists = $query->fetchAll(PDO::FETCH_ASSOC);

    // Check if stylists are found
    if ($stylists) {
        foreach ($stylists as $stylist) {
            echo "<option value='{$stylist['id']}'>{$stylist['name']}</option>";
        }
    } else {
        echo "<option>No stylists available</option>";
    }
}
?>