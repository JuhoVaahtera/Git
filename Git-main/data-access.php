<?php
class DataAccess {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Participant CRUD operations
    public function addParticipant($participant) {
        $query = "INSERT INTO participants (first_name, last_name, email) VALUES (?,?,?)";
        $stmt = $this->db->prepare($query);
        $fn = $participant->getFirstName();
        $ln = $participant->getLastName();
        $e = $participant->getEmail();
        $stmt->bind_param('sss', $fn, $ln, $e);
        $stmt->execute();
        $stmt->close();
    }

    public function getParticipants() {
        $query = "SELECT * FROM participants";
        $result = $this->db->query($query);

        $participants = [];
        while ($row = $result->fetch_assoc()) {
            $participant = new Participant($row['id'], $row['first_name'], $row['last_name'], $row['email']);
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
                        $participant = new Participant(null, $value, null, null); // Create a new participant object
                        $newEvent->addParticipant($participant);
                    }
                }
        
                // Now, use the DataAccess class to add the new event to the database
                $dataAccess = new DataAccess($db);
        
                if ($dataAccess->addEvent($newEvent)) {
                    // Event and participants added successfully
                    echo "Event and participants added successfully.";
                } else {
                    // Error handling for insertion failure
                    echo "Error adding event and participants.";
                }
        
                // You can also add redirection logic here if needed
            } else {
                // Handle case when required form fields are missing or contain invalid data
                echo "Please fill out all required fields with valid data.";
            }
        }
    }


    // Event CRUD operations (similar to Participant operations)
}

class Participant {
    private $id;
    private $firstName;
    private $lastName;
    private $email;

    public function __construct($id, $firstName, $lastName, $email) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    public function getID() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getEmail() {
        return $this->email;
    }
}

class Event {
    private $title;
    private $description;
    private $address;
    private $startTime;
    private $endTime;
    private $participants = array();
    
    public function __construct($title, $description, $address, $startTime, $endTime) {
        $this->title = $title;
        $this->description = $description;
        $this->address = $address;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function getAddress() {
        return $this->address;
    }
    
    public function setAddress($address) {
        $this->address = $address;
    }
    
    public function getStartTime() {
        return $this->startTime;
    }
    
    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }
    
    public function getEndTime() {
        return $this->endTime;
    }
    
    public function setEndTime($endTime) {
        $this->endTime = $endTime;
    }
    
    public function addParticipant($participant) {
        $this->participants[] = $participant;
    }
    
    public function removeParticipant($participant) {
        $index = array_search($participant, $this->participants);
        if ($index !== false) {
            array_splice($this->participants, $index, 1);
        }
    }

    public function getParticipants() {
        return $this->participants;
    }

}
// Database connection
$hostname = "localhost";
$username = "leevi";
$password = "leevi";
$database = "leevi";

$db = new mysqli($hostname, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$dataAccess = new DataAccess($db);
// Voit nyt käyttää $dataAccessia osallistujien ja tapahtumien tietojen käsittelyyn.
?>
