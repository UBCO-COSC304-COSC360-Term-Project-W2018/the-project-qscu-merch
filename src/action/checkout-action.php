/*
Assumptions:
-address is comma delimited
-orders are placed and shipped on the same day
-every shipment is coming from warehouse 1
*/
<?php

include '../includes/session.php';
include '../includes/db_credentials.php';

try {
    if (isset($_SESSION['fullShippingAddress']) and $_SESSION['totalCost']) {
        $fullShippingAddress = $_SESSION['fullShippingAddress'];
        $totalPrice = $_SESSION['totalCost'];

        //TODO: fix this before merging onto dev
//        $userid = 1;
        $user = $_SESSION['user'];
        $userid = $user->userid;

        $mysqli = new mysqli (DBHOST, DBUSER, DBPASS, DBNAME);

        $warehouseId = 1;

        //create shipment- a new shipment will be created for each order (:
        $createShipment = "INSERT INTO shipment(dateShipped, uid, shippedFrom) VALUES (CURRENT_DATE ,?,?)";

        if ($shipment = $mysqli -> prepare($createShipment)) {
            $shipment -> bind_param("ss",$userid, $warehouseId );
            $shipment -> execute();
            echo "<p>Shipment successfully created</p>";
        }
        else {
            throw new Exception();
        }

//        $sNo;
//        $get_sNo = "SELECT MAX(sNo) AS recent FROM Shipment";
//        if ($result = $mysqli -> query($get_sNo)) {
//
//            while ( $row = $result -> fetch_assoc() ) {
//                $sNo = $row['recent'];
//            }
//            $result -> free();
//        }
//
//        //insert into orders
//        $orderInsertSQL = "INSERT INTO Orders(shippingAddress, totalPrice, dateOrdered, uid, sNo ) VALUES (?,?,?,?,?)";
//        if ( $user_order = $mysqli -> prepare($orderInsertSQL) ) {
//            $user_order -> bind_param("sssss", $fullShippingAddress, $totalPrice, $dateShipped, $userid, $sNo);
//            $user_order -> execute();
//            echo "<p>You successfully made the order</p>";
//        }
//
//        else {
//            throw new Exception();
//        }

//        $hasOrderInsert = "INSERT INTO HasOrder(oNo, pNo, size, quantity, price) VALUES (?,?,?,?,?)";
        //oNo, gonna have to query orders table
        //pNo, in cart
        //size, in cart
        //quantity, in cart
        //price,



    }
    else {
        die();
    }
///*
// * get everything from cart
// * move info from cart and create order in orders table
// */
//
//include "includes/init.php";
//
//$_SESSION['userid'] = 1;
//
//if (!isset($_SESSION['userid'])) {
//    die();
//}
//else {
//    $userid = $_SESSION['userid'];
//}
//
//if( isset($_POST['submit'])) {
//    echo "first if";
//    if (isset($_POST['shippingAddress'])) {
//        $shippingAddress = $_POST['shippingAddress'];
//        echo $shippingAddress;
//    }
//}
//
//else {
//    echo "you encountered an error";
//}


}

catch (Exception $exception) {
    echo "<p>An exception was thrown</p>";
}
finally {
    $mysqli -> close();
}

