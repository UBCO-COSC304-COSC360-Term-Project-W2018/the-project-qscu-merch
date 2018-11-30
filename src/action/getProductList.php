<?php
include '../includes/session.php';
include '../includes/inputValidation.php';
include '../includes/db_credentials.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $validSearchType = array('productName', 'productCategory', 'productNameWithRating', "");
    $validBuildType = array('grouped', 'deepgrouped', 'individual');
    if (isset($input['searchType']) && isset($input['searchInput']) && in_array($input['searchType'], $validSearchType)) {

        $searchInput = $input['searchInput'];
        $searchType = $input['searchType'];
        $buildType = (isset($input['buildType']) && in_array($input['buildType'], $validBuildType)) ? $input['buildType'] : 'grouped';

        $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysql->errno) {
            die();
        }

        try {

            $input = '%' . $searchInput . '%';
            $stmt;

            if ($searchInput === "" && $searchType !== "productNameAndCategory" && $searchType !== "productNameWithRating") {
                $query = "SELECT pNo, size, pname, price, contentType, image, description, quantity FROM Product NATURAL JOIN HasInventory ORDER BY pNo ASC";
                $stmt = $mysql->prepare($query);
            } else {
                switch ($searchType) {
                    case "productName":

                        $query = "SELECT pNo, size, pname, price, contentType, image, description, quantity FROM Product NATURAL JOIN HasInventory WHERE pname LIKE ? ORDER BY pNo ASC";
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('s', $input);
                        break;

                    case "productNameWithRating":

                        $query = "SELECT AVG(rating) AS rating, Product.pNo, size, pname, price, contentType, image, description, quantity FROM Product NATURAL JOIN HasInventory LEFT JOIN Reviews R ON Product.pNo = R.pNo WHERE pname LIKE ? GROUP BY Product.pNo ORDER BY pNo ASC";
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('s', $input);
                        break;

                    case "productCategory":

                        $query = 'SELECT pNo, size, pname, price, contentType, image, description, quantity FROM HasInventory NATURAL JOIN Product NATURAL JOIN ProductInCategory NATURAL JOIN Category WHERE cname LIKE ? ORDER BY pNo ASC';
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('s', $input);
                        break;

                    case "productNameAndCategory":

                        $query = "SELECT Product.pNo, Product.size, pname, price, contentType, image, quantity FROM (SELECT pNo, size FROM Product WHERE pname LIKE ? UNION SELECT pNo,size FROM ProductInCategory NATURAL JOIN Category WHERE cname LiKE ?)AS cat NATURAL JOIN Product NATURAL JOIN HasInventory";
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('ss', $input, $input);
                        break;
                    default:
                        //invalid searchType
                        throw new Exception();

                }
            }

            if ($searchType == "productNameWithRating") {
                $stmt->bind_result($rating, $pno, $size, $pname, $price, $contentType, $image, $description, $quantity);
            } else {
                $stmt->bind_result($pno, $size, $pname, $price, $contentType, $image, $description, $quantity);
            }

            $stmt->execute();

            $data = [];

            switch ($buildType) {
                case "grouped":
                    $counter = -1;
                    while ($stmt->fetch()) {
                        if ($counter !== $pno) {
                            if (isset($item)) {
                                array_push($data, $item);
                            }

                            $item = [];

                            $item['productNumber'] = $pno;
                            $item['productName'] = $pname;
                            $item['productContentType'] = $contentType;
                            $item['productImage'] = base64_encode($image);

                            $item[$size] = array("productSize" => $size, "productPrice" => $price, "productQuantity" => $quantity, "productDescription" => $description);
                            $counter = $pno;

                        } else {
                            $item[$size] = array("productSize" => $size, "productPrice" => $price, "productQuantity" => $quantity);
                        }
                    }
                    if (isset($item)) {
                        array_push($data, $item);
                    }
                    header('Content-Type: application/json');
                    echo json_encode($data);
                    break;
                case "deepgrouped":
                    //deep ( -_-)
                    $counter = -1;
                    while ($stmt->fetch()) {
                        if ($counter !== $pno) {
                            if (isset($item)) {
                                array_push($data, $item);
                            }
                            $item = [];

                            $item['productNumber'] = $pno;
                            $item['productName'] = $pname;
                            $item['productContentType'] = $contentType;
                            $item['productImage'] = base64_encode($image);
                            if ($searchType == "productNameWithRating") {
                                $item['productRating'] = $rating;
                            }
                            $item['variations'] = array($size => array("productSize" => $size, "productPrice" => $price, "productQuantity" => $quantity, "productDescription" => $description));
                            $counter = $pno;

                        } else {
                            $item['variations'][$size] = array("productSize" => $size, "productPrice" => $price, "productQuantity" => $quantity);
                        }

                    }
                    if (isset($item)) {
                        array_push($data, $item);
                    }
                    header('Content-Type: application/json');
                    echo json_encode($data);
                    break;
                case "individual":
                    while ($stmt->fetch()) {
                        $item = array("productNumber" => $pno, "productName" => $pname, "productSize" => $size, "productPrice" => $price, "productContentType" => $contentType, "productImage" => base64_encode($image), "productDescription" => $description, "productQuantity" => $quantity);
                        array_push($data, $item);
                    }

                    header('Content-Type: application/json');
                    echo json_encode($data);
                    break;

                default:
                    //invalid searchType
                    throw new Exception();
            }
        } catch (Exception $e) {
            header('location: ../error404.php');
        } finally {
            $mysql->close();
            die();
        }
    } else {
        //invalid formdata
        $json = new stdClass();
        echo json_encode($json->error = isset($input['searchType']));
    }

}
