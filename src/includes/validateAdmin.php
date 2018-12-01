<?php
	
	
$isImportAdmin=true;
if (!isset($dbcred)) {
    include 'db_credentials.php';
}

function isAdmin($userid) {
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
        $mysql->close();
    }
}

function validationFailed() {
    header('location: error404.php');
//    header('HTTP/1.1 404 Not Found');
//    $_GET['e'] = 404;
    exit();
}

/**this checks to see if the user is admin, just call it before any code with the $_SESSION
 * will return a 404 error if the user is not an admin.
 * @param $_SESSION
 */
function validateAdminRequest($SESSION) {
    try {
        if (isset($SESSION['user'])) {
            if (!isAdmin($SESSION['user']->id)) {
                throw new Exception();
            }
        } else {
            throw new Exception();
        }
    }catch (Exception $e){
        validationFailed();
        die();
    }
}


?>