<?php

//this file will need to have some hardcore HTML fun stuff, and will also have the ability to edit their cart... lets go with the query first

include "includes/init.php";
include "includes/user.php";
include "includes/userCart.php";
include "includes/headerFooterHead.php";

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

            mysqli_stmt_bindm($stmt, 'i', $user);
            mysqli_stmt_execute($stmt);

            while(mysqli_stmt_fetch($stmt)){

                //HOORAY FOR GARBAGE HTML

                echo("<tr><td>".$pNo. "</td>");
                echo("<td>" .$pname. "</td>");
                echo("<td>" .$size. "</td>");
                echo("<td align=\"center\">".$quantity. "</td>");
                echo("<td align=\"center\">".$priceQuant. "</td>");
            }

        }

    }
    catch(Exception $e){ die();}

}
else{

    //user not logged in
    //cart is an object (in a cookie or something idk), must iterate through (look at Ramon's code Lab 7)

    $uc = $_COOKIE['userCart'];

    $cart = getCart();

    //somehow iterate through the cart... idk how yet though so thats good

    foreach($cart as $itemID => $item){

        echo("<tr><td>".$item['pno']. "</td>");
        echo("<td>" .$item['pname']. "</td>");
        echo("<td>" .$item['size']. "</td>");
        echo("<td align=\"center\">".$item['qty']. "</td>");
        echo("<td align=\"center\">".$item['price']. "</td>");

    }

}

?>

