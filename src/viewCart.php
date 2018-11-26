<?php
include "includes/init.php";



//need to have arrays (2D array?) here to store the row results as strings

// then using HTML display all the arrays as the cart and have the buttons and stuff but this will also be in php

//then depending on the button clicks we are gonna have to update the cart

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
<html lang="en">
<head>
    <link rel="stylesheet" href="css/cart.css">
        <?php include 'includes/headerFooterHead.php'; ?>
        <script type="text/javascript" src="script/cart_controller.js"></script>
</head>

<body>
	<?php include "header.php"; ?>
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
    }
    else{

        //user not logged in
        //cart is an object (in a cookie or something idk), must iterate through (look at Ramon's code Lab 7)

        $uc = $_SESSION['userCart'];

        $cart = $uc -> getCart();

        //somehow iterate through the cart... idk how yet though so thats good

        foreach($cart as $itemID => $item){
			$prod = array();
            //add to the array
            $prod = array();
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
		    
			echo "<form method='POST' action='updateCart.php'><table id='cartTable'><tr><th>Product Name</th><th>Quantity</th><th>Size</th><th>Price</th></tr>";

        foreach ($cartRows as $prod) {


            //for each row in cartRows
            echo '<tr>';
            
            echo '<td><a href="singleProduct.php?pNo='.$prod['pNo'].'">'.$prod['pname'].'</a></td>';
        
            echo '<td class="centerContents"><input class="quant" type="number" name="amount" pattern="\d+" value="' .$prod['quantity']. '"></td>';
            echo '<td class="centerContents">'.$prod['size'].'</td>';
            echo '<td>$' .$prod['total']. '</td>';
            echo '<input type = "hidden" name = "pid" value = "'.$prod['pNo'].'">';
            echo '<input type = "hidden" name = "size" value = "'.$prod['size'].'">';
            echo '<input type = "hidden" name = "quantity" value = "'.$prod['quantity'].'">';
            echo '<td class="centerContents" class="removeCol"><button class="button">Remove</button></td>';
            echo '<td class="centerContents" class="updateCol"><input class="button" type="submit" value="Update Item"></td></tr>';
			$sumtotal += $prod['total'];
			
        }
        
        echo '<tr><td id="sumTotal" colspan="4">Your Subtotal: $' .$sumtotal . '</td><td class="centerContents"><button id="checkoutButton" class="button">Check-out</button></td></tr>';
			echo '</table></form></div>';
        ?>
</main>
<?php  
	include "footer.php"; ?>
</body>
</html>
