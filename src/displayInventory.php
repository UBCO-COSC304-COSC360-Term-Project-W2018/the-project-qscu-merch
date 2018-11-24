<?php

//needs admin validation



//Ok so this will have shitty HTML in it, but it will be displaying all the products at each warehouse, kinda like the lab 7 listOrder form. Cool glad we got that out of the way...

//this will require two queries. One for the warehouse, and one fro the products at each warehouse

include "includes/init.php";
include "includes/validateAdmin.php";

include "includes/headerFooterHead.php";
include "header.php";

validateAdminRequest($_SESSION);
$user = null;
$name = null;
if(isset($_SESSION['user'])){
    $user = $_SESSION['user']->id;
    $name = $_SESSION['user']->firstName;
}

$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($con -> connect_errno){
    die("Connection Failed: ".$con -> connect_errno);
}



$sqlWH = "SELECT wNo, location FROM Warehouse";

echo '<table border="1"><tr><th>Warehouse Number</th><th>Location</th></tr>';

if($warehouses = $con->query($sqlWH)){
	
	while($WH = $warehouses->fetch_assoc()){

		echo "<tr><td>".$WH['wNo']."</td>";
		echo "<td>".$WH['location']."</td></tr>";

		
		echo '<tr align="right"><td colspan="4"><table border="1">';
		echo '<th>Product Id</th><th>Product Name</th> <th>Size</th> <th>Quantity</th></tr>';
		
		$sqlProds = "SELECT pNo, size, quantity, pname FROM HasInventory, Product WHERE HasInventory.pNo = Product.pNo AND HasInventory.size = Product.size AND wNo = ?";
		if($pstmt = $con->prepare($sqlProds)){
			

			$pstmt->bind_param('i', $ware);
			$ware = $WH['wNo'];
			$pstmt->execute();

			$pstmt>bind_result($pNo, $size, $quantity, $pname);

			while($pstmt->fetch()){

				echo "<tr><td>".$pNo."</td>";
				echo "<td>".$pname."</td>";
				echo "<td>".$size."</td>";
				echo "<td>".$quantity."</td></tr>";
		}
			

		}else{
			echo "FUCK";
		}
	

		echo "</table></td></tr>";

	}


}
else{
	die();
}

echo "</table>";
$con->close();
?>

<?php
include "footer.php";


?>