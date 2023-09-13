<?php
require_once 'data-access.php';  


// Assuming you have a database connection established
$dbConnection = new mysqli('localhost', 'Juho', 'juho', 'juho');
$dataAccess = new DataAccess($dbConnection);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Information</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
</head>

<body>
    <nav>
        <a href="test.php">Home</a>
        <a href="kayttajat.php">Käyttäjät</a>
        <a href="event_form.php">Lisää eventti</a>
        <a href="login.html">kirjaudu</a>

    </nav>
    
    <?php foreach ($dataAccess->getEvents() as $event): ?>
        <h1><?php echo $event->getTitle(); ?></h1>
        <p><strong>Description:</strong> <?php echo $event->getDescription(); ?></p>
        <p><strong>Address:</strong> <?php echo $event->getAddress(); ?></p>
        <p><strong>Start Time:</strong> <?php echo $event->getStartTime();?></p>
        <p><strong>End Time:</strong> <?php echo $event->getEndTime(); ?></p>

        <h2>Participants:</h2>
        <ul>
            <?php foreach ($event->getParticipants() as $participant): ?>
                <li><?php echo $participant->getFirstName() . ' ' . $participant->getLastName(); ?> (<?php echo $participant->getEmail(); ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
    

</body>
</html>
