<?php
include '../includes/session.php';
include '../includes/inputValidation.php';
include '../includes/db_credentials.php';
include '../includes/validateAdmin.php';


//validateAdminRequest($_SESSION);

//"getPostList.php?searchInput=&searchType=;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $fieldArray = array("searchType");
    $validSearchType = array('title', 'user', 'content', "");
    if (arrayExists($_GET, $fieldArray) && isset($_GET['searchInput']) && in_array($_GET['searchType'], $validSearchType) && arrayIsValidInput($_GET, $fieldArray)) {

        $searchInput = $_GET['searchInput'];
        $searchType = $_GET['searchType'];


        $mysql;

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
                    $query = 'SELECT uid, fname, lname, uEmail, pNo, pname, rating, comment, date, isEnabled, title FROM Reviews NATURAL JOIN User NATURAL JOIN (SELECT DISTINCT (pNo), pname FROM Product) AS P ORDER BY date desc';
                    $stmt = $mysql->prepare($query);
                }

                break;
            case "title":
                $query = 'SELECT uid, fname, lname, uEmail, pNo, pname, rating, comment, date, isEnabled, title FROM (SELECT Reviews.uid, Reviews.pNo, Reviews.rating, Reviews.comment, Reviews.date, Reviews.isEnabled, Reviews.title FROM Reviews JOIN Comment ON Reviews.uid = Comment.uid AND Reviews.pNo = Comment.pNo WHERE Reviews.title LIKE ? OR Comment.title LIKE ? ) AS R NATURAL JOIN User NATURAL JOIN (SELECT DISTINCT (pNo), pname FROM Product) AS P ORDER BY date desc';
                $stmt = $mysql->prepare($query);
                $stmt->bind_param('ss',$input,$input);
                break;

            case "content":
                $query = 'SELECT uid, fname, lname, uEmail, pNo, pname, rating, comment, date, isEnabled, title FROM (SELECT Reviews.uid, Reviews.pNo, Reviews.rating, Reviews.comment, Reviews.date, Reviews.isEnabled, Reviews.title FROM Reviews JOIN Comment ON Reviews.uid = Comment.uid AND Reviews.pNo = Comment.pNo WHERE Reviews.comment LIKE ? OR Comment.comment LIKE ? ) AS R NATURAL JOIN User NATURAL JOIN (SELECT DISTINCT (pNo), pname FROM Product) AS P ORDER BY date desc';
                $stmt = $mysql->prepare($query);
                $stmt->bind_param('ss',$input,$input);
                break;

            case "user":
                $query = 'SELECT uid, fname, lname, uEmail, pNo, pname, rating, comment, date, isEnabled, title FROM (SELECT Reviews.uid, Reviews.pNo, Reviews.rating, Reviews.comment, Reviews.date, Reviews.isEnabled, Reviews.title FROM Reviews JOIN Comment ON Reviews.uid = Comment.uid AND Reviews.pNo = Comment.pNo WHERE Comment.uid = ? OR Comment.leftBy = ? ) AS R NATURAL JOIN User NATURAL JOIN (SELECT DISTINCT (pNo), pname FROM Product) AS P ORDER BY date desc';
                $stmt->bind_param('ii',$searchInput,$searchInput);
                break;
            default:
                throw new Exception();
        }

        $stmt->execute();
        $stmt->bind_result($uidR, $fnameR, $lnameR, $emailR, $pnoR, $pnameR, $ratingR, $commentR, $dateR, $isEnaledR, $titleR);
        while ($stmt->fetch()) {
            $item = array('comments' => [], 'review' => array('uid' => $uidR, 'fname' => $fnameR, 'lname' => $lnameR, 'eamil' => $emailR, 'pno' => $pnoR, 'pname' => $pnameR, 'rating' => $ratingR, 'comment' => $commentR, 'date' => $dateR, 'isEnabled' => $isEnaledR, 'title' => $titleR));
            $list[$uidR . $pnoR] = $item;
        }


        $query = 'SELECT leftBy, fname, lname, uEmail, comment, date, isEnabled, title FROM Comment JOIN User U ON Comment.leftBy = U.uid WHERE Comment.uid = ? AND Comment.pNo = ? ORDER BY date desc';
        $stmt = $mysql->prepare($query);

        foreach ($list as $key1 => $value1) {
            $stmt->bind_param('ii', $list[$key1]['review']['uid'], $list[$key1]['review']['pno']);
            $stmt->execute();
            $stmt->bind_result($leftbyC, $fnameC, $lnameC, $emailC, $commentC, $dateC, $isEnaledC, $titleC);
            while ($stmt->fetch()) {
                $item = array('leftby' => $leftbyC, 'fname' => $fnameC, 'lname' => $lnameC, 'email' => $emailC, 'comment' => $commentC, 'date' => $dateC, 'isEnabled' => $isEnaledC, 'title' => $titleC);
                array_push($list[$key1]['comments'], $item);

            }
        }


        header('Content-Type: application/json');
        echo json_encode($list);
    }

}