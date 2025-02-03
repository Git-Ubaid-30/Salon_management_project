<?php
require_once('php/query.php'); // Include the PDO connection file

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Error: No data to save.'); location.replace('./');</script>";
    exit;
}

// Check if required fields are provided
if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['start_datetime']) || empty($_POST['end_datetime'])) {
    echo "<script>alert('All fields are required.'); location.replace('./');</script>";
    exit;
}

// Extract POST data and sanitize it
$title = htmlspecialchars($_POST['title']);
$description = htmlspecialchars($_POST['description']);
$start_datetime = htmlspecialchars($_POST['start_datetime']);
$end_datetime = htmlspecialchars($_POST['end_datetime']);

// Assuming the stylist is logged in, get the stylist_id from session
if (empty($_SESSION['stylistId'])) {
    echo "<script>alert('Error: Stylist ID is missing.'); location.replace('./');</script>";
    exit;
}

$stylist_id = $_SESSION['stylistId']; // Get stylist_id from session

// Convert datetime to the correct format
$start_datetime = date('Y-m-d H:i:s', strtotime($start_datetime));
$end_datetime = date('Y-m-d H:i:s', strtotime($end_datetime));

// Prepare the SQL statement for insert or update
if (empty($_POST['id'])) {
    // Insert new schedule
    $sql = "INSERT INTO schedule_list (title, description, start_datetime, end_datetime, stylist_id) 
            VALUES (:title, :description, :start_datetime, :end_datetime, :stylist_id)";
} else {
    // Update existing schedule
    $sql = "UPDATE schedule_list SET title = :title, description = :description, 
            start_datetime = :start_datetime, end_datetime = :end_datetime WHERE id = :id";
}

try {
    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':start_datetime', $start_datetime);
    $stmt->bindParam(':end_datetime', $end_datetime);
    $stmt->bindParam(':stylist_id', $stylist_id, PDO::PARAM_INT); // Bind stylist_id

    // If updating, bind the ID
    if (!empty($_POST['id'])) {
        $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
    }

    // Execute the query
    $stmt->execute();

    // Store schedule details in the session
    $_SESSION['last_schedule'] = [
        'title' => $title,
        'description' => $description,
        'start_datetime' => $start_datetime,
        'end_datetime' => $end_datetime,
        'stylist_id' => $stylist_id // Store stylist_id in the session as well
    ];

    // Success message
    echo "<script>alert('Schedule Successfully Saved.'); location.replace('./');</script>";
} catch (PDOException $e) {
    // Error message
    echo "<pre>An error occurred.<br>Error: " . $e->getMessage() . "<br>SQL: " . $sql . "<br></pre>";
}
?>