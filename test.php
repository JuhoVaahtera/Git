<?php

require_once 'datamodel.php';
require_once 'data-access.php';

$databaseConnection = new YourDatabaseConnection(); // Korvaa tämä tietokantayhteydelläsi
$dataAccess = new DataAccess($databaseConnection);

$participant1 = new Participant('Tjimi', 'The God', 'tjimi@example.com');
$participant2 = new Participant('Tjimitte', 'The Goddes', 'tjmi@example.com');

$event1 = new Event(
    'Fortinite',
    'Fornite battlepass tournament',
    '123 Main Street',
    new DateTime('2023-08-23 10:00:00'),
    new DateTime('2023-08-23 15:00:00')
);

$event2 = new Event(
    'Music festivale',
    'Another fucking Ed Sheeran consert',
    '456 Elm Avenue',
    new DateTime('2023-08-24 12:00:00'),
    new DateTime('2023-08-24 18:00:00')
);

// Lisää osallistujat tietokantaan
$dataAccess->addParticipant($participant1);
$dataAccess->addParticipant($participant2);

// Lisää tapahtumat tietokantaan
$dataAccess->addEvent($event1);
$dataAccess->addEvent($event2);

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
        <?php foreach ($event1->getParticipants() as $participant): ?>
            <li><?php echo $participant->getFirstName() . ' ' . $participant->getLastName(); ?> (<?php echo $participant->getEmail(); ?>)</li>
        <?php endforeach; ?>
    </ul>

    <hr>

    <h1><?php echo $event2->getTitle(); ?></h1>
    <p><strong>Description:</strong> <?php echo $event2->getDescription(); ?></p>
    <p><strong>Address:</strong> <?php echo $event2->getAddress(); ?></p>
    <p><strong>Start Time:</strong> <?php echo $event2->getStartTime()->format('Y-m-d H:i:s'); ?></p>
    <p><strong>End Time:</strong> <?php echo $event2->getEndTime()->format('Y-m-d H:i:s'); ?></p>
    <h2>Participants:</h2>
    <ul>
        <?php foreach ($event2->getParticipants() as $participant): ?>
            <li><?php echo $participant->getFirstName() . ' ' . $participant->getLastName(); ?> (<?php echo $participant->getEmail(); ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
