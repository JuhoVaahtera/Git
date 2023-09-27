<?php
require_once 'data-access.php';

// Load environment variables from .env file
$envFile = __DIR__ . '/.env';

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// Use environment variables for database connection
$dbHost = $_ENV['MYSQL_HOST'];
$dbUser = $_ENV['MYSQL_USER'];
$dbPassword = $_ENV['MYSQL_PASSWORD'];
$dbName = $_ENV['MYSQL_DATABASE'];

$dbConnection = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
$dataAccess = new DataAccess($dbConnection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    $existingParticipant = $dataAccess->getParticipantByEmail($email);

    if ($existingParticipant) {
        echo "This email is already in use. Please use a different email address. You will be redirected back to register in a short moment.";
        header("Refresh:7; url=register.html");
    } else {
        // Create a Participant object and add it to the database
        $participant = new Participant(null, $firstName, $lastName, $email, $password);
        $participant->setPassword($password);
        $dataAccess->addParticipant($participant);
        header("Refresh:0; url=login.html");
    }

    // Redirect to the login page or any other page as needed
    exit();
}
?>
