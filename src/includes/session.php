<?php
require 'userCart.php';
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = new userCart();
}

?>