<?php
include("../includes/init.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$validActionArray = array('setReview', 'setComment', 'updatePage');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), TRUE);

    if (isset($input['action']) && in_array($input['action'], $validActionArray) && isset($input['pno']) && isset($_SESSION['user'])) {
        $datetime = (new DateTime('now'))->format('Y-m-d H:i:s');
        $json['status'] = 'failed';
        $json['msg'] = 'undeterred error';
        try {
            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysql->errno) {
                $json['msg'] = 'unable to connect';
                throw  new Exception();
            }

            $query = 'SELECT uid FROM User WHERE uid = ? AND customerBanned = 0';
            $stmt = $mysql->prepare($query);
            $stmt->bind_param('i', $_SESSION['user']->id);
            $stmt->execute();
            $stmt -> store_result();

            if ($stmt->num_rows !== 1) {
                $json['status'] = 'failed';
                $json['msg'] = 'User is banned and can not make reviews or comments';
                throw new Exception();
            }
            $stmt->close();

            if (isset($_POST['userReviewInput'])) {
                $comment = sanitizeInput($_POST['userReviewInput']);

                if ($input['action'] == 'setComment' && isset($input['uid'])) {

                    $query = 'INSERT INTO Comment (uid, pNo, leftby, date, comment, isEnabled) VALUES (?, ?, ?, ?, ?, 1)';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('iiiss', $input['uid'], $input['pno'], $_SESSION['user']->id, $datetime, $comment);
                    $stmt->execute();

                    $json['status'] = 'success';

                }

                $validRatingArray = array('1', '2', '3', '4', '5');
                if ($input['action'] === 'setReview' && isset($input['userRatingInput'])) {

                    if (in_array($input['userRatingInput'], $validRatingArray)) {

                        $rating = sanitizeInput($_POST['userRatingInput']);

                        $query = "INSERT INTO Reviews ( uid, pNo, rating, comment, date, isEnabled) VALUES (?, ?, ?, ?, ?, 1)";
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('iiiss', $_SESSION['user']->id, $input['pno'], $rating, $comment, $datetime);
                        $stmt->execute();
                        if ($stmt->errno == 1062) {
                            $json['msg'] = "You already has a review for this product";
                            throw new Exception();
                        } else {
                            $json['status'] = 'success';
                        }
                    }
                }
            }
        } catch (Exception $e) {
            header('location: ../error404.php');
        } finally {
            $mysql->close();
        }
        header('Content-Type: application/json');
        $send = json_encode($json);
        echo $send;
    }
}else {
    header('location: ../error404.php');
    die();
}