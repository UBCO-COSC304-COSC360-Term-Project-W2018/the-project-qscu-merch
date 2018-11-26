<?php
require 'userCart.php';
require 'user.php';
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = new userCart();
}
$null = null;

?>