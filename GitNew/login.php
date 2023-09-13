<?php
require_once 'data-access.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve the user with the given email from the database
    $participant = $dataAccess->getParticipantByEmail($email);

    echo "omg".$password." joo ".$participant->getPassword()."juu";

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