<?php
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
        

        if ($row) {
            
            $participant = new Participant($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);
            
            return $participant;
            
        }
    
        return null;
    }


    public function addEvent($event) {
        $query = "INSERT INTO events (title, description, address, start_time, end_time) VALUES (?,?,?,?,?)";
        $stmt = $this->db->prepare($query);
        $tl = $event->getTitle();
        $dc = $event->getDescription();
        $ad = $event->getAddress();
        $st = $event->getStartTime()->format('Y-m-d H:i:s');
        $et = $event->getEndTime()->format('Y-m-d H:i:s');
        $stmt->bind_param('sssss', $tl, $dc, $ad, $st, $et);
        $stmt->execute();
        $stmt->close();
    }
    
    public function getEvents() {
        $query = "SELECT * FROM events";
        $result = $this->db->query($query);

        $events = [];
        while ($row = $result->fetch_assoc()) {
            $event = new Event($row['id'], $row['title'], $row['description'], $row['address'], $row['start_time'], $row['end_time']);
            $events[] = $event;
        }

        return $events;
    }

    public function updateEvents($event) {
        $query = "UPDATE events SET name = ?, email = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssi", $participant->getName(), $participant->getEmail(), $participant->getID());
        $stmt->execute();
        $stmt->close();
    }
    // Event CRUD operations (similar to Participant operations)
}

class Participant {
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $password;

    public function __construct($id, $firstName, $lastName, $email, $password) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getID() {
        return $this->id;
    }

    public function setID($id) {
        if ($this->id === null) {
            $this->id = $id;
        }
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
}

class Event {
    private $id;
    private $title;
    private $description;
    private $address;
    private $startTime;
    private $endTime;
    private $participants = array();
    
    public function __construct($id, $title, $description, $address, $startTime, $endTime) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->address = $address;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }
    public function getID() {
        return $this->id;
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

    public function getEvents() {
        return $this->events;
    }

}
// Database connection
$hostname = "localhost";
$username = "ts";
$password = "1234";
$database = "ts";

$db = new mysqli($hostname, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$dataAccess = new DataAccess($db);
// Voit nyt käyttää $dataAccessia osallistujien ja tapahtumien tietojen käsittelyyn.
?>
