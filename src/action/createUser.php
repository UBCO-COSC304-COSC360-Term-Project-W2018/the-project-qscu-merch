<?php
include "../includes/session.php";
include "../includes/inputValidation.php";
include "../includes/db_credentials.php";

function generateSalt()
{
    $randString = "";
    $charUniverse = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for ($i = 0; $i < 32; $i++) {
        $randInt = rand(0, 61);
        $randChar = $charUniverse[$randInt];
        $randString = $randString . $randChar;
    }
    return $randString;
}

function creationFailed($input = null)
{
    $_SESSION['hasError'] = true;
    $_SESSION['errorType'] = "createUser";
    if(isset($input)){
        $_SESSION['error'] = $input;
    }else{
        $_SESSION['error'] = "Invalid username or password";
    }
    header("Location: ../login.php");
    exit();
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ((isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmPassword']))
            && (isValidInput($_POST['firstName']) && isValidInput($_POST['lastName']) && isValidInput($_POST['email']) && $_POST['password'] != "" && $_POST['confirmPassword'] != "") &&
            (strcmp($_POST['password'], $_POST['confirmPassword']) == 0)) {

            $email = strtolower(trim($_POST['email']));

//            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            $mysqli = new mysqli("localhost", "rachellegelden", "rachelle", "qscurachelle");

            if (mysqli_connect_errno()) {
                //connection failed
                die();
            } else {
                $data["email"] = $email;

                $query = 'SELECT uEmail FROM User WHERE uEmail = ?';
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $stmt->store_result();
                $data["num_rows"] = $stmt->num_rows;
                if ($stmt->num_rows == 0) {

                    $stmt->close();

                    $firstName = trim($_POST['firstName']);
                    $lastName = trim($_POST['lastName']);
                    $password = trim($_POST['password']);


                    $salt = generateSalt();
                    $hashword = hash_pbkdf2("sha256", $password, $salt, 2500);

                    $query = "INSERT INTO User (fname, lname, uEmail, password, salt, customerBanned) VALUES (?, ?, ?, ?, ?, 0);";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param('sssss', $firstName, $lastName, $email, $hashword, $salt);
                    $stmt->execute();
                    $uid = $stmt->insert_id;
					$_SESSION["fName"] = $firstName;
                    $data["uid"] = $uid;
                    $stmt->close();
                    header("Location: ../profile.php");
                    exit();
                } else {
                    //email already exists in database
                    $stmt->close();
                    creationFailed("Email already registered.");
                }
            }

        } else {
            //user has entered invalid form data, including non matching passwords
        }
    }
} catch (Exception $e) {
    header("Location: ../login.php");
    die();
}
?>