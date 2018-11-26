<?php
include '../includes/session.php';
include '../includes/db_credentials.php';
include '../includes/inputValidation.php';
include '../includes/validateAdmin.php';


validateAdminRequest($_SESSION);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pno']) && $_POST['pno'] != "") {
    $fields = array('productName', 'productPrice', 'productDescription');

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
        if ((in_array($file['type'], $validMine) && in_array($extension, $validExt) && ($file['size'] < 100 * 1000))) {
            if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                throw new Exception();
            }

            $query = "UPDATE Product SET image = ?, contentType = ? WHERE pNo = ?";
            $stmt = $mysql->prepare($query);
            $stmt->bind_param('bsi',$null, $file['type'], $_POST['pno']);
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


    if (arrayExists($_POST, $fields) && arrayIsValidInput($_POST, $fields)) {

        $query = "UPDATE Product SET pname = ?, price = ?, description = ?, isEnabled = ? WHERE pNo = ?";
        $stmt = $mysql->prepare($query);
        $isEnabled = (isset($_POST['isEnable']))? 1:0;
        $stmt->bind_param('sdsii',$_POST['productName'],$_POST['productPrice'], $_POST['productDescription'], $isEnabled, $_POST['pno']);
        $stmt->execute();
    }
    header('location: ../editProduct.php?pno='.$_POST['pno']);

}