<?php
include "includes/init.php";

if(isset($_SESSION['user'])){
    $user = $_SESSION['user']->id;
}

$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if ($con->connect_errno) {
    die("Connection Failed: " . $con->connect_errno);
}

$cartRows = array();

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/cart.css">
        <?php include 'includes/headerFooterHead.php'; ?>
        <script type="text/javascript" src="script/cart_controller.js"></script>
</head>

<body>

	<?php include "header.php"; ?>

    <ul class="breadcrumb">
    <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
    <a>Your Cart</a>
</ul>
<main>


    <?php

    //this file will need to have some hardcore HTML fun stuff, and will also have the ability to edit their cart... lets go with the query first


    //So this will have two parts to it, depending on if the user is logged in or not

    if(isset($user)){
	    
        //user logged in
        //DB query to go through and display their cart

        
            // make a query with prepared statement for the user's cart with their id, then iterate through the list

// 			$sql = "SELECT pNo, pname, size, quantity FROM HasInventory NATURAL JOIN Product";
             $sql = "SELECT pNo, pname, size, quantity, price FROM HasCart NATURAL JOIN Product WHERE uid = ?";
			
            if($pstmt = $con->prepare($sql)){

                $pstmt->bind_param('i', $user);
                
                $pstmt->execute();
				$pstmt->bind_result($pNo, $pname, $size, $quantity, $price);

                while($pstmt->fetch()){
                   $prod = array();
                   $prod["pNo"] = $pNo;
                   $prod["pname"] =  $pname;
                   $prod["size"] =  $size;
                   $prod["quantity"] =  $quantity;
                   $total = $price*$quantity;
                   $prod["total"] =   $total;
                    
                  array_push($cartRows, $prod);
                    $len = count($cartRows);

                }

            }
            
			$con->close();
    }else{
	    
        //user not logged in
        //cart is an object (in a cookie or something idk), must iterate through (look at Ramon's code Lab 7)

        $cart = $_SESSION['cart'] -> getCart();

        //somehow iterate through the cart... idk how yet though so thats good

        foreach($cart as $itemID => $item){
			$prod = array();
            //add to the array
            
            
			$prod["pNo"] = $cart[$itemID]['pNo'];
			$prod["pname"] =  $cart[$itemID]['pname'];
			$prod["size"] =  $cart[$itemID]['size'];
			$prod["quantity"] =  $cart[$itemID]['qty'];
			$total = $cart[$itemID]['price']*$quantity;
			$prod["total"] =   $cart[$itemID]['price'];

            array_push($cartRows, $prod);

        }

    }

		$len = count($cartRows);
		    echo "<div id='cartDiv'><h1 id='cartHeader'>Your Shopping Cart</h1>";
		if($len==0){
	        echo "<h2 id='emptyCart'>Your Cart is Empty</h2>";
	        
        }else{
	        
        
			echo "<table id='cartTable'><tr><th>Product Name</th><th>Quantity</th><th>Size</th><th>Price</th></tr>";

        foreach ($cartRows as $prod) {
            //for each row in cartRows

            echo "<tr><form method='POST' action='action/updateCart.php'>";
            
            echo '<td><a href="singleProduct.php?pNo='.$prod['pNo'].'">'.$prod['pname'].'</a></td>';
        
            echo '<td class="centerContents"><input class="quant" type="number" name="newQuantity" pattern="\d+" value="' .$prod['quantity']. '"></td>';
            echo '<td class="centerContents">'.$prod['size'].'</td>';
            echo '<td>$' .$prod['total']. '</td>';
            echo '<input type = "hidden" name = "pNo" value = "'.$prod['pNo'].'">';
            echo '<input type = "hidden" name = "size" value = "'.$prod['size'].'">';
            echo '<input type = "hidden" name = "quantity" value = "'.$prod['quantity'].'">';
            echo '<td class="centerContents" class="updateCol"><input type="submit" class="button" name="productBtn" value="Update Item"></td>';
            echo '<td class="centerContents" class="removeCol"><input type="submit" class="button" name="productBtn" value="Remove"></td></form></tr>';
			$sumtotal += $prod['total'];
			
        }
        

        echo '<tr><td id="sumTotal" colspan="4">Your Subtotal: $' .$sumtotal . '</td><td class="centerContents"><form method="POST" action="checkout.php"><input type="submit" id="checkoutButton" class="button" value="Check-out"></form></td></tr>';
			echo '</table></div>';
			}
        ?>
</main>
<?php  
	include "footer.php"; ?>
</body>
</html>
