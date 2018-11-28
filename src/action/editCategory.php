<?php
include '../includes/session.php';
include '../includes/db_credentials.php';
include '../includes/inputValidation.php';
include '../includes/validateAdmin.php';

validateAdminRequest($_SESSION);

$return = array('status' => true);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
    $input = json_decode(file_get_contents('php://input'), TRUE);
    $fieldInfo = array('pno', 'cid');
    if (in_array($input['action'], array('addCategory', 'removeCategory', 'newCategory', 'deleteCategory')) && isset($input['pno'])) {
        $mysql;

        try {


            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysql->errno) {
                throw new Exception();
            }

            if (arrayIsValidInput($input, $fieldInfo) && is_numeric($input['cid'])) {


                if ($input['action'] === 'addCategory') {

                    $query = 'INSERT INTO ProductInCategory (pNo, cid) VALUES (?,?)';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('ii', $input['pno'], $input['cid']);
                    $stmt->execute();
                }

                if ($input['action'] === 'removeCategory') {


                    $query = 'DELETE FROM ProductInCategory WHERE pNo = ? AND cid = ?';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('ii', $input['pno'], $input['cid']);
                    $stmt->execute();
                }
            }

            if ($input['action'] === 'newCategory' && isset($input['cname']) && $input['cname'] != "") {


                $query = 'INSERT INTO Category (cname) VALUES (?)';
                $stmt = $mysql->prepare($query);
                $stmt->bind_param('s', $input['cname']);
                $stmt->execute();

            }


            $protectedCategorys = [];
            //protected category array add cid to array to protect it
//        $protectedCategorys = array('7',);
            if ($input['action'] === 'deleteCategory' && !in_array($input['cid'], $protectedCategorys)) {
                $query = 'DELETE FROM ProductInCategory WHERE cid = ?';
                $stmt = $mysql->prepare($query);
                $stmt->bind_param('i', $input['cid']);
                $stmt->execute();

                $query = 'DELETE FROM Category WHERE cid = ?';
                $stmt = $mysql->prepare($query);
                $stmt->bind_param('i', $input['cid']);
                $stmt->execute();

            }

            header('Content-Type: application/json');
            echo json_encode($return);
        } catch (Exception $e) {
            invalidRequest();
        } finally {
            $mysql->close();
        }
    }

}
