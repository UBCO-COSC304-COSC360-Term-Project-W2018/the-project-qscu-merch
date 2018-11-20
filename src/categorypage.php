<?php 
	$headerSet = 1;
include "init.php";
include "header.php";
include "db_credentials.php";

try{

$user = $_SESSION["userId"];

$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($con -> connect_errno){
	die("Connection Failed: ".$con -> connect_errno);
}

//Query for categories, then query for the individual products in the category

//Im gonna assume I know what category you are all clicking on also, that would make it easier for me

}
catch (Exception $e) {
	die("Error with Cart. Session Terminated.");
}


?>

<html>
<!--    Head-->

<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="css/categorypage.css" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="icon" type="image/x-icon" href="images/QSCU_favicon.png" />


</head>
<!--    Body-->

<body>
<main>
	<div id="main">
		<div id="browsecol">
			<nav id="browsenav">
				<h4 id="browsetitle">Categories</h4>
				<ul id="browselist">


					<!-- LIAM MAKE THIS A QUERY FOR THE CATEGORIES LIST -->
					<?php
					$sqlCats = "SELECT cname FROM Category";

					if($cats = $con->query($sqlCats)){

						while($catNames = $cats->fetch_assoc()){

							$name = '"'.$catNames['cname'].'"';

							echo "<li class='browseitem'><a href='categorypage.php' class='browselink'>$name</a></li>";
						}
					}
					else{
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
			$currCat = $_GET["cname"];

			$getCID = "SELECT cid FROM Category WHERE cname = '".$currCat."'";

			if($catID = $con->query($currCat)){

				$categoryID = $catID->fetch_assoc();

				$cID = '"'.$categoryID['cid'].'"';


				//IDK why its purple... I dont like it what if it breaks. PHP is not fun
				$sqlListProds = "SELECT pname, price, image, AVG(rating) AS score FROM Product, Reviews, ProductInCategory WHERE ProductInCategory.cid = $cID, ProductInCategory.pNo = Product.pNo, Product.pNo = Reviews.pNo";

				if($prods = $con->query($sqlListProds)){

					while($prod = $prods->fetch_assoc()){

						$image = '"'.$prod['image'].'"';
                    	$price = '"'.$prod['price'].'"';
                    	$prodName = '"'.$prod['pname'].'"';
                    	$rating = $prod['score'];

                    	$rating = '"'.round($rating).'"';

						echo "<div class='item'><div class='itempicture'><a href='singleProduct.html'><img src=$image alt='Product Picture'/></a></div><div class='iteminfo'><p class='pname'><a href='#'>$prodName</a></p><p class='itemprice'>$price</p><p class='numberofliams'>$rating</p><p class='addtocart'><button>Add to Cart <i class='fa fa-shopping-cart'></i></button></p></div></div>";

					}
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