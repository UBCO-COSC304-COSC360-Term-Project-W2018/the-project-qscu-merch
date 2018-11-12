<?php
session_start();

$cookie_hasCookie = "hasCookie";
$cookie_value = true;

if(!isset($_COOKIE)) {
    setcookie($cookie_hasCookie, $cookie_value, time() + (86400 * 30), "/"); //
}

?>