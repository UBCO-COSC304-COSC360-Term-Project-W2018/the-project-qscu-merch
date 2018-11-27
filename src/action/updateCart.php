<?php

include "../includes/init.php";


if(isset($_SESSION['user'])){
	$user = $_SESSION['user']->id;
	}else{
		include "../includes/userCart.php";
	}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$inputFields = array('newQuantity', 'pno', 'size', 'quantity', 'productBtn');
	if(!(arrayExists($_POST, $inputFields) && arrayIsValidInput($_POST, $inputFields))){
	    $_SESSION['hasError'] = true;
        $_SESSION['errorType'] = "Form";
        $_SESSION['errorMsg'] = "invalid form data";
        header('location: ../homeWithoutTables.php');
    }else{
	    try{
		    
		    $sql = null;
		    $newQuantity = $_POST['newQuantity'];
		    $pNo = $_POST['pno'];
	        $size = $_POST['size'];
	        $quantity = $_POST['quantity'];
	        $buttonPressed = $_POST['productBtn'];
	        
			$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

				if ($con->connect_errno) {
					die("Connection Failed: " . $con->connect_errno);
				}
		    if (isset($user)) {
			    if($buttonPressed == 'Remove'){
				    $sql = "DELETE FROM HasCart WHERE quantity = ? AND pNo = ? AND size = ? AND uid = ?";
				    $newQuantity = $quantity;
				    
			    }else{
				    $sql = "UPDATE HasCart SET quantity = ? WHERE pNo = ? AND size = ? AND uid = ?";
			    }
			    
			    if($stmt = $con->prepare($sql)){
				    $stmt ->bind_param('iisi', $newQuantity, $pNo, $size, $user);
				    $stmt->execute();
					header('location: ../viewCart.php');
				}
	        } else {
	
	            //user doesn't exist, update the object
	            $uc = $_SESSION['userCart'];
	
	            if($buttonPressed == 'Remove'){
	                //delete the item from the cart
	                $uc -> removeItem($pno, $size);
	            }else{
	                //update the item's quantity in cart
	                $uc -> updateItem($pno, $size, $newQuantity);
	            }
	            header("location: ../viewCart.php");
	        }
        }catch(Exception $e){
	        die();
	    }finally{
		    $con->close();
		    die();
		}        
    }
}




?>


