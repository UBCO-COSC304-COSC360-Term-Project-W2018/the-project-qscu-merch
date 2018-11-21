<?php
include "../includes/session.php";
include "../includes/inputValidation.php";
include "../includes/db_credentials.php";

function loginFailed($input = null)
{
    $_SESSION['hasError'] = true;
    $_SESSION['errorType'] = "login";
    if (isset($input)) {
        $_SESSION['error'] = $input;
    } else {
        $_SESSION['error'] = "Invalid username or password";
    }
    header("Location: ../login.php");
    exit();
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ((isset($_POST["email"]) && isset($_POST["password"])) && ($_POST["email"] != "" && $_POST["password"] != "")) {
            $email = strtolower(trim($_POST['email']));
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
                        $query = "SELECT uid, fname FROM User WHERE uEmail = ? AND password = ?";

                        $stmt->close();
                        $stmt = $mysqli->prepare($query);
                        $stmt->bind_param('ss', $email, $hashword);
                        $stmt->execute();
                        $stmt->bind_result($uid, $name);

                        if ($stmt->fetch()) {
                            $_SESSION['userId'] = $uid;
                            $_SESSION['fName'] = $name;
                            
                            $data['uid'] = $uid;
                            $stmt->close();
                            header("Location: ../homeWithoutTables.php");
                        } else {
                            //could not find a match of email and password in database
                            $stmt->close();
                            loginFailed();
                        }
                    } else {
                        //could not find email in database
                        $stmt->close();
                        loginFailed();

                    }
                }
            } else {
                //email is not valid
            }
        }
    }
} catch (Exception $e) {
    header("Location: ../login.php");
    die();
}
