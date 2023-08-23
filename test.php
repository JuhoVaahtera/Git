<?php
// Sisällytetään luokat tiedostosta datamodel.php
require_once 'datamodel.php';

// Luodaan osallistujaobjekti
$participant1 = new Participant('Matti', 'Meikäläinen', 'matti@example.com');

// Luodaan tapahtumaobjekti ja lisätään osallistuja siihen
$event1StartTime = new DateTime('2023-08-25 10:00:00');
$event1EndTime = new DateTime('2023-08-25 15:00:00');
$event1 = new Event('Tapahtuma 1', 'Tämä on ensimmäinen tapahtuma', 'Tapahtumakatu 123', $event1StartTime, $event1EndTime);
$event1->addParticipant($participant1);

// Luodaan toinen tapahtumaobjekti ilman osallistujia
$event2StartTime = new DateTime('2023-09-01 14:00:00');
$event2EndTime = new DateTime('2023-09-01 18:00:00');
$event2 = new Event('Tapahtuma 2', 'Tämä on toinen tapahtuma', 'Toinenkatu 456', $event2StartTime, $event2EndTime);

// HTML-sivun luonti
$html = '<html>
<head>
    <title>Testisivu</title>
</head>
<body>
    <h1>Tapahtumat ja osallistujat</h1>
    <h2>Tapahtuma 1</h2>
    <p><strong>Otsikko:</strong> ' . $event1->getTitle() . '</p>
    <p><strong>Kuvaus:</strong> ' . $event1->getDescription() . '</p>
    <p><strong>Osoite:</strong> ' . $event1->getAddress() . '</p>
    <p><strong>Aika:</strong> ' . $event1->getStartTime()->format('Y-m-d H:i') . ' - ' . $event1->getEndTime()->format('Y-m-d H:i') . '</p>
    <h3>Osallistujat:</h3>
    <ul>';
foreach ($event1->getParticipants() as $participant) {s
    $html .= '<li>' . $participant->getFirstName() . ' ' . $participant->getLastName() . ' (' . $participant->getEmail() . ')</li>';
}
$html .= '</ul>
    <h2>Tapahtuma 2</h2>
    <p><strong>Otsikko:</strong> ' . $event2->getTitle() . '</p>
    <p><strong>Kuvaus:</strong> ' . $event2->getDescription() . '</p>
    <p><strong>Osoite:</strong> ' . $event2->getAddress() . '</p>
    <p><strong>Aika:</strong> ' . $event2->getStartTime()->format('Y-m-d H:i') . ' - ' . $event2->getEndTime()->format('Y-m-d H:i') . '</p>
</body>
</html>';

// Tulostetaan HTML-sivu
echo $html;
?>