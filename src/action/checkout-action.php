<?php

include '../includes/init.php';

if (isset($_SESSION['fullShippingAddress'])) {
    echo $_SESSION['fullShippingAddress'];
}
else {
    echo "<p>encountered error</p>";
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

