<?php
//Ok so this will have shitty HTML in it, but it will be displaying all the products at each warehouse, kinda like the lab 7 listOrder form. Cool glad we got that out of the way...

//this will require two queries. One for the warehouse, and one fro the products at each warehouse

include "init.php";
include "header.php";

$user = $_SESSION["userId"];

$databaseName = "db_40215162"; //database name
$uID = "40215162"; //admin's ID
$pw = "qscu42069!"; //admin's password
$host = "cosc.360.ok.ubc.ca"; //host of database

$con = new mysqli($host, $uID, $pw, $databaseName);

if($con -> connect_errno){
    die("Connection Failed: ".$con -> connect_errno);
}


$sqlWH = "SELECT wNo, location FROM Warehouse";

echo "<table border=\"1\"><tr><th>Warehouse Number</th><th>Location</th></tr>";

if($warehouses = $con->query($sqlWH)){

	while($WH = $warehouses->fetch_assoc()){

		echo "<tr><td>".$WH['wNo']."</td>";
		echo "<td>".$WH['location']."</td>";

		$sqlProds = "SELECT pNo, size, quantity, pname FROM HasInventory, Product WHERE wNO = ".$WH['wNo']." AND HasInventory.pNo = Product.pNo AND HasInventory.size = Product.size";


		echo "<tr align=\"right\"><td colspan=\"4\"><table border=\"1\">";
		echo "<th>Product Id</th><th>Product Name</th> <th>Size</th> <th>Quantity</th></tr>";

		if($prodInv = $con->query($sqlProds)){

			while($prodList = $prodInv->fetch_assoc()){

				echo "<tr><td>".$prodList['pNo']."</td>";
				echo "<td>".$prodList['pname']."</td>";
				echo "<td>".$prodList['size']."</td>";
				echo "<td>".$prodList['quantity']."</td>";
				echo "</tr>";

			}

		}
		else{
			die();
		}

		echo "</table></td></tr>";

	}


}
else{
	die();
}

echo "</table>";

?>

<?php
include "footer.php";
$con->close();

?>