<?php
include "includes/init.php";
try {
  //    TODO this needs to be changed the query part doesnt have a trycatch

  $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

  if($con -> connect_errno){
  	die("Connection Failed: ".$con -> connect_errno);
  }
} catch (Exception $e) {
	die("Session Terminated.");
}
$headerSet = 0;
?>
<!DOCTYPE HTML>
<html>
<!--    Head-->

<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="css/searchpage.css"/>
    <?php include 'includes/headerFooterHead.php';?>
</head>


<!--    Body-->

<body>

<?php include "header.php"?>

<ul class="breadcrumb">
    <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
    <a>Search</a>
</ul>

    <!-- Main Body -->
<main>
	<div id="main">
		<div id="refinecol">
				<form id="refineform">
					<fieldset id="refinefieldset">
						<legend>Refine Results</legend>
						
						<div id="pricerange">
							<p class="refinelabel"><label>Price Range:</label></p>
							<input type="range" id="max" name="pricemax" value="1000">
							<output name="price" for="max"></output><br>
						</div>
				
						<div id="colourselect">
							<p class="refinelabel"><label id="colour">Colour:</label></p>
							<input type="checkbox" name="colour1" value="Blue"> Blue<br>
							<input type="checkbox" name="colour2" value="Red"> Red<br>
							<input type="checkbox" name="colour3" value="Green"> Green<br>
							<input type="checkbox" name="colour4" value="Orange"> Orange<br>
							<input type="checkbox" name="colour5" value="Purple"> Purple<br>
							<input type="checkbox" name="colour6" value="Red"> Grey<br>
							<input type="checkbox" name="colour7" value="Red"> Black<br>
						</div>
						<div id="colourselect">
							<p class="refinelabel"><label id="colour">Rating:</label></p>
							<input type="checkbox" name="all" value="all"> All<br>
							<input type="checkbox" name="5liams" value="5"> 5 Stars<br>
							<input type="checkbox" name="4liams" value="4"> 4 Stars<br>
							<input type="checkbox" name="3liams" value="3"> 3 Stars<br>
							<input type="checkbox" name="2liams" value="2"> 2 Stars<br>
							<input type="checkbox" name="1liam" value="1"> 1 Star<br>
							<input type="checkbox" name="unrated" value="0"> Unrated<br>
						</div>
					</fieldset>
				</form>	
		</div>
	
	<div id="categoryviews">
		<div id="sortby">
			<p id='searchResultsTitle'>Search Results</p> <!--could include what we searched for in this line. Simple Query, extra -->
		<form id="sortform">
			
			<label id="sortlabel">Sort By:</label>
			<select name="sort" id="sort">
				<option value="liamspicks">Liam's Picks</option>
				<option value="rating">Rating</option>
				<option value="lowtohigh">Price: Low to High</option>
				<option value="hightolow">Price: High to Low</option>
			</select>
		</form>
		</div>
			<?php
				if (isset($_GET['Search'])&&$_GET['Search']!=null&&!empty($_GET['Search']&&$_GET['Search']!="")) {
					$searchFor = sanitizeInput($_GET['Search']);
					$sql = "SELECT Product.pNo, pname, AVG(rating) AS rating, image, contentType, description, price FROM Product LEFT JOIN Reviews ON Product.pNo = Reviews.pNo WHERE Product.pname LIKE ? GROUP BY Product.pNo";
					$k = 0;
				} else {
					$sql = "SELECT Product.pNo, pname, AVG(rating) AS rating, image, contentType, description, price FROM Product LEFT JOIN Reviews ON Product.pNo = Reviews.pNo GROUP BY Product.pNo";
					$k = 1;
				}
				if ($stmt = $con->prepare($sql)) {
					if ($k == 0) $pname = "%".$searchFor."%";
					if ($k == 0) $stmt->bind_param('i', $pname);
					$stmt->execute();
					$stmt->bind_result($product['pNo'],$product['pname'],$product['rating'],$product['image'],$product['contentType'],$product['description'],$product['price']);
					$hasChanged = false;
					for ($i = 0; $i < 6; $i++)  {
						if ($stmt->fetch()):?>
							
							<?php $hasChanged = true;?>
							<div class="item">
								<div class="itempicture">
									<a href="singleProduct.php?pNo=<?php echo $product['pNo'];?>"><img src="data:<?php echo $product['contentType'];?>;base64,<?php echo base64_encode($product['image']);?>" alt="<?php echo $product['pname'];?> Picture"/></a>
								</div>
								<div class="iteminfo">
									<p class="pname"><a href="singleProduct.php?pNo=<?php echo $product['pNo'];?>"><?php echo $product['pname'];?></a></p>
									<p class="itemprice">$<?php echo $product['price'];?></p>
									<p class="numberofliams">
									<?php 
										for ($j = 0; j < $product['rating']; $j++) {
											echo "<span class='fa fa-star";
											if ($j < $product['rating']) echo " checked";
											echo "'></span>";
										}
									?>
									</p>
									<p class="addtocart">
										<button>Add to Cart <i class="fa fa-shopping-cart"></i></button>
									</p>
								</div>
							</div>
							
						<?php endif;
					}
					if (!$hasChanged) echo "<p>No results found for &quot;".$searchFor."&quot;. Please try searching something else.</p>";
				} else {
				  die(mysqli_error($con));
				}
			?>
		</div>
	</div>
		<div id="pagenumber">
			<p id="number">
				<a href="#">1</a>
				<a href="#">2</a>
				<a href="#">3</a>
				<a href="#">4</a>
				<a href="#">5</a>
			</p>
		</div>
</main>
<?php include "footer.php"; ?>


