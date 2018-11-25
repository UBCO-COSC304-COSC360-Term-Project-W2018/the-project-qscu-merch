
<!--//include '../includes/session.php';-->
<!--//include '../includes/db_credentials.php';-->
<!--////include '../includes/inputValidation.php';-->
<!--////include '../includes/validateAdmin.php';-->
<!--//-->
<!--////validateAdminRequest($_SESSION);-->
<!--//-->
<!--////validateAdminRequest($_SESSION);-->
<!--//-->
<!--//if ($_SERVER['REQUEST_METHOD'] == 'POST') {-->
<!--//    $inputFields = array('productName', 'productPrice');-->
<!--//-->
<!--//    if (!(arrayExists($_POST, $inputFields) && arrayIsValidInput($_POST, $inputFields) && isset($_POST['productDescription']))) {-->
<!--//        //invalid data entry-->
<!--//        $_SESSION['hasError'] = true;-->
<!--//        $_SESSION['errorType'] = "Form";-->
<!--//        $_SESSION['errorMsg'] = "invalid form data";-->
<!--//        exit();-->
<!--//    }else{-->
<!--//-->
<!--//        try {-->
<!--//            $productName = $_POST['productName'];-->
<!--//            $productPrice = $_POST['productPrice'];-->
<!--//            $productDescription = $_POST['productDescription'];-->
<!--//            $size = $_POST['size'];-->
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Ray's Grocery</title>
</head>
<body>

<h1>Search for the products you want to buy:</h1>

<form method="get" action="getSingleProduct.php">
<input type="text" name="productName" size="50">
<input type="submit" value="Submit"><input type="reset" value="Reset"> (Leave blank for all products)
</form>
<?php

include "includes/init.php";
include 'includes/db_credentials.php';

	// Get product name to search for
	$name = "";
	$hasParameter = false;
	if (isset($_GET['productName'])){
		$name = $_GET['productName'];
	}
	$sql = "";

	if ($name == "") {
	    echo print_r($name ,"test");
		echo("<h2>All Products</h2>");
		$sql = "SELECT pNo, pname, price FROM Product";
	} else {
		echo("<h2>Products containing '" . $name . "'</h2>");
		$hasParameter = true;
		$sql = "SELECT pno, pname, price FROM Product WHERE pname LIKE ?";
		$name = '%' . $name . '%';
	}

    $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	/* Try/Catch connection errors */
	if( $con === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
	$pstmt = null;
	if($hasParameter){
		$pstmt = sqlsrv_query($con, $sql, array( $name ));
	} else {
		$pstmt = sqlsrv_query($con, $sql, array());
	}

	echo("<table><tr><th></th><th>Product Name</th><th>Price</th></tr>");
	while ($rst = sqlsrv_fetch_array( $pstmt, SQLSRV_FETCH_ASSOC)) {
		echo("<tr><td><a href=\"addToCart.php?id=" . $rst['pNo'] . "&name=" . $rst['pName'] . "&price=" . $rst['price'] . "\">Add to Cart</a></td>");
		echo("<td>" . $rst['pName'] . "</td><td>" . $rst['price'] . "</td></tr>");
	}
	echo("</table>");

	sqlsrv_close($con);
?>
</body>
</html>
<!--//            if(isset($_POST['singleItem'])){-->
<!--//                $size = "single";-->
<!--//            }-->
<!---->
<!--//            if (isset($_FILES['uploadImage'])) {-->
<!--//                $file = $_FILES['uploadImage'];-->
<!--//                $fileName = basename($file["name"]);-->
<!--//                $targetFilePath = "../uploads/" . $fileName;-->
<!--//-->
<!--//                $extension = end(explode(".", $file['name']));-->
<!--//                $validExt = array("jpg", "png", "gif");-->
<!--//                $validMine = array("image/jpeg", "image/png", "image/gif");-->
<!--//                if ((in_array($file['type'], $validMine) && in_array($extension, $validExt) && ($file['size'] < 100 * 1000))) {-->
<!--//                    if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {-->
<!--//                        //file failed to move;-->
<!--//                    }-->
<!--//-->
<!--//                } else {-->
<!--//                    //invalid file-->
<!--//                    $_SESSION['hasError'] = true;-->
<!--//                    $_SESSION['errorType'] = "upload";-->
<!--//                    $_SESSION['errorMsg'] = "invalid file";-->
<!--//                    header('location: ../newProduct.php');-->
<!--//                    exit();-->
<!--//                }-->
<!--//            }-->
<!--//-->
<!--//-->
<!--//            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);-->
<!--//            if ($mysql->connect_error) {-->
<!--//                //connection failed-->
<!--//                die();-->
<!--//            }-->
<!--//-->
<!--//            $query = "INSERT INTO Product (image, size, pname, price, contentType) VALUES (?, ?, ?, ?, ?)";-->
<!--//            $stmt = $mysql->prepare($query);-->
<!--//-->
<!--//            $size = ($size === "single")? $size:"small";-->
<!--//-->
<!--//            $null = null;-->
<!--//-->
<!--//-->
<!--//            $stmt->bind_param('bssds',$null, $size, $productName, $productPrice, $file['type']);-->
<!--//            $stmt->send_long_data(0, file_get_contents($targetFilePath));-->
<!--//            $stmt->execute();-->
<!--//-->
<!--//            $id = $stmt->insert_id;-->
<!--//-->
<!--//-->
<!--//            if(isset($id)) {-->
<!--//                if($size !== "single") {-->
<!--//                    $size = array('medium', 'large', 'xl');-->
<!--//                    $query = "INSERT INTO Product (image, pNo, size, pname, price, contentType) VALUES (?, ?, ?, ?, ?, ?)";-->
<!--//                    $stmt = $mysql->prepare($query);-->
<!--//                    foreach ($size as $key => $value) {-->
<!--//-->
<!--//                        $stmt->bind_param('bissds', $null, $id, $size[$key], $productName, $productPrice, $file['type']);-->
<!--//                        $stmt->send_long_data(0, file_get_contents($targetFilePath));-->
<!--//                        $stmt->execute();-->
<!--//                    }-->
<!--//                    unlink($targetFilePath);-->
<!--//                    array_push($size, "small");-->
<!--//                }else{-->
<!--//                    $size = array($size);-->
<!--//                }-->
<!--//-->
<!--//                $query = "INSERT INTO HasInventory (wNo, pNo, size, quantity) VALUES (1, ?, ?, 0)";-->
<!--//                $stmt = $mysql->prepare($query);-->
<!--//                foreach ($size as $key2 => $value2) {-->
<!--//                    $stmt->bind_param('ss', $id, $size[$key2]);-->
<!--//                    $stmt->execute();-->
<!--//                }-->
<!--//-->
<!--//                header("location: ../editProduct.php");-->
<!--//            }else{-->
<!--//                //failed to add item-->
<!--//            }-->
<!--        }catch (Exception $e){-->
<!---->
<!---->
<!--        }finally{-->
<!--            $mysql->close();-->
<!--            die();-->
<!--        }-->
<!--    }-->
<!--}-->
<!---->
<!--?>-->