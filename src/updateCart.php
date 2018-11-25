<?php
/**
 * Created by PhpStorm.
 * User: Liam
 * Date: 2018-11-24
 * Time: 3:08 PM
 */

//get the values from the viewCart to update the cart, then redirect to viewCart

//take in the db credentials and stuff

include "includes/init.php";
include "includes/userCart.php";


if(isset($_POST['pid']) && isset($_POST['quantity']) && isset($_POST['size'])){

    if(!(empty($_POST['pid']) && empty($_POST['quantity']) && empty($_POST['size']))){


        $pno = $_POST['pid'];
        $size = $_POST['pid'];
        $quantity = $_POST['pid'];


        if(isset($_SESSION['user'])){

            $user = $_SESSION['user'];

            //user exists, update the DB

            try{
                //need a case for if qty === 0 then delete from DB

                $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

                if ($con->connect_errno) {
                    die("Connection Failed: " . $con->connect_errno);
                }

                if($quantity < 1){
                    //delete from DB

                    $qry = "DELETE FROM HasCart WHERE uid = ? AND pNo = ? AND size = ?";

                    $pstmt = $con->prepare($qry);

                    $pstmt-> bindValue(1,$user);
                    $pstmt-> bindValue(2,$pno);
                    $pstmt-> bindValue(3,$size);

                    $pstmt -> execute();

                }else{

                    //update the quantity

                    $qry = "UPDATE HasCart SET quantity = ? WHERE uid = ? AND pNo = ? AND size = ?";

                    $pstmt = $con->prepare($qry);

                    $pstmt-> bindValue(1,$quantity);
                    $pstmt-> bindValue(2,$user);
                    $pstmt-> bindValue(3,$pno);
                    $pstmt-> bindValue(4,$size);


                    $pstmt -> execute();

                }

            }
            catch(Exception $e){die();}
            finally{mysqli_close($con);}


        }
        else{

            //user doesn't exist, update the object
            $uc = $_SESSION['userCart'];

            if($quantity < 1){
                //delete the item from the cart

                $uc -> removeItem($pno, $size);

            }else{
                //update the item's quantity in cart

                $uc -> updateItem($pno, $size, $quantity);
            }
        }

    }

}

header("location: viewCart.php");





