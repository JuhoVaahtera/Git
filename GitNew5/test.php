<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Events</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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

    $events = $dataAccess->getEvents();

    foreach ($events as $event):
        $participants = $dataAccess->getParticipantsForEvent($event->getID()); // Get participants for the current event
    ?>

        <div class="event-box">
            <h1><?php echo $event->getTitle(); ?></h1>
            <p><strong>Description:</strong> <?php echo $event->getDescription(); ?></p>
            <p><strong>Address:</strong> <?php echo $event->getAddress(); ?></p>
            <p><strong>Start Time:</strong> <?php echo date('d-m-Y H:i:s', strtotime($event->getStartTime())); ?></p>
            <p><strong>End Time:</strong> <?php echo date('d-m-Y H:i:s', strtotime($event->getEndTime())); ?></p>
            <p><strong>Kutsutut:</strong> <?php echo count($participants); ?></p>
            
            <!-- Muokkaus nappi -->
            <a href="edit_event.php?id=<?php echo $event->getID(); ?>">Muokkaa</a>
            <form method="post" style="display: inline;">
                <input type="hidden" name="event_id" value="<?php echo $event->getID(); ?>">
            </form>
        </div>

    <?php endforeach; ?>
    
</body>
</html>
