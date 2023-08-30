<?php
class DataAccess {
    private $participants = [];
    private $events = [];
    private $dbConnection;

    public function __construct($databaseConnection) {
        $this->dbConnection = $databaseConnection;
    }

    // Participant operations
    public function addParticipant($participant) {
        if ($participant->getID() === null) {
            $participant->setID(count($this->participants) + 1);
            $this->participants[] = $participant;
        }
    }

    public function getParticipants() {
        return $this->participants;
    }

    public function updateParticipant($participant) {
        $index = $this->findParticipantIndex($participant);
        if ($index !== -1) {
            $this->participants[$index] = $participant;
        }
    }

    public function deleteParticipant($participant) {
        $index = $this->findParticipantIndex($participant);
        if ($index !== -1) {
            array_splice($this->participants, $index, 1);
        }
    }

    // Event operations
    public function addEvent($event) {
        if ($event->getID() === null) {
            $event->setID(count($this->events) + 1);
            $this->events[] = $event;
        }
    }

    public function getEvents() {
        return $this->events;
    }

    public function updateEvent($event) {
        $index = $this->findEventIndex($event);
        if ($index !== -1) {
            $this->events[$index] = $event;
        }
    }

    public function deleteEvent($event) {
        $index = $this->findEventIndex($event);
        if ($index !== -1) {
            array_splice($this->events, $index, 1);
        }
    }

    private function findParticipantIndex($participant) {
        $id = $participant->getID();
        foreach ($this->participants as $index => $existingParticipant) {
            if ($existingParticipant->getID() === $id) {
                return $index;
            }
        }
        return -1;
    }

    private function findEventIndex($event) {
        $id = $event->getID();
        foreach ($this->events as $index => $existingEvent) {
            if ($existingEvent->getID() === $id) {
                return $index;
            }
        }
        return -1;
    }
}

class Participant {
    private $id;
    // Other properties and methods

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
    // Other properties and methods

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
