<?php
include "init.php";
include "header.php";

<<<<<<< HEAD
$user = $_SESSION["userId"];

$databaseName = "db_40215162"; //database name
$uID = "40215162"; //admin's ID
$pw = "qscu42069!"; //admin's password
$host = "cosc.360.ok.ubc.ca"; //host of database

$con = new mysqli($host, $uID, $pw, $databaseName);

if($con -> connect_errno){
    die("Connection Failed: ".$con -> connect_errno);
}
=======
?>
>>>>>>> 896314a680f4c4bffb5aa42a965e876c04c66643


<form>
	First name:<br>
	<input type="number" name="prodNum"><br>
	<input type="submit" value="Submit"><br>
</form>


<?php

//gotta check if its post, gotta check the user credentials... make sure that it's an admin page

// if $_SERVER[] === POST.. check the login page

$prodNum = $_POST['prodNum']; //make sure this is set and non-empty

include "includes/db_credentials.php";

$user = $_SESSION["userId"];

$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($con -> connect_errno){
    die("Connection Failed: ".$con -> connect_errno);
}

//gotta use a prepared statement

$sql = "SELECT pname, size, quantity, wNo FROM HasInventory, Product WHERE HasInventory.".$prodNum." = Product.".$prodNum." AND HasInventory.size";

if($result = mysqli_query($con, $sql)){
    echo '<table border="1"><tr><th>Product Number</th></tr>';
	echo "<tr><td>".$prodNum."</td>";

	echo '<tr align="right"><td colspan="4"><table border="1">';
	echo "<th>Product Name</th><th>Size</th> <th>Quantity</th> <th>Warehouse Number</th></tr>";
	while($row = mysqli_fetch_assoc($result)){


        echo "<tr><td>".$row['pname']."</td>";
        echo "<tr><td>".$row['size']."</td>";
        echo "<tr><td>".$row['quantity']."</td>";
        echo "<tr><td>".$row['wNo']."</td>";

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
$con->close();

?>