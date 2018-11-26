<?php


include "includes/init.php";
// include "includes/user.php";
// include "includes/userCart.php";


//can do a hidden field or form
//have a bunch of hidden buttons that will come up when the form is submitted
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(arrayExists($_POST, array('pNo', 'size', 'quantity'))){

        //This is where I need you guys to somehow access this information
        $pNo = $_POST['pNo'];
        $size = $_POST['size'];
        $quantity = $_POST['quantity'];

        //need to query for price and pname, so LETS DO THAT

        try{

            $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

            if ($con->connect_errno) {
                die("Connection Failed: " . $con->connect_errno);
            }

            $getPriceName = "SELECT pname, price FROM Product WHERE pNo = ? AND size = ?";

            $pstmt1 = $con->prepare($getPriceName);
            $pstmt1 ->bind_param('id', $pNo, $size);

            $pstmt1 -> execute();

            $result = $pstmt1 ->get_result();

            while($row = $result->fetch_assoc()){
                //should only be one row
                $pname = $row['pname'];
                $price = $row['price'];

            }

            $pstmt1 -> close();
            $con -> close();

        }
        catch (Exception $e){die();}



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

                $pstmt ->bind_param('iisi',$user,$pNo,$size,$quantity);


                $pstmt->execute();
                $pstmt -> close();

                $con->close();


            } catch (Exception $e) {
                die();
            }

        } else {

            if(isset($price) && isset($pname)) {
                //add to object cart

                $uCartObj = $_SESSION['userCart'];

                $uCartObj->addItem($pNo, $pname, $size, $quantity, $price);
            }

        }
    }
}
?>