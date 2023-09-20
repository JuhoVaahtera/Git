<?php
require_once 'data-access.php';

// Database connection
$hostname = "localhost";
$username = "leevi";
$password = "leevi";
$database = "leevi";

$db = new mysqli($hostname, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$dataAccess = new DataAccess($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve the user with the given email from the database
    $participant = $dataAccess->getParticipantByEmail($email);

    if ($participant && password_verify($password, $participant->getPassword())) {
        // Successful login, redirect to test.php or any other page
        header('Location: test.php');
        exit();
    } else {
        // Invalid login, display an error message
        echo "Invalid email or password";
    }
}
?>
