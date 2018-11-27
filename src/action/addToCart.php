<?php


include "../includes/init.php";


if(isset($_SESSION['user'])){
    $user = $_SESSION['user']->id;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$inputFields = array('prodNum', 'size', 'quantity');
	if(!(arrayExists($_POST, $inputFields) && arrayIsValidInput($_POST, $inputFields))){
        //This is where I need you guys to somehow access this information
        $_SESSION['hasError'] = true;
        $_SESSION['errorType'] = "Form";
        $_SESSION['errorMsg'] = "invalid form data";
        header('location: ../homeWithoutTables.php');
    }else{
	    try{
		   $pNo = $_POST["prodNum"];
		   $size = $_POST['size'];
		   $quantity = $_POST['quantity'];
		   $pname = null;
		   $price = null;
		   
		   $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

		   if ($con->connect_errno) {
		   		die("Connection Failed: " . $con->connect_errno);
			}
			
			$getPriceName = "SELECT pname, price FROM Product WHERE pNo = ? AND size = ?";
			if($pstmt1 = $con->prepare($getPriceName)){
	            
           
            	$pstmt1->bind_param('is', $pNo, $size);

				$pstmt1->execute();
				$pstmt1->bind_result($name, $cost);

	            while($pstmt1->fetch()){
	                //should only be one row
	                $pname = $name;
	                $price = $cost;
	            }
	            
            }
            $numRows;
            $quantityToUpdate;
            
			if (isset($user)) {
				$stmt = "SELECT quantity FROM HasCart WHERE pNo = ? AND size = ? AND uid = ?";
				
				if($stmt = $con->prepare($stmt)){
					
					$stmt->bind_param('isi', $pNo, $size, $user);
					$stmt->execute();
					$stmt->store_result();
					$numRows = $stmt->num_rows;
					$stmt->bind_result($quant);
					echo $numRows;
					while($stmt->fetch()){
						$quantityToUpdate = $quant;
	           		}
				}
				if($numRows==0){
					$addProd = "INSERT INTO HasCart(uid, pNo, size, quantity) VALUES (?, ?, ?, ?)";
	
	                if($pstmt = $con->prepare($addProd)){
	
		                $pstmt ->bind_param('iisi',$user,$pNo,$size,$quantity);
		
		                $pstmt->execute();

		                header('location: ../singleProduct.php?pNo=' . $pNo);  
					}
				}else{
					$upd = "UPDATE HasCart SET quantity = ? WHERE pNo = ? AND size = ? AND uid = ?";
	
	                if($updStmt = $con->prepare($upd)){
						$quantity +=$quantityToUpdate;
		                $updStmt ->bind_param('iisi', $quantity, $pNo, $size, $user);
		                $updStmt->execute();
	
		                header('location: ../singleProduct.php?pNo=' . $pNo);  

					}
	            }
	        } else {
	            if(isset($price) && isset($pname)) {
	                //add to object cart
	
	                $uCartObj = $_SESSION['userCart'];
	
	                $uCartObj->addItem($pNo, $pname, $size, $quantity, $price);
	                
	            }
	            header('location: ../singleProduct.php?pNo=' . $pNo);  
	        }
		}catch (Exception $e){
            header('location: ../singleProduct.php?pNo=' . $pNo);      
        }finally{
            $con->close();
            die();
        }
    }
}
?>