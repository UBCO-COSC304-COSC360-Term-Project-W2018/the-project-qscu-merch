<?php
include "includes/init.php";
$headerSet = 1;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/headerFooterHead.php" ?>
    <!--    always put my own stuff here below include :) -->

</head>

<body>
<?php include "header.php" ?>
<main>
    <p>Our apologies! We do not have the products that you want to order in our inventory</p>
    <p><a href=\"../homeWithoutTables.php\">Return Home</a></p>
    <p>Here are a few Liam's Picks:</p>
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
</main>
<?php include "footer.php"; ?>
</body>
</html>
