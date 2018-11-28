<?php
include("../includes/init.php");
if (isset($_SESSION['user'])) {
    $user = sanitizeInput($_SESSION['user']->id);
}
if (isset($_POST['userRatingInput']) && isset($_POST['userReviewInput'])) {
    $json = new stdClass();
    $json->status = "fail";
    $json->msg = "Failed to connect to the database.";
    try {

        $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

        if (!$con || $con->connect_errno) {
            die("Connection Failed: " . $con->connect_errno);
        }

        $rating = sanitizeInput($_POST['userRatingInput']);
        $review = sanitizeInput($_POST['userReviewInput']);

        $sql = "INSERT INTO Reviews( uid, pNo, size, rating, comment, date, isEnabled) VALUES (?, ?, ?, ?, ?, ?, 1)";

//        $sql = "SELECT uid, fname, lname, uEmail FROM User WHERE uEmail = ? LIMIT 1";
        if ($stmt = $con->prepare($sql)) {

            $stmt->bind_param('iis', $user, $raitng, $comment);
            $stmt->execute();
            $stmt->close();
        } else {
            $json->status = "fail";
            $json->msg = "failed to prepare statement!...";
        }

    } catch (Exception $e) {
        $json->status = "fail";
        $json->msg = "Failed to connect to the database.";
    }
    print json_encode($json);
}