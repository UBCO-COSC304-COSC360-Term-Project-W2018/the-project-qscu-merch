<?php

class User{
    var $id;
    var $firstName;
    var $lastName;

    function __construct($userid, $userFirstName, $userLastName) {
        $this->setUser($userid, $userFirstName, $userLastName);
    }

    function setUser($userid, $userFirstName, $userLastName){
        $this->id = $userid;
        $this->firstName = $userFirstName;
        $this->lastName = $userLastName;
    }

    function updateUser($userFirstName, $userLastName){
        $this->firstName = $userFirstName;
        $this->lastName = $userLastName;
    }

    function getUserArray(){
        return array("userid"=>$this->id,"firstName"=>$this->firstName,"lastName"=>$this->lastName);
    }

}