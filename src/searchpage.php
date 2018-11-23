<?php
$headerSet = 0;
?>
<html>
<!--    Head-->

<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="css/searchpage.css"/>
    <?php include 'includes/headerFooterHead.php'?>
</head>


<!--    Body-->

<body>
<?php include "header.php"?>
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
<?php include "footer.php"; ?>
</body>
</html>

