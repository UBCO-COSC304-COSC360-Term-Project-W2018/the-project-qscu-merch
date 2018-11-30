<?php
include '../includes/session.php';
include '../includes/inputValidation.php';
include '../includes/db_credentials.php';
include '../includes/validateAdmin.php';

//"getUserList.php?searchInput=&searchType="

validateAdminRequest($_SESSION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $validSearchType = array('userName', 'userEmail', 'uid', "");

    if (isset($input['searchType']) && in_array($input['searchType'], $validSearchType) && isset($input['searchInput'])) {
        $searchInput = $input['searchInput'];
        $searchType = $input['searchType'];
        try {


            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysql->errno) {
                die();
            }

            $input = '%' . $searchInput . '%';

            switch ($searchType) {
                case "":

                    $query = "SELECT uid, fname, lname, uEmail, contentType, profilePicture, customerBanned, isAdmin FROM User";
                    $stmt = $mysql->prepare($query);
                    break;

                case "userName":
                    $query = "SELECT uid, fname, lname, uEmail, contentType, profilePicture, customerBanned, isAdmin FROM User WHERE fname LIKE ? OR lname LIKE ?";
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('ss', $input, $input);
                    break;
                case "userEmail":
                    $query = "SELECT uid, fname, lname, uEmail, contentType, profilePicture, customerBanned, isAdmin FROM User WHERE uEmail Like ?";
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('s', $input);
                    break;

                case "uid":
                    $query = "SELECT uid, fname, lname, uEmail, contentType, profilePicture, customerBanned, isAdmin FROM User WHERE uid = ?";
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('i', $searchInput);
                    break;
                default:
                    throw new Exception;
            }


            $stmt->bind_result($uid, $firstName, $lastName, $userEmail, $contentType, $image, $isBanned, $isAdmin);
            $stmt->execute();

            $data = [];
            while ($stmt->fetch()) {
                $item = array("userid" => $uid, "firstName" => $firstName, "lastName" => $lastName, "userEmail" => $userEmail, "contentType" => $contentType, "profilePic" => base64_encode($image), "isBanned" => $isBanned, "isAdmin" => $isAdmin);
                array_push($data, $item);
            }
            header('Content-Type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {

        } finally {
            $mysql->close();
            die();
        }
    }
}