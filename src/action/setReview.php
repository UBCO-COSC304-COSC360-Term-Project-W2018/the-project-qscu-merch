<?php
include("../includes/init.php");


$validActionArray = array('setReview', 'setComment', 'updatePage');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && in_array($_POST['action'], $validActionArray) && isset($_POST['pno']) && isset($_SESSION['user'])) {
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
            $rst = $stmt->get_result();

            if ($rst->num_rows !== 1) {
                $json['status'] = 'failed';
                $json['msg'] = 'User is banned and can not make reviews or comments';
                throw new Exception();
            }
            $stmt->close();

            if (isset($_POST['userReviewInput'])) {
                $comment = sanitizeInput($_POST['userReviewInput']);

                if ($_POST['action'] == 'setComment' && isset($_POST['uid'])) {

                    $query = 'INSERT INTO Comment (uid, pNo, leftby, date, comment, isEnabled) VALUES (?, ?, ?, ?, ?, 1)';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('iiiss', $_POST['uid'], $_POST['pno'], $_SESSION['user']->id, $datetime, $comment);
                    $stmt->execute();

                    $json['status'] = 'success';

                }

                $validRatingArray = array('1', '2', '3', '4', '5');
                if ($_POST['action'] === 'setReview' && isset($_POST['userRatingInput'])) {

                    if (in_array($_POST['userRatingInput'], $validRatingArray)) {

                        $rating = sanitizeInput($_POST['userRatingInput']);

                        $query = "INSERT INTO Reviews ( uid, pNo, rating, comment, date, isEnabled) VALUES (?, ?, ?, ?, ?, 1)";
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('iiiss', $_SESSION['user']->id, $_POST['pno'], $rating, $comment, $datetime);
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
            //TODO: CHECK IF THIS IS VALID
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