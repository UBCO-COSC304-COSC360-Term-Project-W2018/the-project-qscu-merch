<?php
include '../includes/session.php';
include '../includes/inputValidation.php';
include '../includes/db_credentials.php';
include '../includes/validateAdmin.php';


validateAdminRequest($_SESSION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validSearchType = array('title', 'user', 'content', "");
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['searchType']) && in_array($input['searchType'], $validSearchType) && isset($input['searchInput'])) {

        $searchInput = sanitizeInput($input['searchInput']);
        $searchType = $input['searchType'];


        $mysql;

        try {
            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysql->errno) {
                throw new Exception();
            }

            $list = [];
            $stmt;
            $input = '%' . $searchInput . '%';

            switch ($searchType) {
                case "":
                    if ($searchInput === "") {
                        $query = 'SELECT uid, fname, lname, uEmail, pNo, pname, rating, comment, date, isEnabled FROM Reviews NATURAL JOIN User NATURAL JOIN (SELECT DISTINCT (pNo), pname FROM Product) AS P ORDER BY date desc';
                        $stmt = $mysql->prepare($query);
                    }

                    break;

                case "content":
                    $query = 'SELECT uid, fname, lname, uEmail, pNo, pname, rating, comment, date, isEnabled FROM (SELECT Reviews.uid, Reviews.pNo, Reviews.rating, Reviews.comment, Reviews.date, Reviews.isEnabled FROM Reviews JOIN Comment ON Reviews.uid = Comment.uid AND Reviews.pNo = Comment.pNo WHERE Reviews.comment LIKE ? OR Comment.comment LIKE ? ) AS R NATURAL JOIN User NATURAL JOIN (SELECT DISTINCT (pNo), pname FROM Product) AS P GROUP BY uid, pNo ORDER BY date desc';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('ss', $input, $input);
                    break;

                case "user":
                    $query = 'SELECT uid, fname, lname, uEmail, pNo, pname, rating, comment, date, isEnabled FROM (SELECT Reviews.uid, Reviews.pNo, Reviews.rating, Reviews.comment, Reviews.date, Reviews.isEnabled FROM Reviews JOIN Comment ON Reviews.uid = Comment.uid AND Reviews.pNo = Comment.pNo WHERE Comment.uid = ? OR Comment.leftBy = ? ) AS R NATURAL JOIN User NATURAL JOIN (SELECT DISTINCT (pNo), pname FROM Product) AS P GROUP BY uid, pNo ORDER BY date desc';
                    $stmt = $mysql->prepare($query);
                    $stmt->bind_param('ii', $searchInput, $searchInput);
                    break;
                default:
                    throw new Exception();
            }

            $stmt->execute();
            $stmt->bind_result($uidR, $fnameR, $lnameR, $emailR, $pnoR, $pnameR, $ratingR, $commentR, $dateR, $isEnaledR);
            while ($stmt->fetch()) {
                $item = array('comments' => [], 'review' => array('uid' => $uidR, 'fname' => $fnameR, 'lname' => $lnameR, 'email' => $emailR, 'pno' => $pnoR, 'pname' => $pnameR, 'rating' => $ratingR, 'comment' => $commentR, 'date' => $dateR, 'isEnabled' => $isEnaledR));
                array_push($list, $item);
            }

            $query = 'SELECT commentId, leftBy, fname, lname, uEmail, comment, date, isEnabled FROM Comment JOIN User U ON Comment.leftBy = U.uid WHERE Comment.uid = ? AND Comment.pNo = ? ORDER BY date desc';
            $stmt = $mysql->prepare($query);

            foreach ($list as $key1 => $value1) {
                $stmt->bind_param('ii', $list[$key1]['review']['uid'], $list[$key1]['review']['pno']);
                $stmt->execute();
                $stmt->bind_result($commentIdC, $leftbyC, $fnameC, $lnameC, $emailC, $commentC, $dateC, $isEnaledC);
                while ($stmt->fetch()) {
                    $item = array('pno' => $list[$key1]['review']['pno'], 'uid' => $list[$key1]['review']['uid'], 'commentId' => $commentIdC, 'leftby' => $leftbyC, 'fname' => $fnameC, 'lname' => $lnameC, 'email' => $emailC, 'comment' => $commentC, 'date' => $dateC, 'isEnabled' => $isEnaledC);
                    array_push($list[$key1]['comments'], $item);

                }
            }
            header('Content-Type: application/json');
            echo json_encode($list);

        } catch (Exception $e) {
            //TODO: CHECK IF THIS IS VALID
                header('location: ../error404.php');
        } finally {
            $mysql->close();
        }
    }

}