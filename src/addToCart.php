Here I assume that I have the variables quantity, productNumber, size, and the user ID, all to be gathered with HTML, so that's on you guys


<?php

$databaseName = "db_40215162"; //database name
$uID = "40215162"; //admin's ID
$pw = "qscu42069!"; //admin's password
$host = "cosc.360.ok.ubc.ca"; //host of database

$con = new mysqli($host, $uID, $pw, $databaseName);

if($con -> connect_error){
	die("Connection Failed: ".$con -> connect_error);
}

//HERE IS WHERE I HAVE THE DUMMY VARIABLES THAT I ASSUME THE 360 FOLK CAN GET WITH HTML STUFF

$uid = 0;
$pNo = 0;
$size = "";
$quantity = 0;

$sqlAdd = "INSERT INTO HasCart VALUES (".$uid.",".$pNo.",'".$size."',".$quantity.")";

if($con->query($sqlAdd) === TRUE){
	echo "Product ".$pNo." added successfully to your Cart.";
}
else{
	echo "Error: ".$sqlAdd."<br>".mysql_error($con)
}

$con->close();

?>