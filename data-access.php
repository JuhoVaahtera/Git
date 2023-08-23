<?php
class DataAccess {
    private $dbConnection;

    public function __construct($databaseConnection) {
        $this->dbConnection = $databaseConnection;
    }

    // Participants

    public function addParticipant(Participant $participant) {
        // Toteuta lisääminen tähän
    }

    public function getParticipants() {
        // Toteuta haku tähän
    }

    public function updateParticipant(Participant $participant) {
        // Toteuta päivitys tähän
    }

    public function deleteParticipant(Participant $participant) {
        // Toteuta poisto tähän
    }

    // Events

    public function addEvent(Event $event) {
        // Toteuta lisääminen tähän
    }

    public function getEvents() {
        // Toteuta haku tähän
    }

    public function updateEvent(Event $event) {
        // Toteuta päivitys tähän
    }

    public function deleteEvent(Event $event) {
        // Toteuta poisto tähän
    }
}

class Participant {
    private $id;

    public function getID() {
        return $this->id;
    }

    public function setID($id) {
        if ($this->id === null) {
            $this->id = $id;
        }
    }
}

class Event {
    private $id;

    public function getID() {
        return $this->id;
    }

    public function setID($id) {
        if ($this->id === null) {
            $this->id = $id;
        }
    }
}
?>
