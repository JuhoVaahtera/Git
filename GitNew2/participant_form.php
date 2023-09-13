<?php
require_once 'data-access.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];

    // Create Participant object
    $participant = new Participant(null, $firstName , $lastName, $email);

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

    // Add Participant
    $dataAccess->addParticipant($participant);

    // Close the database connection
    $db->close();

    // Redirect back to the form or a success page
    
    exit();
}
?>
