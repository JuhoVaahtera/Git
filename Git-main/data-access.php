<?php

require_once 'event.php';
require_once 'participant.php';
class DataAccess {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Participant CRUD operations
    public function addParticipant($participant) {
        $query = "INSERT INTO participants (first_name, last_name, email, password) VALUES (?,?,?,?)";
        $stmt = $this->db->prepare($query);
        $fn = $participant->getFirstName();
        $ln = $participant->getLastName();
        $e = $participant->getEmail();
        $p = $participant->getPassword();
        $stmt->bind_param('ssss', $fn, $ln, $e, $p);
        $stmt->execute();
        $stmt->close();
    }

    public function getParticipants() {
        $query = "SELECT * FROM participants";
        $result = $this->db->query($query);

        $participants = [];
        while ($row = $result->fetch_assoc()) {
            $participant = new Participant($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);
            $participants[] = $participant;
        }

        return $participants;
    }

    public function updateParticipant($participant) {
        $query = "UPDATE participants SET name = ?, email = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssi", $participant->getName(), $participant->getEmail(), $participant->getID());
        $stmt->execute();
        $stmt->close();
    }

    public function deleteParticipant($participant) {
        $query = "DELETE FROM participants WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $participant->getID());
        $stmt->execute();
        $stmt->close();
    }

    public function getParticipantByEmail($email) {
        $query = "SELECT * FROM participants WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        echo " getParticipantByEmail email". $email;
        

        if ($row) {
            echo " we are in if now <br />";
            
            $participant = new Participant($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);
            
            return $participant;
            
        }
    
        return null;
    }

    public function addEvent($event) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the required form fields are set
            if (isset($_POST['title'], $_POST['description'], $_POST['address'], $_POST['startTime'], $_POST['endTime'])) {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $address = $_POST['address'];
                $startTime = $_POST['startTime'];
                $endTime = $_POST['endTime'];
        
                // Create a new Event object with the form data
                $newEvent = new Event($title, $description, $address, $startTime, $endTime);
        
                // Add participants based on form fields
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'participant') === 0) {
                        $participant = new Participant(null, $value, null, null, null); // Create a new participant object
                        $newEvent->addParticipant($participant);
                    }
                }
        
                // Now, use the DataAccess class to add the new event to the databas
        
                // You can also add redirection logic here if needed
            } else {
                // Handle case when required form fields are missing or contain invalid data
                echo "Please fill out all required fields with valid data.";
            }
        }
    }


    // Event CRUD operations (similar to Participant operations)


    
    
    // Add a setPassword method to Participant class
    
    
    // Modify the Participant constructor
}

// Database connection
$hostname = "localhost";
$username = "Juho";
$password = "juho";
$database = "juho";

$db = new mysqli($hostname, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$dataAccess = new DataAccess($db);
// Voit nyt käyttää $dataAccessia osallistujien ja tapahtumien tietojen käsittelyyn.
?>
