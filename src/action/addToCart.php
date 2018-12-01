<?php
include "../includes/init.php";
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user']->id;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = array("rst" => true);
    $input = json_decode(file_get_contents('php://input'), true);
    $validArray = array('pNo', 'size', 'quantity');
    if (arrayExists($input, $validArray) && arrayIsValidInput($input, $validArray)) {
        try {
            $pNo = $input["pNo"];
            $size = $input['size'];
            $quantity = $input['quantity'];

            $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($con->connect_errno) {
                die("Connection Failed: " . $con->connect_errno);
            }

            $getPriceName = "SELECT pname, price FROM Product WHERE pNo = ? AND size = ?";
            if ($pstmt1 = $con->prepare($getPriceName)) {


                $pstmt1->bind_param('is', $pNo, $size);
                $pstmt1->execute();
                $pstmt1->bind_result($name, $cost);
                while ($pstmt1->fetch()) {
                    $pname = $name;
                    $price = $cost;
                    //should only be one row
                }



                if (isset($user)) {
                    $slct = "SELECT quantity FROM HasCart WHERE pNo = ? AND size = ? AND uid = ?";
                    if ($stmt = $con->prepare($slct)) {

                        $stmt->bind_param('isi', $pNo, $size, $user);
                        $stmt->execute();
                        $stmt->store_result();
                        $numRows = $stmt->num_rows;
                        $stmt->bind_result($quant);
                        while ($stmt->fetch()) {
                            $quantityToUpdate = $quant;
                        }

                        if ($numRows == 0) {
                            $addProd = "INSERT INTO HasCart(uid, pNo, size, quantity) VALUES (?, ?, ?, ?)";

                            if ($pstmt = $con->prepare($addProd)) {

                                $pstmt->bind_param('iisi', $user, $pNo, $size, $quantity);

                                $pstmt->execute();
                                //header('location: ../singleProduct.php?pNo=' . $pNo);
                            }
                        } else {
                            $upd = "UPDATE HasCart SET quantity = ? WHERE pNo = ? AND size = ? AND uid = ?";

                            if ($updStmt = $con->prepare($upd)) {
                                $quantity += $quantityToUpdate;
                                $updStmt->bind_param('iisi', $quantity, $pNo, $size, $user);
                                $updStmt->execute();

                                //header('location: ../singleProduct.php?pNo=' . $pNo);
                            }
                        }
                    }
                } else {

                    //$_SESSION['cart']= new userCart();

                    $_SESSION['cart']->addItem($pNo, $pname, $size, $quantity, $price);


                }
            }
        } catch (Exception $e) {
            $data["rst"] = false;
        } finally {
        }
    } else {
        $data["rst"] = false;
    }
    header('Content-Type: application/json');
    echo json_encode($data["rst"]);
}
?>