<?php
require 'userCart.php';
require 'user.php';
session_start();


if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 172800) {
    $tempSessionCart = $_SESSION['cart'];
    // session started more than 3 days
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
    $_SESSION['cart'] = $tempSessionCart;
}




if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = new userCart();
}




function invalidRequest() {
    header('HTTP/1.1 404 Not Found');
    $_GET['e'] = 404;
    exit();
}
$null = null;

?>