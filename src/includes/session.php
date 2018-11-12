<?php
session_start();

$cookie_name = "name";
$cookie_value = "temp";

if(!isset($_COOKIE)) {
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); //
}

?>