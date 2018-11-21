
<?php
	include "../includes/init.php";

try{

$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($con -> connect_errno){
	die("Connection Failed: ".$con -> connect_errno);
}

}
catch (Exception $e) {
	die("Error with Cart. Session Terminated.");
}
?>
<?php
					
					$sqlCats = "SELECT cname FROM Category";

					if($cats = $con->query($sqlCats)) {
						
						$list = [];
						
						while($catNames = $cats->fetch_assoc()) {
							$name = $catNames['cname'];
							array_push($list, $name);
						}
						
// 						header('Content-Type: application/json');
	//					echo json_encode($list);
						
					} else {
						echo "Category Query failed.";
						die();
					}
					

					?>	