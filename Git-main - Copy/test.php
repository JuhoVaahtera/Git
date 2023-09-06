<?php
require_once 'data-access.php';  


// Assuming you have a database connection established
$dbConnection = new mysqli('localhost', 'ts', '1234', 'ts');
$dataAccess = new DataAccess($dbConnection);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Information</title>
</head>
<body>
    <?php foreach ($dataAccess->getEvents() as $event);?>
    <h1><?php echo $event->getTitle(); ?></h1>
    <p><strong>Description:</strong> <?php echo $event->getDescription(); ?></p>
    <p><strong>Address:</strong> <?php echo $event->getAddress(); ?></p>
    <p><strong>Start Time:</strong> <?php echo $event->getStartTime();?></p>
    <p><strong>End Time:</strong> <?php echo $event->getEndTime(); ?></p>
    
    <h2>Participants:</h2>
    <ul>
        <?php foreach ($dataAccess->getParticipants() as $participant): ?>
            <li><?php echo $participant->getFirstName() . ' ' . $participant->getLastName(); ?> (<?php echo $participant->getEmail(); ?>)</li>
        <?php endforeach; ?>
    </ul>

</body>
</html>