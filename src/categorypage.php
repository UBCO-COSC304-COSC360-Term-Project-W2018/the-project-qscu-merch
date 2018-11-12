<?php 
	$headerSet = 1;
include "init.php";
include "header.php";
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
					<li class="browseitem"><a href="categorypage.php" class="browselink">T-Shirts</a></li>
					<li class="browseitem"><a href="categorypage.php" class="browselink">Hoodies</a></li>
					<li class="browseitem"><a href="categorypage.php" class="browselink">Lanyards</a></li>
					<li class="browseitem"><a href="categorypage.php" class="browselink">Ping Pongs</a></li>
					<li class="browseitem"><a href="categorypage.php" class="browselink">Solo Cups</a></li>
					<li class="browseitem"><a href="categorypage.php" class="browselink">Hats</a></li>
					<li class="browseitem"><a href="categorypage.php" class="browselink">Rain Jackets</a></li>
					<li class="browseitem"><a href="categorypage.php" class="browselink">Exam Answers</a></li>
					<li class="browseitem"><a href="categorypage.php" class="browselink">Liam</a></li>		    				
				</ul>
	    	</nav>
		</div>
		
		<div id="categoryviews">
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
?>