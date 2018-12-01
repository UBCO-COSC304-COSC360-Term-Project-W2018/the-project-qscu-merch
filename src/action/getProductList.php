<?php
include '../includes/session.php';
include '../includes/inputValidation.php';
include '../includes/db_credentials.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $validSearchType = array('productName', 'productCategory', 'productNameWithRating', 'productCategoryWithRating', 'productNameAndCategoryWithRating', "");
    $validBuildType = array('grouped','deepgrouped','individual');
    if(isset($input['searchType']) && isset($input['searchInput']) && in_array($input['searchType'], $validSearchType)){

        $searchInput = $input['searchInput'];
        $searchType = $input['searchType'];
        $buildType = (isset($input['buildType']) && in_array($input['buildType'], $validBuildType))? $input['buildType']: 'grouped';
        $catString = (isset($input['categorySelect']) && $input['categorySelect']!="")? $input['categorySelect']: '-1';

        try {
            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        } catch(Exception $e) {
            $json = new stdClass();
            $json->error="Error connecting to DB";
            $json->status="failed";
            echo json_encode($json);

        }
        if ($mysql->errno) {
            $json = new stdClass();
            $json->error="Error connecting to DB";
            $json->status="failed";
            echo json_encode($json);
            die();
        }

        try {

            $input = '%' . $searchInput . '%';

            if ($searchInput === "" && $searchType !== "productNameAndCategory" && $searchType !== "productNameWithRating" && $searchType !== "productCategoryWithRating" && $searchType !== "productNameAndCategoryWithRating") {
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

                        $query = "SELECT AVG(rating) AS rating, Product.pNo, size, pname, price, contentType, image, description, quantity FROM Product NATURAL JOIN HasInventory LEFT JOIN Reviews R ON Product.pNo = R.pNo WHERE pname LIKE ? GROUP BY Product.pNo ORDER BY Product.pNo ASC";
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('s', $input);
                        break;

                    case "productCategory":

                        $query = 'SELECT pNo, size, pname, price, contentType, image, description, quantity FROM HasInventory NATURAL JOIN Product NATURAL JOIN ProductInCategory NATURAL JOIN Category WHERE cname LIKE ? ORDER BY pNo ASC';
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('s', $input);
                        break;

                    case "productCategoryWithRating":

                        $query = "SELECT AVG(rating) AS rating, Product.pNo, size, pname, price, contentType, image, description, quantity FROM HasInventory NATURAL JOIN Product NATURAL JOIN ProductInCategory NATURAL JOIN Category LEFT JOIN Reviews R ON Product.pNo = R.pNo WHERE cname LIKE ? GROUP BY Product.pNo ORDER BY Product.pNo ASC";
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('s', $input);
                        break;

                    case "productNameAndCategory":

                        $query = "SELECT Product.pNo, Product.size, pname, price, contentType, image, quantity FROM (SELECT pNo, size FROM Product WHERE pname LIKE ? UNION SELECT pNo,size FROM ProductInCategory NATURAL JOIN Category WHERE cname LiKE ?)AS cat NATURAL JOIN Product NATURAL JOIN HasInventory";
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('ss', $input, $input);
                        break;

                    case "productNameAndCategoryWithRating":

                        $catinput = intval($catString);
                        $query = "SELECT AVG(rating) AS rating, Product.pNo, Product.size, pname, price, contentType, image, description, quantity FROM (SELECT pNo FROM Product WHERE pname LIKE ? AND pNo IN (SELECT pNo FROM ProductInCategory WHERE cid = ?))AS cat NATURAL JOIN Product NATURAL JOIN HasInventory LEFT JOIN (SELECT pNo, AVG(rating) AS rating FROM Reviews GROUP BY pNo) AS R ON Product.pNo = R.pNo GROUP BY Product.pNo";
                        $stmt = $mysql->prepare($query);
                        $stmt->bind_param('si', $input, $catinput);
                        break;

                    default:
                        //invalid searchType
                        throw new Exception();

                }
            }

            if ($searchType == "productNameWithRating" || $searchType == "productCategoryWithRating" || $searchType == "productNameAndCategoryWithRating") {
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
            $json = new stdClass();
            $json->error = "Oopsie something broke";
            $json->status = "failed";
            echo json_encode($json);
        } finally {
            $mysql->close();
            die();
        }
    } else {
        //invalid formdata
        $json = new stdClass();
        $json->status = "failed";
        $json->error = "Invalid Form Data";
        $json->searchType = $input['searchType'];
        $json->searchInput = $input['searchInput'];
        $json->buildType = $input['buildType'];
        $json->catString = $input['categorySelect'];
        echo json_encode($json);
    }
}
?>
