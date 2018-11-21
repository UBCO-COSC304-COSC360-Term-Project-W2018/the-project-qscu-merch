<?php
if (!isset($dbcred)) {
    include 'db_credentials.php';
}

function isAdmin($userid){


    try {
        $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysql->errno) {
            //connection error
            die();
        }
        $query = "SELECT isAdmin FROM User WHERE uid = ?";
        $stmt = $mysql->prepare($query);
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $stmt->bind_result($isAdmin);
        $stmt->fetch();
        if ($isAdmin) {
            return true;
        }
        return false;
    } catch (Exception $e) {
        return false;
    } finally {
        $stmt->close();
    }
}

function validationFailed(){
    header('HTTP/1.1 404 Not Found');
    $_GET['e'] = 404;
    exit();
}

function validateAdminRequest($SESSION){
    if (isset($SESSION['userid'])) {
        if (!isAdmin($SESSION['userid'])) {
            validationFailed();
        }
    } else {
        validationFailed();
    }
}


?>