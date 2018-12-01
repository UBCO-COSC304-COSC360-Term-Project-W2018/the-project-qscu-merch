<?php

if (!isset($dbcred)) {
    include 'db_credentials.php';
}


class User {
    var $id;
    var $firstName;
    var $lastName;

    function __construct($userid, $userFirstName, $userLastName) {
        $this->setUser($userid, $userFirstName, $userLastName);
    }

    function setUser($userid, $userFirstName, $userLastName) {
        $this->id = $userid;
        $this->firstName = $userFirstName;
        $this->lastName = $userLastName;
    }

    function updateUser($userFirstName, $userLastName) {
        $this->firstName = $userFirstName;
        $this->lastName = $userLastName;
    }

    function getUserArray() {
        return array("userid" => $this->id, "firstName" => $this->firstName, "lastName" => $this->lastName);
    }

    function isValidUser() {
        try {
            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysql->errno) {
                throw new Exception();
            }

            $query = 'SELECT uid FROM User WHERE uid = ?';
            $stmt = $mysql->prepare($query);
            $stmt->bind_param('i',$this->id);
            $stmt->execute();
            $stmt->bind_result($UserObjectDataBaseId);
            $stmt->store_result();
            if($stmt->num_rows > 0){
             return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }

}