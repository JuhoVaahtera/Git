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
        <a href="event_form.php">Lisää eventti</a>
        <a href="login.html">Kirjaudu</a>
    </nav>

<h1>Kaikki käyttäjät</h1>

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
        // Include data-access.php file, which contains the definition of the DataAccess class and the database connection.
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

        // Use DataAccess class to fetch participants from the database.
        $participants = $dataAccess->getParticipants();

        foreach ($participants as $participant) {
            echo '<tr>';
            echo '<td>' . $participant->getID() . '</td>';
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
