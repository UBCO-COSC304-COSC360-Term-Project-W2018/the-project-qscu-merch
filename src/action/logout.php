<?php
include "../includes/session.php";

$cart = new userCart();
if (isset($_SESSION['user'])) {
    $_SESSION['user'] = null;
    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
    }
}
session_destroy();
session_start();

$_SESSION['cart'] = $cart;

header('location: ../homeWithoutTables.php');