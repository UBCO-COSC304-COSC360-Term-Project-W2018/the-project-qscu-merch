<?php
require 'userCart.php';
require 'user.php';
session_start();

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