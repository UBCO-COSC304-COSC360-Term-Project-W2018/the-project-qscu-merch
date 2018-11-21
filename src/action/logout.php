<?php
include "../includes/session.php";
$_SESSION['userId'] = null;
header('location: ../homeWithoutTables.php');