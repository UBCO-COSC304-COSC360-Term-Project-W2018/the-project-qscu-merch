<?php
include "includes/init.php";
include "includes/userCart.php";


//need to have arrays (2D array?) here to store the row results as strings

// then using HTML display all the arrays as the cart and have the buttons and stuff but this will also be in php

//then depending on the button clicks we are gonna have to update the cart

$cartRows = [];

//


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/cart.css">
        <?php include 'includes/headerFooterHead.php'?>
        <script type="text/javascript" src="script/cart_controller.js"></script>

    <ul class="breadcrumb">
        <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
        <a>Your Cart</a>
    </ul>
</head>

<body>
<main>



    <?php

    //this file will need to have some hardcore HTML fun stuff, and will also have the ability to edit their cart... lets go with the query first

    echo("<h1>Your Shopping Cart</h1>");
    echo("<table><tr><th>Product Id</th><th>Product Name</th><th>Size</th><th>Quantity</th><th>Price</th>");

    //So this will have two parts to it, depending on if the user is logged in or not

    if(isset($_SESSION['user'])){
        //user logged in
        //DB query to go through and display their cart

        $user = $_SESSION['user']->id;

        try{
            //make connection

            $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

            if ($con->connect_errno) {
                die("Connection Failed: " . $con->connect_errno);
            }
            // make a query with prepared statement for the user's cart with their id, then iterate through the list

            $qry = "SELECT pNo, pname, size, quantity, quantity*price AS priceQuant FROM  HasCart H, Product P WHERE uid = ?, H.pNo = P.pNo, H.size = P.size";


            if($stmt = mysqli_prepare($con, $qry)){

                $stmt ->bind_param('i', $user);
                $stmt -> execute();

                $result = $stmt->get_result();

                while($row = $result->fetch_assoc()){

                    $prod = ['pNo'] = $row['pNo'];
                    $prod = ['pname'] = $row['pname'];
                    $prod = ['size'] = $row['size'];
                    $prod = ['quantity'] = $row['quantity'];
                    $prod = ['priceQuant'] = $row['priceQuant'];

                    array_push($cartRows, $prod);

                }

            }

        }
        catch(Exception $e){ die();}
        finally{mysqli_close($con);}

    }
    else{

        //user not logged in
        //cart is an object (in a cookie or something idk), must iterate through (look at Ramon's code Lab 7)

        $uc = $_SESSION['userCart'];

        $cart = $uc -> getCart();

        //somehow iterate through the cart... idk how yet though so thats good

        foreach($cart as $itemID => $item){

            //add to the array

            $prod = ['pNo'] = $cart[$itemID]['pNo'];
            $prod = ['pname'] = $cart[$itemID]['pname'];
            $prod = ['size'] = $cart[$itemID]['size'];
            $prod = ['quantity'] = $cart[$itemID]['qty'];
            $prod = ['priceQuant'] = $cart[$itemID]['price'];

            array_push($cartRows, $prod);

        }

    }

    ?>

    <div id = mainCart>



        <?php

        foreach ($cartRows as $prod) {


            //for each row in cartRows
            echo '<form method="post" action="updateCart.php">';
            echo '<div class = "product">';
            echo '<input type="text" class="cartProductAmount" name="amount" placeholder="' .$prod['quantity']. '" maxlength="2">';
            echo '<span class="productName"><a class="aCart" href="singleProduct.php?pNo='.$prod['pNo'].'">'.$prod['pname'].'</a></span>';
            echo '<span class="productSize"><a class="aCart">'.$prod['size'].'</a></span>';
            echo '<span class = "priceLabel">Price: $</span>';
            echo '<span class = "productPrice">' .$prod['priceQuant']. '</span>';
            echo '<input type = "hidden" name = "pid" value = "'.$prod['pNo'].'">';
            echo '<input type = "hidden" name = "size" value = "'.$prod['size'].'">';
            echo '<input type = "hidden" name = "quantity" value = "'.$prod['quantity'].'">';
            echo '<span><a class=""aCart" href="">remove</a></span>';
            echo '<input type="submit" value="Update Item">';
            echo '</form>';

        }

        ?>


    </div>

    <div id="cartFooter">
            <button>Check-out</button>
    </div>

</main>
</body>
</html>
