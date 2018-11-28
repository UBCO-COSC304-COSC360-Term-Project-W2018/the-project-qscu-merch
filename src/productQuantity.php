<?php
$headerSet = 1;
include "includes/init.php";
include "includes/validateAdmin.php";

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
?>

<!DOCTYPE HTML>
<html>
<!--    Head-->

<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="css/home.css"/>
    <link rel="stylesheet" href="css/productQuantity.css"/>
    <?php include 'includes/headerFooterHead.php'?>
</head>

<!--    Body-->

<body>
<?php include "header.php";?>
<main>
	

<form id="productInventoryForm" method="POST" action="productQuantity.php">
	Product Number (Enter 0 to display all products): <br>
	<input id="numberInput" type="number" name="pNo">
	<input id="submitButton" type="submit" value="Submit">
</form>


<?php

//gotta check if its post, gotta check the user credentials... make sure that it's an admin page

// if $_SERVER[] === POST.. check the login page
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prodNum = $_POST['pNo'];
}

//gotta use a prepared statement
if($prodNum == 0){
	$sql = "SELECT pNo, pname, size, quantity FROM HasInventory NATURAL JOIN Product";
}else{
	$sql = "SELECT pNo, pname, size, quantity FROM HasInventory NATURAL JOIN Product WHERE pNo = ?";
}


if($pstmt = $con->prepare($sql)){
	$pstmt->bind_param('i', $prodNum);
	$pstmt->execute();
	$pstmt->bind_result($pNo, $pname, $size, $quantity);
	echo "<table class='inventoryTables'>";
	echo "<tr><th>Product Number</th><th>Product Name</th><th>Size</th> <th>Quantity</th></tr>";
	
	while($pstmt->fetch()){
		echo "<tr><td>".$pNo."</td>";
		echo "<td>".$pname."</td>";
        echo "<td>".$size."</td>";
        echo "<td>".$quantity."</td></tr>";
	}
	echo "</table>";
}
else{
    die();
}


$con->close();

?>

<?php
include "footer.php";

?>