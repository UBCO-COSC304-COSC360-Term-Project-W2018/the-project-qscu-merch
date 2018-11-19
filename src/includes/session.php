<?php
session_start();

$cookie_hasCookie = "hasCookie";
$cookie_value = true;

if (!isset($_COOKIE)) {
    if (!isset($_COOKIE['userCart'])) {
        setcookie('userCart', new UserCart(), time() + (86400 * 30)); //
    }
}

?>