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

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/cart.css">
	<?php include 'includes/headerFooterHead.php';?>
    <script type="text/javascript" src="script/cart_controller.js"></script>
</head>

<body>
	<?php include "header.php"; ?>
    <main>
        <div id="cartHeader">
            <p>Your Cart</p>
        </div>
        <div id="cartMain">
            <?php


            $sqlGetCart = "SELECT pNo, size, quantity, pname, price FROM HasCart, Product WHERE uid = ".$user." and HasCart.pNo = Product.pNo";

            if($result = $con->query($sqlGetCart)){

                echo "<div class='product'>";

                while($prod = $result->fetch_assoc()){

                    $quant = '"'.$prod['quantity'].'"';
                    $price = '"'.$prod['price'].'"';
                    $prodName = '"'.$prod['pname'].'"';
                    $size = '"'.$prod['size'].'"';

                   echo "<input type='text' class='cartProductAmount' name='product'placeholder=$quant maxlength='2'><span class='productName'><a class='aCart' href=''>$prodName</a></span><span class='priceLabel'>Price: $</span><span class='productPrice'>$price</span><span><a class='aCart' href=''>remove</a></span>";
                }

                echo "</div>";

                }
            else{
                //error here with query, so we kill it
                die();

            }
            ?>
        </div>
        <div id="cartFooter">

            <?php

            $sqlGetCartPrice = "SELECT SUM(P.price) AS cartPrice FROM HasCart H, Product P WHERE H.uid = ".$user." and H.pNo = P.pNo";

            if($resultPrice  = $con->query($sqlGetCartPrice)){

                $totalPrice = '"'.$resultPrice['cartPrice'].'"';

                echo "<span>Total Cost: $<span id='costTotal'>$totalPrice</span><button>Update Cart</button><button>Check-out</button></span>";
            }
            else{
                die();
            }
            ?>
        </div>
    </main>
</body>
</html>

<?php
include "footer.php";
$con->close();

?>