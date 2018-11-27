<?php
include "../includes/session.php";
if(isset($_SESSION['user'])){
    $_SESSION['user'] = null;
}

if (isset($_SESSION['kicked_out']) and $_SESSION['kicked_out'] === true ) {
    header('Location: http://localhost/the-project-qscu-merch/src/bannedUser.php');
    exit();
}

header('location: ../homeWithoutTables.php');