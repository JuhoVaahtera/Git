<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
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

    // Check if event ID is provided in the URL
    if (isset($_GET['id'])) {
        $eventId = $_GET['id'];
        $event = $dataAccess->getEventById($eventId);

        if ($event) {
            // Event found, display edit form
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Check if the form is submitted
                if (isset($_POST['update'])) {
                    // Update the event
                    $event->setTitle($_POST['title']);
                    $event->setDescription($_POST['description']);
                    $event->setAddress($_POST['address']);
                    $event->setStartTime($_POST['start_time']);
                    $event->setEndTime($_POST['end_time']);

                    if ($dataAccess->updateEvent($event)) {
                        echo "Event updated successfully.";

                        // Handle participants update
                        $selectedParticipants = isset($_POST['participants']) ? $_POST['participants'] : [];
                        $dataAccess->updateEventParticipants($event->getID(), $selectedParticipants);

                        header("Location: test.php");
                        exit();
                    } else {
                        echo "Error updating event.";
                    }
                } elseif (isset($_POST['delete'])) {
                    // Delete the event
                    if ($dataAccess->deleteEvent($event)) {
                        echo "Event deleted successfully.";
                        header('Location: test.php');
                        exit();
                    } else {
                        echo "Error deleting event.";
                    }
                }
            }
    ?>

            <h1>Edit Event</h1>
            <form method="post">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo $event->getTitle(); ?>"><br>

                <label for="description">Description:</label>
                <textarea name="description" id="description"><?php echo $event->getDescription(); ?></textarea><br>

                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?php echo $event->getAddress(); ?>"><br>

                <label for="start_time">Start Time:</label>
                <input type="datetime-local" name="start_time" id="start_time" value="<?php echo date('Y-m-d\TH:i:s', strtotime($event->getStartTime())); ?>"><br>

                <label for="end_time">End Time:</label>
                <input type="datetime-local" name="end_time" id="end_time" value="<?php echo date('Y-m-d\TH:i:s', strtotime($event->getEndTime())); ?>"><br>

                <h3>Select Participants:</h3>
                <?php
                    $participants = $dataAccess->getParticipants();
                    $eventParticipants = $dataAccess->getEventParticipants($event->getID());

                    foreach ($participants as $participant) {
                        $isChecked = in_array($participant->getID(), $eventParticipants) ? 'checked' : '';
                        echo '<input type="checkbox" name="participants[]" value="' . $participant->getID() . '" ' . $isChecked . '>';
                        echo $participant->getFirstName() . ' ' . $participant->getLastName() . '<br>';
                    }
                ?>

                <input type="submit" name="update" value="Update">
                <input type="submit" name="delete" value="Delete event">
            </form>

    <?php
        } else {
            echo "Event not found.";
        }
    } else {
        echo "Event ID not provided.";
    }
    ?>

</body>
</html>
