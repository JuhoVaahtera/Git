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
