<?php
include "../includes/session.php";
$_SESSION['uid'] = null;
header('location: ../homeWithoutTables.php');