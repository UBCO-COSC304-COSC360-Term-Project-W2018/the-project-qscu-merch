<?php
include '../includes/init.php';
include '../includes/validateAdmin.php';

validateAdminRequest($_SESSION);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
    $input = json_decode(file_get_contents('php://input'), true);
    $validAction = array('removeImage', 'setBan', 'unSetBan', 'setAdmin', 'unSetAdmin', 'setPost', 'unsetPost');
    if (isset($input['action']) && in_array($input['action'], $validAction) && isset($input['userid'])) {


        $mysql;
        try {
            $return = null;

            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysql->errno) {
                die();
            }

            if ($input['action'] === 'removeImage') {
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
            }

            if ($input['action'] === 'setBan' || $input['action'] === 'unSetBan') {
                $query = "UPDATE User SET customerBanned = ?, isAdmin = 0 WHERE uid = ?";
                $stmt = $mysql->prepare($query);
                $action = ($input['action'] === 'unSetBan') ? 0 : 1;
                $stmt->bind_param('is', $action, $input['userid']);
                if ($rst = $stmt->execute()) {
                    $return = array("userid" => $input['userid'], "isBanned" => $action);
                }
            }

            if ($input['action'] === 'setAdmin' || $input['action'] === 'unSetAdmin') {


                $query = "UPDATE User SET isAdmin = ?, customerBanned = 0 WHERE uid = ?";
                $stmt = $mysql->prepare($query);
                $action = ($input['action'] === 'setAdmin') ? 1 : 0;
                $stmt->bind_param('is', $action, $input['userid']);
                if ($rst = $stmt->execute()) {
                    $return = array("userid" => $input['userid'], "isAdmin" => $action);
                }
            }

            if (isset($input['pno']) && $input['pno'] != "" && $input['action'] === 'setPost' || $input['action'] === 'unsetPost') {
                if (isset($input['cid']) && $input['cid'] != "") {

                    $isEnabled = ($input['action'] === 'setPost') ? 1 : 0;
                    $query = 'UPDATE Comment SET isEnabled = ? WHERE commentId = ? AND uid = ? AND pNo = ?';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('iiii', $isEnabled, $input['cid'], $input['userid'], $input['pno']);
                    $stmt->execute();
                    if ($rst = $stmt->execute()) {
                        $return = array("userid" => $input['userid'], 'cid' => $input['cid'], 'pno' => $input['pno'], 'isEnabled' => $isEnabled);
                    }

                } else {
                    $isEnabled = ($input['action'] === 'setPost') ? 1 : 0;
                    $query = 'UPDATE Reviews SET isEnabled = ? WHERE uid = ? AND pNo = ?';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('iii', $isEnabled, $input['userid'], $input['pno']);
                    $stmt->execute();
                    if ($rst = $stmt->execute()) {
                        $return = array("userid" => $input['userid'], 'pno' => $input['pno'], 'isEnabled' => $isEnabled);
                    }
                }
            }
            if ($return == null) {
                invalidRequest();
            } else {
                header('Content-Type: application/json');
                echo json_encode($return);
            }
        } catch (Exception $e) {
            invalidRequest();
        } finally {
            $mysql->close();
        }
    }
} else {
    //TODO: CHECK IF THIS IS VALID
    header('location: ../error404.php');
    die();
}