<?php
include '../includes/session.php';
include '../includes/db_credentials.php';
include '../includes/inputValidation.php';
include '../includes/regex.php';


//IF THIS PAGE ISN'T WORKING FOR YOU UNCOMMENT the echo around LINE 141


function generateSalt() {
    $randString = "";
    $charUniverse = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for ($i = 0; $i < 32; $i++) {
        $randInt = rand(0, 61);
        $randChar = $charUniverse[$randInt];
        $randString = $randString . $randChar;
    }
    return $randString;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validArr = array('billingInfo', 'changePassword', 'userInfo', 'uploadImage', 'resetPassword');
    if (isset($_POST['action']) && in_array($_POST['action'], $validArr)) {

        try {
            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysql->error) {
                throw new Exception();
            }
            if ($_SESSION['user']) {
                if ($_POST['action'] === 'uploadImage' && isset($_FILES['uploadImage'])) {
                    $file = $_FILES['uploadImage'];
                    $fileName = basename($file["name"]);
                    $targetFilePath = "../uploads/" . $fileName;

                    $extension = end(explode(".", $file['name']));
                    $validExt = array("jpg", "png", "gif");
                    $validMine = array("image/jpeg", "image/png", "image/gif");
                    if ((in_array($file['type'], $validMine) && in_array($extension, $validExt) && ($file['size'] < 1000 * 1000))) {
                        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                            $query = 'UPDATE User SET profilePicture = ?, contentType = ? WHERE customerBanned = 0 AND uid = ?';
                            $stmt = $mysql->prepare($query);
                            $stmt->bind_param('bsi', $null, $file['type'], $_SESSION['user']->id);
                            $stmt->send_long_data(0, file_get_contents($targetFilePath));
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

                $fieldsUserInfo = array('emailInput', 'firstNameInput', 'lastNameInput');

                if ($_POST['action'] === 'userInfo' && arrayExists($_POST, $fieldsUserInfo) && arrayIsValidInput($_POST, $fieldsUserInfo)) {
                    $query = 'UPDATE User SET fname = ?, lname = ?, uEmail = ? WHERE uid = ?';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('sssi', $_POST['firstNameInput'], $_POST['lastNameInput'], $_POST['emailInput'], $_SESSION['user']->id);
                    $stmt->execute();
                    if ($mysql->affected_rows == 1) {
                        $_SESSION['user']->updateUser($_POST['firstNameInput'], $_POST['lastNameInput']);
                    }
                }

                $billingInformation = array('billingAddress', 'billingCity', 'billingProvince', 'billingPostalCode', 'cardNumber', 'expiryInput', 'securityCode');
                if ($_POST['action'] === 'billingInfo' && arrayExists($_POST, $billingInformation) && arrayIsValidInput($_POST, $billingInformation)) {
                    $query = 'SELECT uid FROM BillingInfo WHERE uid = ?';
                    $stmt = $mysql->prepare($query);

                    $stmt->bind_param('i', $_SESSION['user']->id);
                    $stmt->execute();
                    $stmt->bind_result($stop);

//                    if($stop->num_rows > 0){
//                        $query = 'UPDATE BillingInfo SET address = ?, city = ?, province = ?, postalCode = ?, creditCardNumber = ?, cardExpiryDate = ?, CCV = ? WHERE uid = ?';
//                        $stmt = $mysql->prepare($query);
//                        $stmt->bind_param('ssssssss', $_POST['billingAddress'], $_POST['billingCity'], $_POST['billingProvince'], $_POST['billingPostalCode'], $_POST['cardNumber'], $_POST['expiryInput'], $_POST['securityCode'], $_SESSION['user']->id);
//
//                    }
                    $stmt->store_result();
                    if ($stmt->num_rows > 0) {
                        $query = 'UPDATE BillingInfo SET address = ?, city = ?, province = ?, postalCode = ?, creditCardNumber = ?, cardExpiryDate = ?, CCV = ? WHERE uid = ?';
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('ssssssss', $_POST['billingAddress'], $_POST['billingCity'], $_POST['billingProvince'], $_POST['billingPostalCode'], $_POST['cardNumber'], $_POST['expiryInput'], $_POST['securityCode'], $_SESSION['user']->id);

                    } else {
                        $query = 'INSERT INTO BillingInfo (uid, address, city, province, postalCode, creditCardNumber, cardExpiryDate, CCV, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, "Canada")';
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('isssssss', $_SESSION['user']->id, $_POST['billingAddress'], $_POST['billingCity'], $_POST['billingProvince'], $_POST['billingPostalCode'], $_POST['cardNumber'], $_POST['expiryInput'], $_POST['securityCode']);
                    }
                    $stmt->execute();
                }
            }
            $fieldsPassword = array('oldPasswordInput');
            $resetPassword = array('uid', 'authToken');

            if ($_POST['action'] === 'changePassword' && isset($_POST['passwordInput']) || $_POST['action'] === 'resetPassword' && isset($_POST['passwordInput'])) {
                $email;
                $salt;
                $userChangePassword = false;
                if ($_POST['action'] === 'changePassword' && isset($_SESSION['user']) && isset($_POST['oldPasswordInput'])) {
                    $userChangePassword = true;

                    $query = 'SELECT uEmail, salt FROM User WHERE uid = ?';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('i', $_SESSION['user']->id);
                    $stmt->execute();
                    $stmt->bind_result($uEmail, $usalt);
                    $stmt->store_result();
                    $numRows = $stmt->num_rows;
                    $stmt->fetch();

                    $email = $uEmail;
                    $salt = $usalt;

                    $stmt->close();

                    $oldHashword = hash_pbkdf2("sha256", $_POST['oldPasswordInput'], $salt, 2500);
                }

                $newSalt = generateSalt();
                $hashword = hash_pbkdf2("sha256", $_POST['passwordInput'], $newSalt, 2500);

                if ($userChangePassword) {
                    $query = 'UPDATE User SET password = ?, salt = ? WHERE uEmail = ? AND password = ? AND uid = ?';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('ssssi', $hashword, $newSalt, $email, $oldHashword, $_SESSION['user']->id);
                    $stmt->execute();
                }

                if ($_POST['action'] == 'resetPassword' && $_POST['authToken'] != 'null' && isset($_POST['uid'])) {
                    $query = 'UPDATE User SET authToken= ?,  password = ?, salt = ? WHERE uid = ? AND authToken = ? ';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('sssis', $null, $hashword, $newSalt, $_POST['uid'], $_POST['authToken']);
                    $stmt->execute();

                }
                $mysql->close();

            }


        } catch (Exception $e) {
            $mysql->close();
        } finally {
            $mysql->close();
        }
    }
}
header('Location: ../profile.php');

