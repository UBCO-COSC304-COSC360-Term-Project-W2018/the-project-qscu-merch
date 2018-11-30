 <?php 
include "includes/init.php";

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
    <link rel="stylesheet" href="css/categorypage.css" />
	<?php include 'includes/headerFooterHead.php';?>




</head>
<!--    Body-->

<body>


	<?php include "header.php"; ?>

<ul class="breadcrumb">
    <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
    <a >Categories</a>
</ul>

<main>
	<div id="main">
		<div id="browsecol">
			<nav id="browsenav">
				<h4 id="browsetitle">Categories</h4>
				<ul id="browselist">


					<!-- LIAM MAKE THIS A QUERY FOR THE CATEGORIES LIST -->
					<?php
					
					$sqlCats = "SELECT cname FROM Category";

					if($cats = $con->query($sqlCats)) {

						while($catNames = $cats->fetch_assoc()) {

							$name = $catNames['cname'];

							echo "<li class='browseitem'><a href='categorypage.php?cat=" . $name . "' class='browselink'>" . $name . "</a></li>";
						}
					} else {
						echo "Category Query failed.";
						die();
					}

					?>	    				
				</ul>
	    	</nav>
		</div>
		
		<div id="categoryviews">

			<?php

			//So here I will use a cat = $_GET["cname"] to determine what category I'm in
			//This might be the wrong way of getting the current category, so James do you wanna double check? Thanks
			$currCat = null;
			if (isset($_GET['cat'])){
				$currCat = $_GET['cat'];
			}

			$getCID = "SELECT cid FROM Category WHERE cname = ?";

			if($cstmt = $con->prepare($getCID)){
					
					$cstmt->bind_param('s', $currCat);
					$cstmt->execute();
					$cstmt->bind_result($cid);
					while($cstmt->fetch()){
						$catID = $cid;
	           		}
	        }
	        

				//IDK why its purple... I dont like it what if it breaks. PHP is not fun
				$sqlListProds = "SELECT Product.pNo, pname, price, image, contentType, AVG(rating) FROM Product JOIN Reviews ON Product.pNo = Reviews.pNo JOIN ProductInCategory ON ProductInCategory.pNo = Product.pNo WHERE ProductInCategory.cid = ? GROUP BY Product.pNo";
			
				
				if($prods = $con->prepare($sqlListProds)){
					
					$prods->bind_param('i', $catID);
					
					$prods->execute();
					
					$prods->bind_result($pNo, $pname, $price, $image, $contentType, $rating);
					
					while($prods->fetch()){
                    	

						echo "<div class='item'><div class='itempicture'><a href='singleProduct.php?pNo=" . $pNo . "'><img src='' alt='Product Picture'/></a></div><div class='iteminfo'><p class='pname'><a href='singleProduct.php?pNo=" . $pNo . "'>" . $pname . "</a></p><p class='itemprice'>" . $price . "</p><p class='numberofliams'>" . $rating . "</p><p class='viewCart'>";
						
						
						echo "<a href='singleProduct.php?pNo=" .$pNo . "' class='button'>View Product Page</a></p></div></div>";

					}
				}

			?>

<!--
			<div class="item">
				<div class="itempicture">
					<a href="singleProduct.html"><img src="images/pingpong.jpg" alt="Product Picture"/></a>
				</div>
				<div class="iteminfo">
					<p class="pname"><a href="#">Ping Pong Balls</a></p>
					<p class="itemprice">$200</p>
					<p class="numberofliams">
                    	<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star"></span>
                    	<span class="fa fa-star"></span>
                	</p>
                	<p class="addtocart">
	                	<button>Add to Cart <i class="fa fa-shopping-cart"></i></button>
	                </p>
				</div>
			</div>
			<div class="item">
				<div class="itempicture">
					<a href="singleProduct.html"><img src="images/pingpong.jpg" alt="Product Picture"/></a>
				</div>
				<div class="iteminfo">
					<p class="pname"><a href="#">Ping Pong Balls</a></p>
					<p class="itemprice">$200</p>
					<p class="numberofliams">
                    	<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star"></span>
                    	<span class="fa fa-star"></span>
                	</p>
                	<p class="addtocart">
	                	<button>Add to Cart <i class="fa fa-shopping-cart"></i></button>
	                </p>
				</div>
			</div>
			<div class="item">
				<div class="itempicture">
					<a href="singleProduct.html"><img src="images/pingpong.jpg" alt="Product Picture"/></a>
				</div>
				<div class="iteminfo">
					<p class="pname"><a href="#">Ping Pong Balls</a></p>
					<p class="itemprice">$200</p>
					<p class="numberofliams">
                    	<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star"></span>
                    	<span class="fa fa-star"></span>
                	</p>
                	<p class="addtocart">
	                	<button>Add to Cart <i class="fa fa-shopping-cart"></i></button>
	                </p>
				</div>
			</div>
			<div class="item">
				<div class="itempicture">
					<a href="singleProduct.html"><img src="images/pingpong.jpg" alt="Product Picture"/></a>
				</div>
				<div class="iteminfo">
					<p class="pname"><a href="#">Ping Pong Balls</a></p>
					<p class="itemprice">$200</p>
					<p class="numberofliams">
                    	<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star"></span>
                    	<span class="fa fa-star"></span>
                	</p>
                	<p class="addtocart">
	                	<button>Add to Cart <i class="fa fa-shopping-cart"></i></button>
	                </p>
				</div>
			</div>
		-->
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
</body>
</html>
<?php
include "footer.php";
$con->close();

?>