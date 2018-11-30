<?php
include "includes/init.php";

$headerSet = 1;

if ( !isset($_SESSION['order_placed']) OR $_SESSION['order_placed'] === false ) {
    header("Location: homeWithoutTables.php");
}

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
    <h1>Your order is on its way!</h1>

    <h2>But just in case you missed it, have you seen: </h2>

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

    <!-- put in a fun image -->


</main>
<?php include "footer.php" ?>
</body>
</html>