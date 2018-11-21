<?php

//I dont know where to include this file

include "init.php";
include "header.php";
include "db_credentials.php";

try{

$user = $_SESSION["userId"];

$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($con -> connect_errno){
	die("Connection Failed: ".$con -> connect_errno);
}


$uid = $_SESSION["userId"];

//This is where I need you guys to somehow access this information
$pNo = $_GET['pNo'];
$size = $_GET['size'];
$quantity $_GET['quantity'];

$sqlAdd = "INSERT INTO HasCart VALUES (".$uid.",".$pNo.",'".$size."',".$quantity.")";


//Does this file even need HTML output???

if($con->query($sqlAdd) === TRUE){
	echo "Product ".$pNo." added successfully to your Cart. \n";
}
else{
	echo "Error: ".$sqlAdd."<br>".mysql_error($con);
}

$con->close();
}
catch (Exception $e) {
	die("Error with Cart. Session Terminated.");
}

?>