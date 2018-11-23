<?php
include '../includes/session.php';
include '../includes/db_credentials.php';
include '../includes/inputValidation.php';
include '../includes/validateAdmin.php';

validateAdminRequest($_SESSION);

validateAdminRequest($_SESSION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputFields = array('productName', 'productPrice');

    if (!(arrayExists($_POST, $inputFields) && arrayIsValidInput($_POST, $inputFields) && isset($_POST['productDescription']))) {
        //invalid data entry
        $_SESSION['hasError'] = true;
        $_SESSION['errorType'] = "Form";
        $_SESSION['errorMsg'] = "invalid form data";
        header('location: ../newProduct.php');
        exit();
    }else{

        try {
            $productName = $_POST['productName'];
            $productPrice = $_POST['productPrice'];
            $productDescription = $_POST['productDescription'];
            $size = $null;
            if(isset($_POST['singleItem'])){
                $size = "single";
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
                        //file failed to move;
                    }

                } else {
                    //invalid file
                    $_SESSION['hasError'] = true;
                    $_SESSION['errorType'] = "upload";
                    $_SESSION['errorMsg'] = "invalid file";
                    header('location: ../newProduct.php');
                    exit();
                }
            }


            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysql->connect_error) {
                //connection failed
                die();
            }

            $query = "INSERT INTO Product (image, size, pname, price, contentType) VALUES (?, ?, ?, ?, ?)";
            $stmt = $mysql->prepare($query);

            $size = ($size === "single")? $size:"small";

            $null = null;


            $stmt->bind_param('bssds',$null, $size, $productName, $productPrice, $file['type']);
            $stmt->send_long_data(0, file_get_contents($targetFilePath));
            $stmt->execute();

            $id = $stmt->insert_id;


            if(isset($id)) {
                if($size !== "single") {
                    $size = array('medium', 'large', 'xl');
                    $query = "INSERT INTO Product (image, pNo, size, pname, price, contentType) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $mysql->prepare($query);
                    foreach ($size as $key => $value) {

                        $stmt->bind_param('bissds', $null, $id, $size[$key], $productName, $productPrice, $file['type']);
                        $stmt->send_long_data(0, file_get_contents($targetFilePath));
                        $stmt->execute();
                    }
                    unlink($targetFilePath);
                    array_push($size, "small");
                }else{
                    $size = array($size);
                }

                $query = "INSERT INTO HasInventory (wNo, pNo, size, quantity) VALUES (1, ?, ?, 0)";
                $stmt = $mysql->prepare($query);
                foreach ($size as $key2 => $value2) {
                    $stmt->bind_param('ss', $id, $size[$key2]);
                    $stmt->execute();
                }

                header("location: ../editProduct.php");
            }else{
                //failed to add item
            }
        }catch (Exception $e){


        }finally{
            $mysql->close();
            die();
        }
    }
}

?>