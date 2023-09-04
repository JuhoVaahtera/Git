<?php
require_once 'data-access.php'; // Korvaa 'your_data_access_file.php' todellisella tiedostonimellä, jossa DataAccess-luokka on määritelty

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    $newEvent = new Event($title, $description, $address, $startTime, $endTime);

    // Lisää tapahtuma tietokantaan
    // Tässä käytetään DataAccess-luokkaa, joka on määritelty tiedostossa 'your_data_access_file.php'
    $dataAccess->addEvent($event);

    // Käsittele osallistujat
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'participant') === 0) {
            $participant = new Participant(null, $value, null, null); // Luo uusi osallistuja ilman ID:tä
            $newEvent->addParticipant($participant);

            // Lisää osallistuja tietokantaan
            $dataAccess->addParticipant($participant);
        }
    }

    // Ohjaa takaisin lomakkeelle tai näytä vahvistusviesti
    // Voit lisätä tarvittavat ohjaukset tähän
}
?>