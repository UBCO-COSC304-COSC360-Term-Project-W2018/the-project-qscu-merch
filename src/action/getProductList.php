<?php
include '../includes/session.php';
include '../includes/inputValidation.php';
include '../includes/db_credentials.php';


//"getProductList.php?searchInput=&searchType=&buildType="

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $fieldArray = array("searchInput", "searchType", "buildType");
    if (arrayExists($_GET, $fieldArray) && arrayIsValidInput($_GET, $fieldArray)) {
        $searchInput = $_GET['searchInput'];
        $searchType = $_GET['searchType'];
        $buildType = $_GET['buildType'];


        $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysql->errno) {
            die();
        }


        $input = '%' . $searchInput . '%';
        $stmt;
        switch ($searchType) {
            case "productName":

                $query = "SELECT pNo, size, pname, price, contentType, image, quantity FROM Product NATURAL JOIN HasInventory WHERE pname LIKE ? ORDER BY pNo ASC";
                $stmt = $mysql->prepare($query);
                $stmt->bind_param('s', $input);
                $stmt->bind_result($pno, $size, $pname, $price, $contentType, $image, $quantity);
                break;

            case "productCategory":

                $query = "SELECT pNo, size, pname, price, contentType, image, quantity FROM HasInventory NATURAL JOIN Product NATURAL JOIN ProductInCategory WHERE cname LIKE ? ORDER BY pNo ASC";
                $stmt = $mysql->prepare($query);
                $stmt->bind_param('s', $input);
                $stmt->bind_result($pno, $size, $pname, $price, $contentType, $image, $quantity);
                break;

            case "productCategoryName":

                $query = "SELECT pNo, size, pname, price, contentType, image, quantity FROM HasInventory NATURAL JOIN Product NATURAL JOIN ProductInCategory WHERE pname LIKE ? OR cname LIKE ? ORDER BY pNo ASC";
                $stmt = $mysql->prepare($query);
                $stmt->bind_param('ss', $input, $input);
                $stmt->bind_result($pno, $size, $pname, $price, $contentType, $image, $quantity);
                break;

            default:

                //invalid searchType
                $stmt->close();
                echo "<script>alert('invalid searchType')</script>";
                die();

        }


        $stmt->execute();

        $data = [];

        switch ($buildType) {
            case "grouped":

                $counter = -1;
                while ($stmt->fetch()) {
                    if ($counter === -1) {
                        $counter = $pno;
                    }

                    if ($counter !== $pno) {
                        $item = array("productNumber" => $pno, "productName" => $pname, "productContentType" => $contentType, "productImage" => base64_encode($image));
                        array_push($item, $list);
                        array_push($data, $item);
                        $counter = $pno;
                    } else {

                        $list[$size] = array("productSize" => $size, "productPrice" => $price, "productQuantity" => $quantity);

                    }
                }


//                header('Content-Type: application/json');
//                echo json_encode($data);
                $json = json_encode($data);
                echo $json;
                $stmt->close();
                break;
            case "individual":
                while ($stmt->fetch()) {
                    $item = array("productNumber" => $pno, "productName" => $pname, "productSize" => $size, "productPrice" => $price, "productContentType" => $contentType, "productImage" => $image);
                    array_push($data, $item);
                }
                header('Content-Type: application/json');
                echo json_encode($data);
                break;
            default:
                //invalid searchType
                $stmt->close();
                echo "<script>alert('invalid buildType')</script>";
                die();
        }

    } else {
        echo "<script>alert('invalid form')</script>";
    }
}
