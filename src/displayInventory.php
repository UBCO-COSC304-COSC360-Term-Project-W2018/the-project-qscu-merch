<?php
//Ok so this will have shitty HTML in it, but it will be displaying all the products at each warehouse, kinda like the lab 7 listOrder form. Cool glad we got that out of the way...

//this will require two queries. One for the warehouse, and one fro the products at each warehouse

include "init.php";
include "header.php";
include "includes/db_credentials.php";

$user = $_SESSION["userId"];

$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($con -> connect_errno){
    die("Connection Failed: ".$con -> connect_errno);
}

$sqlProds = "SELECT pNo, size, quantity, pname FROM HasInventory, Product WHERE HasInventory.pNo = Product.pNo AND HasInventory.size = Product.size AND wNO = ?";

$sqlWH = "SELECT wNo, location FROM Warehouse";

echo "<table border=\'"1"\'><tr><th>Warehouse Number</th><th>Location</th></tr>";

if($warehouses = $con->query($sqlWH)){

	while($WH = $warehouses->fetch_assoc()){

		echo "<tr><td>".$WH['wNo']."</td>";
		echo "<td>".$WH['location']."</td>";


		echo "<tr align=\'"right"\'><td colspan=\'"4"\'><table border=\'"1"\'>";
		echo "<th>Product Id</th><th>Product Name</th> <th>Size</th> <th>Quantity</th></tr>";

		if($pstmt = msqli_prepare($con, $sqlProds)){

			mysqli_stmt_bindm($pstmt, 'i', $WH['wNo']);
			mysqli_stmt_execute($pstmt);

			mysqli_stmt_bind_result($pstmt, $pNo, $size, $quantity, $pname)

			while(mysqli_stmt_fetch($pstmt)){

				echo "<tr><td>".$pNo."</td>";
				echo "<td>".$pname."</td>";
				echo "<td>".$size."</td>";
				echo "<td>".$quantity."</td>";
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