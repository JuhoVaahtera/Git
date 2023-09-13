<?php
require_once 'data-access.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    $existingParticipant = $dataAccess->getParticipantByEmail($email);

    if ($existingParticipant) {
        echo "This email is already in use. Please use diffrent email address. You will be redirected back to register in a short moment.";
        header("Refresh:7; url=register.html");
    } else {
        // Create a Participant object and add it to the database
        $participant = new Participant(null, $firstName, $lastName, $email, $password);
        $participant->setPassword($password);
        $dataAccess->addParticipant($participant);
        header("Refresh:0; url=login.html");
    }

    // Redirect to login page or any other page as needed
    
    exit();
}
?>