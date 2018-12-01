<?php
include '../includes/session.php';
include '../includes/db_credentials.php';
include '../includes/inputValidation.php';
include '../includes/validateAdmin.php';


validateAdminRequest($_SESSION);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pno']) && $_POST['pno'] != "") {
    $fields = array('productName', 'productPrice', 'productDescription');
    $mysql;
    try {
        $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysql->connect_error) {
            //connection failed
            throw new Exception();
        }


        if (isset($_FILES['uploadImage'])) {


            $file = $_FILES['uploadImage'];
            $fileName = basename($file["name"]);
            $targetFilePath = "../uploads/" . $fileName;

            $extension = end(explode(".", $file['name']));
            $validExt = array("jpg", "png", "gif");
            $validMine = array("image/jpeg", "image/png", "image/gif");
            if ((in_array($file['type'], $validMine) && in_array($extension, $validExt) && ($file['size'] < 10 * 1000 * 1000))) {
                if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                    throw new Exception();
                }

                $query = "UPDATE Product SET image = ?, contentType = ? WHERE pNo = ?";
                $stmt = $mysql->prepare($query);
                $stmt->bind_param('bsi', $null, $file['type'], $_POST['pno']);
                $stmt->send_long_data(0, file_get_contents($targetFilePath));
                $stmt->execute();


            } else {
                //invalid file
                $_SESSION['hasError'] = true;
                $_SESSION['errorType'] = "upload";
                $_SESSION['errorMsg'] = "invalid file";
                throw new Exception();
            }
        }

        $_POST['productDescription'] = sanitizeInput($_POST['productDescription']);
        if (arrayExists($_POST, $fields) && arrayIsValidInput($_POST, $fields)) {

            $query = "UPDATE Product SET pname = ?, price = ?, description = ?, isEnabled = ? WHERE pNo = ?";
            $stmt = $mysql->prepare($query);
            $isEnabled = (isset($_POST['isEnable'])) ? 1 : 0;
            $stmt->bind_param('sdsii', $_POST['productName'], $_POST['productPrice'], $_POST['productDescription'], $isEnabled, $_POST['pno']);
            $stmt->execute();
        }


        if (isset($_POST['singleQty']) && $_POST['singleQty'] != "") {
            $query = 'UPDATE HasInventory Set quantity = ? WHERE pNo = ? AND size = ?';
            $stmt = $mysql->prepare($query);

            $size = 'single';
            $stmt->bind_param('iis', $_POST['singleQty'], $_POST['pno'], $size);
            $stmt->execute();

        }

        if (isset($_POST['smallQty']) && $_POST['smallQty'] != "" && isValidInput($_POST['smallQty'])) {
            $query = 'UPDATE HasInventory Set quantity = ? WHERE pNo = ? AND size = ?';
            $stmt = $mysql->prepare($query);

            $size = 'small';
            $stmt->bind_param('iis', $_POST['smallQty'], $_POST['pno'], $size);
            $stmt->execute();
        }

        if (isset($_POST['mediumQty']) && $_POST['mediumQty'] != "" && isValidInput($_POST['mediumQty'])) {
            $query = 'UPDATE HasInventory Set quantity = ? WHERE pNo = ? AND size = ?';
            $stmt = $mysql->prepare($query);

            $size = 'medium';
            $stmt->bind_param('iis', $_POST['mediumQty'], $_POST['pno'], $size);
            $stmt->execute();
        }

        if (isset($_POST['largeQty']) && $_POST['largeQty'] != "" && isValidInput($_POST['largeQty'])) {
            $query = 'UPDATE HasInventory Set quantity = ? WHERE pNo = ? AND size = ?';
            $stmt = $mysql->prepare($query);

            $size = 'large';
            $stmt->bind_param('iis', $_POST['largeQty'], $_POST['pno'], $size);
            $stmt->execute();
        }

        if (isset($_POST['xlQty']) && $_POST['xlQty'] != "" && isValidInput($_POST['xlQty'])) {
            $query = 'UPDATE HasInventory Set quantity = ? WHERE pNo = ? AND size = ?';
            $stmt = $mysql->prepare($query);

            $size = 'xl';
            $stmt->bind_param('iis', $_POST['xlQty'], $_POST['pno'], $size);
            $stmt->execute();
        }

    } catch (Exception $e) {
    } finally {
        $mysql->close();
    }

    header('location: ../editProduct.php?pno=' . $_POST['pno']);

} else {
    header('location: ../error404.php');
    die();
}