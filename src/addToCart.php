<?php


include "includes/init.php";
include "includes/user.php";
include "includes/userCart.php";

//This is where I need you guys to somehow access this information
$pNo = $_POST['pNo'];
$size = $_POST['size'];
$name = $_POST['pname'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

//can do a hidden field or form
//have a bunch of hidden buttons that will come up when the form is submitted

if(arrayExists($_POST, array('pNo', 'pname', 'size', 'quantity', 'price'))){


//So this will have two parts to it, depending on if the user is logged in or not

    if (isset($_SESSION['user'])) {
        //add to DB cart
        try {
            $user = $_SESSION['user']->id;

            $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

            if ($con->connect_errno) {
                die("Connection Failed: " . $con->connect_errno);
            }


            //prepared statement is better
            $addProd = "INSERT INTO HasCart VALUES (?, ?, ?, ?)";

            $pstmt = $con->prepare($addProd);

            $pstmt->bindValue(1, $user);
            $pstmt->bindValue(2, $pNo);
            $pstmt->bindValue(3, $size);
            $pstmt->bindValue(4, $quantity);

            $pstmt->execute();

            $con->close();


        } catch (Exception $e) {
            die();
        }

    } else {

        //add to object cart

        $uCartObj = $_COOKIE['userCart'];

        addItem($pNo, $pname, $size, $quantity, $price);


    }
}
?>