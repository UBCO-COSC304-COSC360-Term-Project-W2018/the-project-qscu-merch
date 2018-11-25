 <?php

$headerSet = 1;
include "includes/init.php";

if(isset($_SESSION['user'])) {
    $user = $_SESSION['user']->id;
    $name = $_SESSION['user']->firstName;
}

try {
  //    TODO this needs to be changed the query part doesnt have a trycatch

  $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

  if($con -> connect_errno){
  	die("Connection Failed: ".$con -> connect_errno);
  }
} catch (Exception $e) {
	die("Session Terminated.");
}
try {
	$sqlCats = "SELECT cname FROM Category";
  if(!($cats = $con->query($sqlCats))) {
		die("Category Query failed.");
	}
  $sqlProdsBestSell = "SELECT Product.pNo, pname, image, contentType, Product.price, description, AVG(rating) AS rating, COUNT(quantity) AS numSold FROM (Product LEFT JOIN Reviews ON (Product.pNo = Reviews.pNo AND Product.size = Reviews.size)) LEFT JOIN HasOrder ON (Product.pNo = HasOrder.pNo AND Product.size = HasOrder.size) GROUP BY Product.pNo ORDER BY numSold DESC, rating DESC, pname ASC";
  if (!($productsBestSell = $con->query($sqlProdsBestSell))) {
    die("Product Query Failed.");
  }
  
} catch(Exception $ex) {
	echo "Try failed";
}
?>

<!DOCTYPE HTML>
<html>
<!--    Head-->

<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="css/home.css"/>
    <?php include 'includes/headerFooterHead.php'?>
</head>


<!--    Body-->

<body>
<?php include "header.php";?>
<main>
	<div id="main">
		<div id="browsecol">
			<nav id="browsenav">
				<h4 id="browsetitle">Categories</h4>
				<ul id="browselist">
					<?php
						foreach($cats as $cat) {
							echo "<li class='browseitem'><a href='categorypage.php?cat=" . $cat['cname'] . "' class='browselink'>" . $cat['cname'] . "</a></li>";
						}
					?>
				</ul>
	    	</nav>
		</div>
	<div id="productviews">
        <div id="topselling" class="products">
	        <div class="viewnamediv">
            <p class="viewname">Top Selling Products</p></div>
            <div class="productlist">
              <?php
                $counter = 0;
                foreach ($productsBestSell as $product) {
                  $counter++;
                  echo "<div class=\"item\">";
                    echo "<p class=\"pname\">".$product['pname']."</p>";
                    echo "<div class=\"extraStuff\">";
                      echo "<a href=\"singleProduct.php\">";
                      echo "<img src=\"data:".$product['contentType'].";base64,".base64_encode($product['image'])."\" alt=\"".$product['pname']." Image\" />";
                      echo "</a>";
                      echo "<div class=\"itemInfo\">";
                        echo "<p class=\"itemPrice\">\$".$product['price']."</p>";
                        echo "<p class=\"numberOfLiams\">Rated ".($product['rating']==NULL||$product['rating']==""?"0":$product['rating'])." / 5</p>";
                  echo "</div></div></div>";
                  if ($counter>4) break; //top 5 best selling products finished displaying
                }
              ?>
            </div>
        </div>
		<div id="liamspicks" class="products">
			<div class="viewnamediv">
            <p class="viewname">Liam's Picks</p></div>
            <div class="productlist">
              <?php
                $counter = 0;
                foreach ($productsBestSell as $product) {
                  $counter++;
                  echo "<div class=\"item\">";
                    echo "<p class=\"pname\">".$product['pname']."</p>";
                    echo "<div class=\"extraStuff\">";
                      echo "<a href=\"singleProduct.php\">";
                      echo "<img src=\"data:".$product['contentType'].";base64,".base64_encode($product['image'])."\" alt=\"".$product['pname']." Image\" />";
                      echo "</a>";
                      echo "<div class=\"itemInfo\">";
                        echo "<p class=\"itemPrice\">\$".$product['price']."</p>";
                        echo "<p class=\"numberOfLiams\">Rated ".($product['rating']==NULL||$product['rating']==""?"0":$product['rating'])." / 5</p>";
                  echo "</div></div></div>";
                  if ($counter>4) break; //top 5 best selling products finished displaying
                }
              ?>
            </div>
        </div>
        <div id="staffpicks" class="products">
	        <div class="viewnamediv">
            <p class="viewname">Staff Picks</p></div>
            <div class="productlist">
              <?php
                $counter = 0;
                foreach ($productsBestSell as $product) {
                  $counter++;
                  echo "<div class=\"item\">";
                    echo "<p class=\"pname\">".$product['pname']."</p>";
                    echo "<div class=\"extraStuff\">";
                      echo "<a href=\"singleProduct.php\">";
                      echo "<img src=\"data:".$product['contentType'].";base64,".base64_encode($product['image'])."\" alt=\"".$product['pname']." Image\" />";
                      echo "</a>";
                      echo "<div class=\"itemInfo\">";
                        echo "<p class=\"itemPrice\">\$".$product['price']."</p>";
                        echo "<p class=\"numberOfLiams\">Rated ".($product['rating']==NULL||$product['rating']==""?"0":$product['rating'])." / 5</p>";
                  echo "</div></div></div>";
                  if ($counter>4) break; //top 5 best selling products finished displaying
                }
              ?>
            </div>
        </div>
        <div id="onsale" class="products">
	        <div class="viewnamediv">
            <p class="viewname">On Sale</p></div>
            <div class="productlist">
              <?php
                $counter = 0;
                foreach ($productsBestSell as $product) {
                  $counter++;
                  echo "<div class=\"item\">";
                    echo "<p class=\"pname\">".$product['pname']."</p>";
                    echo "<div class=\"extraStuff\">";
                      echo "<a href=\"singleProduct.php\">";
                      echo "<img src=\"data:".$product['contentType'].";base64,".base64_encode($product['image'])."\" alt=\"".$product['pname']." Image\" />";
                      echo "</a>";
                      echo "<div class=\"itemInfo\">";
                        echo "<p class=\"itemPrice\">\$".$product['price']."</p>";
                        echo "<p class=\"numberOfLiams\">Rated ".($product['rating']==NULL||$product['rating']==""?"0":$product['rating'])." / 5</p>";
                  echo "</div></div></div>";
                  if ($counter>4) break; //top 5 best selling products finished displaying
                }
              ?>
            </div>
        </div>
	</div>
</div>
</main>
<?php include "footer.php"; ?>
</body>
</html>
