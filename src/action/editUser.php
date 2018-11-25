<?php
include '../includes/session.php';
include '../includes/db_credentials.php';
include '../includes/inputValidation.php';
include '../includes/regex.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user'])) {
    $validArr = array('billingInfo', 'changePassword', 'userInfo', 'uploadImage');
    if (isset($_POST['action']) && in_array($_POST['action'], $validArr)) {
//        try {
            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysql->error) {
                throw new Exception();
            }

            $fieldsUserInfo = array('emailInput', 'firstNameInput', 'lastNameInput');
            $fieldsPassword = array('oldPasswordInput','passwordInput');
            $billingInformation = array('billingAddress', 'billingCity','billingProvince', 'billingPostalCode', 'cardNumber','hiddenCarNumber' , 'expiryInput', 'securityCode');
            if ($_POST['action'] === 'uploadImage' && isset($_POST['uploadImage'])) {
                $file = $_FILES['uploadImage'];
                $fileName = basename($file["name"]);
                $targetFilePath = "../uploads/" . $fileName;

                $extension = end(explode(".", $file['name']));
                $validExt = array("jpg", "png", "gif");
                $validMine = array("image/jpeg", "image/png", "image/gif");
                if ((in_array($file['type'], $validMine) && in_array($extension, $validExt) && ($file['size'] < 100 * 1000))) {
                    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                        $query = 'UPDATE User SET profilePicture = ?, contentType = ? WHERE customerBanned = 0 AND uid = ?';
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('bsi',$null, $file['type'], $_SESSION['user']->id);
                        $stmt->send_long_data(0,file_get_contents($targetFilePath));
                        $stmt->execute();

                    } else {
                        //file failed to move;
                    }
                } else {
                    //invalid file
                    $_SESSION['hasError'] = true;
                    $_SESSION['errorType'] = "upload";
                    $_SESSION['errorMsg'] = "invalid file";
                    throw new Exception();
                }


            }
            $temp = $_POST['action'] == 'userInfo';

            if ($_POST['action'] === 'userInfo' && arrayExists($_POST, $fieldsUserInfo) && arrayIsValidInput($_POST, $fieldsUserInfo) && preg_match($emailRegex ,$_POST['emailInput'])) {
                $mysql = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
                if($mysql->errno){
                    throw new Exception();
                }
                $query = 'UPDATE User SET fname = ?, lname = ?, uEmail = ? WHERE uid = ?';
                $stmt = $mysql->prepare($query);
                $stmt->bind_param('sssi', $_POST['firstNameInput'], $_POST['lastNameInput'], $_POST['emailInput'], $_SESSION['user']->id);
                $stmt->execute();

            }
            if ($_POST['action'] === 'changePassword' && arrayExists($_POST, $fieldsPassword)) {
                $query = 'SELECT uEmail, salt FROM User WHERE uid = ?';
                $stmt = $mysql->prepare($query);
                $stmt->bind_param('i',$_SESSION['user']->id);
                $stmt->execute();
                $stmt->bind_result($uEmail,$salt);
                if($stmt->fetch()){
                    $email = $uEmail;
                    $oldHashword = hash_pbkdf2("sha256", $_POST['oldPasswordInput'], $salt, 2500);
                    $hashword = hash_pbkdf2("sha256", $_POST['passwordInput'], $salt, 2500);

                    $stmt->close();

                    $query = 'UPDATE User SET password = ? WHERE uEmail = ? AND password = ? AND uid = ?';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('sssi',$hashword,$email,$oldHashword,$_SESSION['user']->id);
                    $stmt->execute();

                }
            } else if ($_POST['action'] === 'billingInfo' && arrayExists($_POST, $billingInformation) && arrayIsValidInput($_POST, $billingInformation) && preg_match($creditCardRegex ,$_POST['hiddenCarNumber']) && preg_match($htmlDateRegex, $_POST['expiryInput'])) {
                $query = 'UPDATE Use SET address = ?, city = ?, province = ?, postalCode = ?, creditCardNumber = ?, cardExpiryDate = ?, CCV = ? WHERE uid = ?';

                $cardNumber =(isset($_POST['cardNumber']) && preg_match($creditCardRegex ,$_POST['cardNumber']))? $_POST['cardNumber']:$_POST['hiddenCarNumber'];
                $stmt = $mysql->prepare($query);
                $stmt->bind_param('sssssssi',$_POST['billingAddress'], $_POST['billingCity'], $_POST['billingProvince'], $_POST['billingPostalCode'], $cardNumber, $_POST['expiryInput'], $_POST['securityCode'], $_SESSION['user']->id);
                $stmt->execute();
            }

//        } catch (Exception $e) {
//
//        } finally {
//            $mysql->close();
//        }

    }

}
header('location: ../profile.php');
