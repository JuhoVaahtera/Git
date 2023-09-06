<?php

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

    public function getEvent() {
        return $this->event;
    }


    public function addEvent($event) {
        $query = "INSERT INTO events (title, description, address, star_time, end_time) VALUES (?,?,?,?,?)";
        $stmt = $this->db->prepare($query);
        $tl = $events->getTitle();
        $dc = $events->getDescription();
        $ad = $events->getAddress();
        $st = $events->getStartTime();
        $et = $events->getEndTime();
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
            $event[] = $event;
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
