<?php

class Participant {
    private $firstName;
    private $lastName;
    private $email;
    
    public function __construct($firstName, $lastName, $email) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
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
}
?>
