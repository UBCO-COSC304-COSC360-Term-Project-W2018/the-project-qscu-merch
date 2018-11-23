<?php
include "../includes/session.php";
$_SESSION['userId'] = null;
$_SESSION['fName'] = null;
header('location: ../homeWithoutTables.php');