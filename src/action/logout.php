<?php
include "../includes/session.php";
if(isset($_SESSION['user'])){
    $_SESSION['user'] = null;
}

header('location: ../homeWithoutTables.php');