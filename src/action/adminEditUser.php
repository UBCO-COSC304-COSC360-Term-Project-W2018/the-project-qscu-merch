<?php
include '../includes/init.php';
include '../includes/validateAdmin.php';

validateAdminRequest($_SESSION);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['action']) && isset($input['userid'])) {


        $mysql;
        try{



        $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysql->errno) {
            die();
        }


        if ($input['action'] === 'removeImage') {
            $return = [];
            $query = "UPDATE User SET profilePicture = ?, contentType = ? WHERE uid = ?";

            $stmt = $mysql->prepare($query);

            $targetFilePath = '../images/profile.png';
            $contentType = 'image/png';
            $fileContents = file_get_contents('../images/profile.png');
            $stmt->bind_param('bss', $null, $contentType, $input['userid']);
            $stmt->send_long_data(0, $fileContents);
            if ($rst = $stmt->execute()) {
                $return = array("userid" => $input['userid'], "contentType" => $contentType, "profilePic" => base64_encode($fileContents));
            }
            header('Content-Type: application/json');
            echo json_encode($return);
        }

        if($input['action'] === 'setBan' || $input['action'] === 'unSetBan'){
            $return = [];
            $query = "UPDATE User SET customerBanned = ?, isAdmin = 0 WHERE uid = ?";
            $stmt = $mysql->prepare($query);
            $action = ($input['action'] === 'unSetBan')? 0: 1;
            $stmt->bind_param('is', $action, $input['userid']);
            if ($rst = $stmt->execute()) {
                $return = array("userid" => $input['userid'], "isBanned" => $action);
            }
            header('Content-Type: application/json');
            echo json_encode($return);
            $stmt->close();
            exit();
        }

        if($input['action'] === 'setAdmin' || $input['action'] === 'unSetAdmin'){
            $return = [];

            $query = "UPDATE User SET isAdmin = ?, customerBanned = 0 WHERE uid = ?";
            $stmt = $mysql->prepare($query);
            $action = ($input['action'] === 'setAdmin')? 1: 0;
            $stmt->bind_param('is', $action, $input['userid']);
            if ($rst = $stmt->execute()) {
                $return = array("userid" => $input['userid'], "isAdmin" => $action);
            }
            header('Content-Type: application/json');
            echo json_encode($return);
        }
        }catch (Exception $e){
            http_response_code(404);
        }finally{
            $mysql->close();
        }

    }
}