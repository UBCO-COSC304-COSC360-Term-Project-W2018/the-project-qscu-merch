<?php
include("../includes/init.php");

if (!isset($_SESSION['user'])) {
    //TODO send error back
    exit();
}


$validActionArray = array('setReview', 'setComment', 'updatePage');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && in_array($_POST['action'], $validActionArray) && isset($_POST['pno'])) {
        $datetime = (new DateTime('now'))->format('Y-m-d H:i:s');
//        $json = new stdClass();
//        $json->status = 'failed';
        $json['status'] = 'failed';
        $json['msg'] = 'undetermed error';
        try {
            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysql->errno) {
//                $json->msg = "Unable to connect";
                $json['msg'] = 'unable to connect';
                throw  new Exception();
            }

            $error = error_get_last();

            if (isset($_POST['userReviewInput'])) {
                $comment = sanitizeInput($_POST['userReviewInput']);

                if ($_POST['action'] == 'setComment' && isset($_POST['uid'])) {
                    $error = error_get_last();


                    $query = 'INSERT INTO Comment (uid, pNo, leftby, date, comment, isEnabled) VALUES (?, ?, ?, ?, ?, 1)';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('iiiss', $_POST['uid'], $_POST['pno'], $_SESSION['user']->id, $datetime, $comment);
                    $stmt->execute();
                    $mysql->close();

                    $json['status'] = 'success';
                    $error = error_get_last();
                }

                $error = error_get_last();
                $validRatingArray = array('1', '2', '3', '4', '5');
                if ($_POST['action'] === 'setReview' && isset($_POST['userRatingInput'])) {
                    $error = error_get_last();
                    if (in_array($_POST['userRatingInput'], $validRatingArray)) {

                        $error = error_get_last();
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
                        $mysql->close();
                    }
                }
            }
        } catch (Exception $e) {
            $error = error_get_last();
        } finally {

        }
        $error = error_get_last();
        header('Content-Type: application/json');
        $send = json_encode($json);
        $jerror = json_last_error();
        $error = error_get_last();
        echo $send;
    }
}