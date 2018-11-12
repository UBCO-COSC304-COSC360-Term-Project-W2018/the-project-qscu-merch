<html>
<body>
<!-- I DONT KNOW HOW TO HTML -->
<form>
  Product Number:<br> 
  <input type="Number" name="pNo"><br> 
  Product Name:<br>
  <input type="text" name="pName">

<p>Product Size(s):</p>

<div>
  <input type="checkbox" id="oneSize" name="oneSize"
         checked>
  <label for="oneSize">One Size Fits All</label>
</div>

<div>
  <input type="checkbox" id="small" name="small">
  <label for="small">Small</label>
</div>

<div>
  <input type="checkbox" id="med" name="med">
  <label for="med">Medium</label>
</div>

<div>
  <input type="checkbox" id="large" name="large">
  <label for="large">Large</label>
</div>

  Keywords:<br>
  <input type="text" name="keywords">
  Price:<br>
  <input type="Number" name="price">
  Image URL:<br>
  <input type="text" name="img">
  Content Type:<br>
  <input type="text" name="cType">

</form>

<!-- So HERE we are gonna need to build an array or something that will store what check boxes are checked for the sizes and what not, lets say we have that array though-->

<?php

//Also, I assume this Add Product thing will occur on some button press action, like "ADD PRODUCT"


$databaseName = "db_40215162"; //some database name I don't know yet
$uID = "40215162"; //admin's ID
$pw = "qscu42069!"; //admin's password
$host = "cosc.360.ok.ubc.ca"; //host of database

$con = new mysqli($host, $uID, $pw, $databaseName);

if($con -> connect_error){
	die("Connection Failed: ".$con -> connect_error);
}

//So this dummy array for the check boxes that were checked
$arrSizes = 69;

for($i = 1; $i <= sizeof($arrSizes); $i++){
	$sqlAdd = "INSERT INTO Product VALUES (".$pNo.",'".$arrSizes[$i]."', '".$pName."', '".$keywords."', ".$price.",'".$image."','".$cType."')";	

	if(mysqli_query($con, $sqlAdd)){
		echo "Product ".$pNo." added successfully to Product table.";
	}
	else{
		echo "Error: ".$sqlAdd."<br>".mysql_error($con)
	}
}

//Will also need to add product to Product in Category Table, get Categories from a query.

$sqlCategories = "SELECT DISTINCT cname FROM Category";
$cats = mysqli_query($con, $sqlCategories);

if(!empty($cats)){ //If we have elements in categories array
	
	echo "<select multiple>"
	//for each loop that will print out one of those multiple attribute things

	foreach ($cats as $c) {
		echo '<option value="'.$c.'>'.$c.'</option>';
	}
	echo "</select>"

}
else{
	echo "Error: ".$sqlCategories."<br>".mysql_error($con)
}

//Cool, so I'm going to assume that you are all able to figure out what option's of categories they chose, and once again can keep it in an array

//Dummy array for the categories that they chose: this will be filled in by YOU GUYS CAUSE I DONT HTML
$productCategories = [];

//Now we will need to make another query that link the categories they chose (cname) to the cid

for($i = 1; $i<=$productCategories; $i++){
	if($i == 1){
		$sqlGetCID = "SELECT cid FROM Category WHERE cname = '".$productCategories[i]."'";
	}
	else{
		$sqlGetCID = $sqlGetCID."OR cname = '".$productCategories[i]."'";
	}
}


$cIDs = mysqli_query($con, $sqlGetCID);

if(!empty($cIDs)){
	for($i = 1; $i <= sizeof($cIDs); $i++) {
		for($j = 1; $j <= sizeof($arrSizes); $j++){
			$sqlAdd = "INSERT INTO ProductInCategory VALUES (".$pNo.",'".$arrSizes[j]."',".$cIDs[i].")";

			if(mysqli_query($con, $sqlAdd)){
				echo "Product ".$pNo."is now part of the ".$productCategories[i];
			}
			else{
				echo "Error: ".$sqlAdd."<br>".mysql_error($con)
			}
		}
	}
}
mysqli_close($con);
?>




</body>
</html>