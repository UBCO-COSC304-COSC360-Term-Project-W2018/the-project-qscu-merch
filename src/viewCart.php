This file will have be the view shopping cart. Again everything will be in php, so yeah... HTML will be very basic in the php section of this, so it will need some dope ass styling by you guys. Im guessing this is gonna be fairly similar to the listOrder part of Lab 7.... cool.

Note: In sqlGetCart, customerID is something I assume we know and are able to get from the html stuff that you guys know how to do

<?php

try{

$user = $_SESSION["userId"]

$databaseName = "db_40215162"; //database name
$uID = "40215162"; //admin's ID
$pw = "qscu42069!"; //admin's password
$host = "cosc.360.ok.ubc.ca"; //host of database

$con = new mysqli($host, $uID, $pw, $databaseName);

if($con -> connect_errno){
	die("Connection Failed: ".$con -> connect_errno);
}

$sqlGetCart = "SELECT pNo, size, quantity, pname FROM HasCart, Product WHERE uid = ".$user." and HasCart.pNo = Product.pNo";


if($result = $con->query($sqlGetCart)){

	echo"<table border=\"1\"><tr><th>Product Name</th><th>Size</th><th>Quantity</th>";

	while($prod = $result->fetch_assoc()){

		echo "<tr><td>".$prod['pname']."</td>";
		echo "<td>".$prod['size']"</td>";
		echo "<td>".$prod['quantity']"</td>");
		echo "</tr>");
	}

	echo "</table>"

}
else{
	//error here with query, so we kill it
	die();

}









}
catch(Exception $e){
	die();
}


?>

