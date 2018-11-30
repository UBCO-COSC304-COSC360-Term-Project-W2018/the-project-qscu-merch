<?php
include "../includes/init.php";

function loginFailed($input = null){
    $_SESSION['hasError'] = true;
    $_SESSION['errorType'] = "login";
    if (isset($input)) {
        $_SESSION['error'] = $input;
    } else {
        $_SESSION['error'] = "Invalid username or password";
    }
    header("Location: ../login.php");
}

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if ((isset($_POST["email"]) && isset($_POST["password"])) && ($_POST["email"] != "" && $_POST["password"] != "")) {
            $email = trim($_POST['email']);
            $password = trim($_POST["password"]);


            if (isValidInput($email)) {
                $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
                if (mysqli_connect_errno()) {
                    die();
                } else {
                    $query = "SELECT salt FROM User WHERE uEmail = ?";

                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    $stmt->bind_result($salt);

                    if ($stmt->fetch()) {
                        $hashword = hash_pbkdf2("sha256", $password, $salt, 2500);

                        $stmt->close();

                        $query = "SELECT uid, fname, lname, uEmail FROM User WHERE password = ? AND uEmail = ?";
                        $stmt = $mysqli->prepare($query);
                        $stmt->bind_param('ss',$hashword, $email);
                        $stmt->execute();
                        $stmt->bind_result($uid, $firstName, $lastName, $uEmail);

                        if ($stmt->fetch()) {
                            $_SESSION['user'] = new User($uid, $firstName, $lastName);
                            header("Location: ../homeWithoutTables.php");
                        } else {
                            //could not find a match of email and password in database
                            throw new Exception();
                        }
                    } else {
                        //could not find email in database
                        throw new Exception();
                    }
                }
            } else {
                //email is not valid
            }
        }
    }
} catch (Exception $e) {
    loginFailed();
} finally {
    $mysqli->close();
    die();
}
