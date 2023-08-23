<?php

require_once 'datamodel.php';

$participant1 = new Participant('John', 'Doe', 'john@example.com');
$participant2 = new Participant('Jane', 'Smith', 'jane@example.com');

$event1 = new Event(
    'Sample Event 1',
    'This is a sample event description.',
    '123 Main Street',
    new DateTime('2023-08-23 10:00:00'),
    new DateTime('2023-08-23 15:00:00')
);

$event2 = new Event(
    'Sample Event 2',
    'Another sample event description.',
    '456 Elm Avenue',
    new DateTime('2023-08-24 12:00:00'),
    new DateTime('2023-08-24 18:00:00')
);

$event1->addParticipant($participant1);
$event1->addParticipant($participant2);
$event2->addParticipant($participant1);

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
