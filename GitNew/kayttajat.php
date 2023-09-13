<!DOCTYPE html>
<html>
<head>
    <title>Osallistujat</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
</head>
<body>
<nav>
        <a href="test.php">Home</a>
        <a href="kayttajat.php">Käyttäjät</a>
        <a href="event_form.html">Lisää eventti</a>
        <a href="login.html">kirjudu</a>

    </nav>

<h1>Osallistujat</h1>

    

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Etunimi</th>
            <th>Sukunimi</th>
            <th>Sähköposti</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Sisällytä data-access.php-tiedosto, joka sisältää DataAccess-luokan määrittelyn ja tietokantayhteyden.
        require_once 'data-access.php';

        // Käytä DataAccess-luokan getParticipants-metodia osallistujien hakemiseen tietokannasta.
        $participants = $dataAccess->getParticipants();

        foreach ($participants as $participant) {
            echo '<tr>';
            echo '<td>' . $participant->getId() . '</td>';
            echo '<td>' . $participant->getFirstName() . '</td>';
            echo '<td>' . $participant->getLastName() . '</td>';
            echo '<td>' . $participant->getEmail() . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>

</body>
</html>
