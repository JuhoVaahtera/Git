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
    
        if ($stmt->execute()) {
            // Successfully inserted the event
            $eventId = $this->db->insert_id; // Get the ID of the newly inserted event
            
            // Insert participants into the events_participants table
            $query = "INSERT INTO events_participants (event_id, participant_id) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
    
            $participants = $event->getParticipants();
            foreach ($participants as $participant) {
                $participantId = $participant->getID();
                $stmt->bind_param('dd', $eventId, $participantId);
                $stmt->execute();
            }
            $stmt->close();
            
            return true;
        } else {
            // Error occurred during event insertion
            echo "Error adding event: " . $stmt->error;
            return false;
        }
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

    public function getParticipantById($participantId) {
        $query = "SELECT * FROM participants WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $participantId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $participant = new Participant($row['id'], $row['first_name'], $row['last_name'], $row['email'], null);
            return $participant;
        } else {
            // Participant not found
            return null;
        }
    }

    public function getEventById($eventId) {
        $query = "SELECT * FROM events WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $eventId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $event = new Event($row['title'], $row['description'], $row['address'], $row['start_time'], $row['end_time']);
            return $event;
        } else {
            // Event not found
            return null;
        }
    }

    public function getParticipantsForEvent($eventId) {
        $query = "SELECT p.* FROM participants p
                  INNER JOIN events_participants ep ON p.id = ep.participant_id
                  WHERE ep.event_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $eventId);
        $stmt->execute();
        $result = $stmt->get_result();

        $participants = [];
        while ($row = $result->fetch_assoc()) {
            $participant = new Participant($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);
            $participants[] = $participant;
        }

        return $participants;
    }

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
