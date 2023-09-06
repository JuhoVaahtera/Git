<?php
require_once 'data-access.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $startTime = new DateTime($_POST['startTime']);
    $endTime = new DateTime($_POST['endTime']);

    // Create Event object
    $event = new Event($title, $description, $address, $startTime, $endTime);

    // Database connection
    $hostname = "localhost";
    $username = "Juho";
    $password = "juho";
    $database = "juho";

    $db = new mysqli($hostname, $username, $password, $database);

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Create DataAccess instance
    $dataAccess = new DataAccess($db);

    // Add Event
    $dataAccess->addEvent($event);

    // Close the database connection
    $db->close();

    // Redirect back to the form or a success page
    header("Location: event_form.php");
    exit();
}
?>