<?php
include '../includes/init.php';
include '../includes/validateAdmin.php';

validateAdminRequest($_SESSION);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
    $input = json_decode(file_get_contents('php://input'));
    if ($input['action'] && $input['uid']) {

        $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysql->errno) {
            die();
        }


        if ($input['action'] === 'removeImage') {
            $return = [];
            $query = "UPDATE User SET profilePicture = ?, contentType = ? WHERE uid = ?";

            $stmt = $mysql->prepare($query);
            $null = null;

            $targetFilePath = '../images/profile.png';
            $contentType = 'image/png';
            $fileContents = file_get_contents('../images/profile.png');
            $stmt->bind_param('bss', $null, $contentType, $input['uid']);
            $stmt->send_long_data(0, $fileContents);
            if ($rst = $stmt->execute()) {
                $return = array("userid" => $uid, "contentType" => $contentType, "profilePic" => base64_encode($fileContents));
            }
            header('Content-Type: application/json');
            echo json_encode($return);
            exit();
        }

        if($input['action'] === 'setBan' || $input['action'] === 'unsetBan'){
            $return = [];
            $query = "UPDATE User SET customerBanned = ? WHERE uid = ?";
            $stmt = $mysql->prepare($query);
            $action = ($input['action'] === 'unsetBan')? 0: 1;
            $stmt->bind_param('is', $action, $input['uid']);
            if ($rst = $stmt->execute()) {
                $return = array("userid" => $uid, "isBanned" => $action);
            }
            header('Content-Type: application/json');
            echo json_encode($return);
            exit();
        }

        if($input['action'] === 'setAdmin' || $input['action'] === 'unsetAdmin'){
            $return = [];

            $query = "UPDATE User SET isAdmin = ? WHERE uid = ?";
            $stmt = $mysql->prepare($query);
            $action = ($input['action'] === 'setAdmin')? 1: 0;
            $stmt->bind_param('is', $action, $input['uid']);
            if ($rst = $stmt->execute()) {
                $return = array("userid" => $uid, "isAdmin" => $action);
            }
            header('Content-Type: application/json');
            echo json_encode($return);
            exit();
        }


    }
}