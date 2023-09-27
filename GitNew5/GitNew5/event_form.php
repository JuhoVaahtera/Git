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
    // Check if the required form fields are set
    if (isset($_POST['title'], $_POST['description'], $_POST['address'], $_POST['startTime'], $_POST['endTime'], $_POST['participants'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $address = $_POST['address'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $startTime = new DateTime($startTime);
        $endTime = new DateTime($endTime);

        // Create a new Event object with the form data
        $newEvent = new Event(null, $title, $description, $address, $startTime, $endTime);

        // Add participants based on selected checkboxes
        if (isset($_POST['participants']) && is_array($_POST['participants'])) {
            foreach ($_POST['participants'] as $participantId) {
                // Fetch the participant from the database based on the ID
                $participant = $dataAccess->getParticipantById($participantId);
                if ($participant) {
                    $newEvent->addParticipant($participant);
                }
            }
        }

        // Now, use the DataAccess class to add the new event to the database
        if ($dataAccess->addEvent($newEvent)) {
            // Event and participants added successfully
            echo "Event and participants added successfully.";

            // Redirect to test.php
            header('Location: test.php');
            exit();
        } else {
            // Error handling for insertion failure
            echo "Error adding event and participants.";
        }
    } else {
        // Handle case when required form fields are missing or contain invalid data
        echo "Please fill out all required fields with valid data.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
</head>
<body>
    <nav>
        <a href="test.php">Home</a>
        <a href="kayttajat.php">Käyttäjät</a>
        <a href="event_form.php">Lisää eventti</a>
        <a href="login.html">Kirjaudu</a>
    </nav>
    <h2>Add Event</h2>

    <form action="event_form.php" method="post">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea><br>

        <label for="address">Address:</label>
        <input type="text" name="address" required><br>

        <label for="startTime">Start Time:</label>
        <input type="datetime-local" name="startTime" required><br>

        <label for="endTime">End Time:</label>
        <input type="datetime-local" name="endTime" required><br>

        <h3>Select Participants:</h3>

        <?php
            $participants = $dataAccess->getParticipants();

            foreach ($participants as $participant) {
                echo '<input type="checkbox" name="participants[]" value="' . $participant->getID() . '">';
                echo $participant->getFirstName() . ' ' . $participant->getLastName() . '<br>';
            }
        ?>
        <p></p>
        <input type="submit" value="Add Event">
    </form>
</body>
</html>
