 <?php 

$headerSet = 1;
include "includes/init.php";

//include "includes/db_credentials.php";

try{

//    TODO this needs to be changed the query part doesnt have a trycatch
$user = isset($_SESSION["userId"])? $_SESSION['userId']: null;

$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($con -> connect_errno){
	die("Connection Failed: ".$con -> connect_errno);
}

}
catch (Exception $e) {
	die("Session Terminated.");
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
	<div id="productviews">
        <div id="topselling" class="products">
	        <div class="viewnamediv">
            <p class="viewname">Top Selling Products</p></div>
            <div class="productlist">
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div id="liamspicks" class="products">
			<div class="viewnamediv">
            <p class="viewname">Liam's Picks</p></div>
            <div class="productlist">
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="staffpicks" class="products">
	        <div class="viewnamediv">
            <p class="viewname">Staff Picks</p></div>
            <div class="productlist">
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="onsale" class="products">
	        <div class="viewnamediv">
            <p class="viewname">On Sale</p></div>
            <div class="productlist">
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <p class="pname">Ping Pong Balls</p>
                    <div class="extraStuff">
                        <a href="singleProduct.php"><img src="images/pingpong.jpg" alt="Product Picture" class="pimg"/></a>
                        <div class="itemInfo">
                            <p class="itemPrice">$200</p>
                            <p class="numberOfLiams">5/5 Liams</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
</main>
<?php include "footer.php"; ?>
</body>
</html>
