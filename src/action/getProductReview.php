<?php
include '../includes/session.php';
include '../includes/inputValidation.php';
include '../includes/db_credentials.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $validActionArray = array('loadAll', 'loadNew');

    if (isset($input['action']) && in_array($input['action'], $validActionArray) && isset($input['pno'])) {

        $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysql->errno) {
            throw new Exception();
        }

        $datetime = (new DateTime('now'))->format('Y-m-d H:i:s');
        $return = [];
        if ($input['action'] == 'loadNew' && isset($input['date'])) {
            $return = array('com' => [], 'rev' => [], 'date' => $datetime);


            $query = 'SELECT pNo, uid, rating, comment, date, profilePicture, contentType, fname, lname FROM Reviews NATURAL JOIN User WHERE  pNo = ? AND date > ? AND isEnabled = 1 ORDER BY date desc';
            $stmt = $mysql->prepare($query);
            $stmt->bind_param('is', $input['pno'], $input['date']);
            $stmt->execute();
            $stmt->bind_result($pnoR, $uidR, $ratingR, $commentR, $dateR, $imageR, $contentTypeR, $fnameR, $lnameR);
            while ($stmt->fetch()) {
                $item = array('pno' => $pnoR, 'uid' => $uidR, 'rating' => $ratingR, 'comment' => $commentR, 'date' => $dateR, 'image' => base64_encode($imageR), '$contentType' => $contentTypeR, 'fname' => $fnameR, 'lname' => $lnameR);
                array_push($return['rev'], $item);
            }


            $query = 'SELECT Comment.uid, pNo, fname, lname, comment, date, profilePicture, contentType  FROM Comment JOIN User U ON Comment.leftBy = U.uid WHERE Comment.pNo = ? AND date > ? AND isEnabled = 1 ORDER BY date desc';
            $stmt = $mysql->prepare($query);
            $stmt->bind_param('is', $input['pno'], $input['date']);
            $stmt->execute();
            $stmt->bind_result($uidC, $pnoC, $fnameC, $lnameC, $commentC, $dateC, $imageC, $contentTypeC);
            while ($stmt->fetch()) {
                $item = array('uid' => $uidC, 'pno' => $pnoC, 'comment' => $commentC, 'fname' => $fnameC, 'lname' => $lnameC, 'date' => $dateC, 'image' => base64_encode($imageC), 'contentType' => $contentTypeC);
                array_push($return['com'], $item);
            }
        }


        if ($input['action'] == 'loadAll') {

            array_push($return, $datetime);

            $query = 'SELECT pNo, uid, rating, comment, date, profilePicture, contentType, fname, lname FROM Reviews NATURAL JOIN User WHERE  pNo = ? AND isEnabled = 1 ORDER BY date desc';
            $stmt = $mysql->prepare($query);
            $stmt->bind_param('i', $input['pno']);
            $stmt->execute();
            $stmt->bind_result($pnoR, $uidR, $ratingR, $commentR, $dateR, $imageR, $contentTypeR, $fnameR, $lnameR);
            $temp3 = [];
            while ($stmt->fetch()) {
                $item = array('posts' => [], 'pno' => $pnoR, 'uid' => $uidR, 'rating' => $ratingR, 'comment' => $commentR, 'date' => $dateR, 'image' => base64_encode($imageR), '$contentType' => $contentTypeR, 'fname' => $fnameR, 'lname' => $lnameR);
                array_push($return, $item);
            }


            $query = 'SELECT Comment.uid, pNo, fname, lname, comment, date, profilePicture, contentType  FROM Comment JOIN User U ON Comment.leftBy = U.uid WHERE Comment.uid = ? AND Comment.pNo = ? AND isEnabled = 1 ORDER BY date desc';
            $stmt = $mysql->prepare($query);

            foreach ($return as $key1 => $value1) {
                if ($key1 == 0) {
                    continue;
                }
                $stmt->bind_param('ii', $return[$key1]['uid'], $return[$key1]['pno']);
                $stmt->execute();
                $stmt->bind_result($pnoC, $uidC, $fnameC, $lnameC, $commentC, $dateC, $imageC, $contentTypeC);
                while ($stmt->fetch()) {
                    $item = array('pno' => $pnoC, 'uid' => $uidC, 'comment' => $commentC, 'fname' => $fnameC, 'lname' => $lnameC, 'date' => $dateC, 'image' => base64_encode($imageC), 'contentType' => $contentTypeC);
                    array_push($return[$key1]['posts'], $item);
                }

            }
        }
        header('Content-Type: application/json');
        $json = json_encode($return);

        echo $json;
    }
}else {
    //TODO: CHECK IF THIS IS VALID
    header('location: ../error404.php');
    die();
}
