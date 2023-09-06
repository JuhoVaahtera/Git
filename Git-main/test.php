<?php
require_once 'data-access.php';  

/*
(<?php echo $participant->getEmail();?>);
*/


$event1 = new Event(
    'Fortinite',
    'Fornite battlepass tournament',
    '123 Main Street',
    new DateTime('2023-08-23 10:00:00'),
    new DateTime('2023-08-23 15:00:00')
);

$event2 = new Event(
    'Music festivale',
    'Another Ed Sheeran concert',
    '456 Elm Avenue',
    new DateTime('2023-08-24 12:00:00'),
    new DateTime('2023-08-24 18:00:00')
);

// Assuming you have a database connection established
$dbConnection = new mysqli('localhost', 'Juho', 'juho', 'juho');
$dataAccess = new DataAccess($dbConnection);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Information</title>
</head>
<body>
    
    <h1><?php echo $event1->getTitle(); ?></h1>
    <p><strong>Description:</strong> <?php echo $event1->getDescription(); ?></p>
    <p><strong>Address:</strong> <?php echo $event1->getAddress(); ?></p>
    <p><strong>Start Time:</strong> <?php echo $event1->getStartTime()->format('Y-m-d H:i:s'); ?></p>
    <p><strong>End Time:</strong> <?php echo $event1->getEndTime()->format('Y-m-d H:i:s'); ?></p>
    <h2>Participants:</h2>
    <ul>
        <?php foreach ($dataAccess->getParticipants() as $participant): ?>
            <li><?php echo $participant->getFirstName() . ' ' . $participant->getLastName(); ?></li>
        <?php endforeach; ?>
    </ul>

</body>
</html>

