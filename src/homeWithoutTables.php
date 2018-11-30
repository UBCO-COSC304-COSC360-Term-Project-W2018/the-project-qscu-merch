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
  $sqlProdsBestSell = "SELECT Product.pNo, pname, image, contentType, Product.price, description, AVG(rating) AS rating, COUNT(quantity) AS numSold FROM (Product LEFT JOIN Reviews ON Product.pNo = Reviews.pNo) LEFT JOIN HasOrder ON (Product.pNo = HasOrder.pNo AND Product.size = HasOrder.size) WHERE Product.isEnabled = 1 GROUP BY Product.pNo ORDER BY numSold DESC, rating DESC, pname ASC LIMIT 5";
  if (!($productsBestSell = $con->query($sqlProdsBestSell))) {
    die(mysqli_error($con));
  }
  $sqlProdsLiams = "SELECT Product.pNo, pname, image, contentType, Product.price, description, AVG(rating) AS rating FROM (Product LEFT JOIN Reviews ON Product.pNo = Reviews.pNo) WHERE Product.isEnabled = 1 AND Product.pNo IN (SELECT pNo FROM ProductInCategory WHERE cid = '7') GROUP BY Product.pNo ORDER BY rating DESC, pname ASC LIMIT 5";
  if (!($productsLiams = $con->query($sqlProdsLiams))) {
    die(mysqli_error($con));
  }
  $sqlProdsStaff = "SELECT Product.pNo, pname, image, contentType, Product.price, description, AVG(rating) AS rating FROM (Product LEFT JOIN Reviews ON Product.pNo = Reviews.pNo) WHERE Product.isEnabled = 1 AND Product.pNo IN (SELECT pNo FROM ProductInCategory WHERE cid = '8') GROUP BY Product.pNo ORDER BY rating DESC, pname ASC LIMIT 5";
  if (!($productsStaff = $con->query($sqlProdsStaff))) {
    die(mysqli_error($con));
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
							echo "<li class='browseitem'><a href='searchpage.php?cat=" . $cat['cname'] . "' class='browselink'>" . $cat['cname'] . "</a></li>";
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
                      echo "<a href=\"singleProduct.php?pNo=".$product['pNo']."\">";
                      echo "<img src=\"data:".$product['contentType'].";base64,".base64_encode($product['image'])."\" alt=\"".$product['pname']." Image\" />";
                      echo "</a>";
                      echo "<div class=\"itemInfo\">";
                        echo "<p class=\"itemPrice\">\$".$product['price']."</p>";
                        echo "<p class=\"numberOfLiams\">";
                        $doRating = !($product['rating']==NULL||$product['rating']=="");
                        if ($doRating) {
                          for ($i = 0; $i < 5; $i++) {
                            echo "<span class=\"fa fa-star".(($i+1)<=floatval($product['rating'])?" checked":"")."\"></span>";
                          }
                        } else {
                          echo "Not Rated";
                        }
                        echo "</p>";
                  echo "</div></div></div>";
                  if ($counter>4) break; //top 5 best selling products finished displaying
                }
                if ($counter==0) { //There were no products in this box
                  echo "<div class=\"item\">";
                    echo "<p class=\"pname\">Products not available</p><p class=\"pname\">for this category.</p>";
                  echo "</div>";
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
                foreach ($productsLiams as $product) {
                  $counter++;
                  echo "<div class=\"item\">";
                    echo "<p class=\"pname\">".$product['pname']."</p>";
                    echo "<div class=\"extraStuff\">";
                      echo "<a href=\"singleProduct.php?pNo=".$product['pNo']."\">";
                      echo "<img src=\"data:".$product['contentType'].";base64,".base64_encode($product['image'])."\" alt=\"".$product['pname']." Image\" />";
                      echo "</a>";
                      echo "<div class=\"itemInfo\">";
                        echo "<p class=\"itemPrice\">\$".$product['price']."</p>";
                        echo "<p class=\"numberOfLiams\">";
                        $doRating = !($product['rating']==NULL||$product['rating']=="");
                        if ($doRating) {
                          for ($i = 0; $i < 5; $i++) {
                            echo "<span class=\"fa fa-star".(($i+1)<=floatval($product['rating'])?" checked":"")."\"></span>";
                          }
                        } else {
                          echo "Not Rated";
                        }
                        echo "</p>";
                  echo "</div></div></div>";
                  if ($counter>4) break; //top 5 best selling products finished displaying
                }
                if ($counter==0) { //There were no products in this box
                  echo "<div class=\"item\">";
                    echo "<p class=\"pname\">Products not available</p><p class=\"pname\">for this category.</p>";
                  echo "</div>";
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
                foreach ($productsStaff as $product) {
                  $counter++;
                  echo "<div class=\"item\">";
                    echo "<p class=\"pname\">".$product['pname']."</p>";
                    echo "<div class=\"extraStuff\">";
                      echo "<a href=\"singleProduct.php?pNo=".$product['pNo']."\">";
                      echo "<img src=\"data:".$product['contentType'].";base64,".base64_encode($product['image'])."\" alt=\"".$product['pname']." Image\" />";
                      echo "</a>";
                      echo "<div class=\"itemInfo\">";
                        echo "<p class=\"itemPrice\">\$".$product['price']."</p>";
                        echo "<p class=\"numberOfLiams\">";
                        $doRating = !($product['rating']==NULL||$product['rating']=="");
                        if ($doRating) {
                          for ($i = 0; $i < 5; $i++) {
                            echo "<span class=\"fa fa-star".(($i+1)<=floatval($product['rating'])?" checked":"")."\"></span>";
                          }
                        } else {
                          echo "Not Rated";
                        }
                        echo "</p>";
                  echo "</div></div></div>";
                  if ($counter>4) break; //top 5 best selling products finished displaying
                }
                if ($counter==0) { //There were no products in this box
                  echo "<div class=\"item\">";
                    echo "<p class=\"pname\">Products not available</p><p class=\"pname\">for this category.</p>";
                  echo "</div>";
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
