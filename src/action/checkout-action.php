
<?php
/*
Assumptions:
-address is comma delimited
-orders are placed and shipped on the same day
-every shipment is coming from warehouse 1
-price in HasOrder is the cost of quantity * price
*/
include '../includes/session.php';
include '../includes/db_credentials.php';

try {
    if (isset($_SESSION['fullShippingAddress']) and $_SESSION['totalCost']) {
        $fullShippingAddress = $_SESSION['fullShippingAddress'];
        $totalPrice = $_SESSION['totalCost'];


        $user = $_SESSION['user'];
        $userid = $user->id;

        $mysqli = new mysqli (DBHOST, DBUSER, DBPASS, DBNAME);

        //TODO: do this
        //check to make sure that user isn't banned
        $banned_user_sql = "SELECT customerBanned FROM User WHERE uid = ?";
        if ( $isBanned_user = $mysqli -> prepare($banned_user_sql) ) {
            $isBanned_user -> bind_param("s", $userid);
            $isBanned_user -> execute();

            $isBanned_user_result = $isBanned_user -> get_result();
            $isBanned_user_status = false;

            while ( $isBanned_user_row = $isBanned_user_result -> fetch_assoc() ) {
                $isBanned_user_status = $isBanned_user_row['customerBanned'];
            }
        }

        if ( $isBanned_user_status ) {
            if (isset($_SESSION['kicked_out']) ) {
                $_SESSION['kicked_out'] = true;
            }
            else {
                $_SESSION['kicked_out'] = true;
            }
            //TODO: change the URL
            header('Location: logout.php');
            exit();
        }
        $warehouseId = 1;
        $items_not_available = array();

        //create shipment- a new shipment will be created for each order (:
        $createShipment = "INSERT INTO shipment(dateShipped, uid, shippedFrom) VALUES (CURRENT_DATE ,?,?)";
        if ($shipment = $mysqli -> prepare($createShipment)) {
            $shipment -> bind_param("ss",$userid, $warehouseId );
            $shipment -> execute();
//            echo "<p>Shipment successfully created</p>";
        }
        else {
            throw new Exception();
        }

        //get the shipping number of the shipment that was just made
        $sNo_column_name = "sNo";
        $sNo_table_name = "Shipment";
        $sNo;
        $get_max_sNo = "SELECT MAX(sNo) AS recent FROM Shipment";
        if ($maxSno = $mysqli -> query($get_max_sNo)) {

            while ( $row = $maxSno -> fetch_assoc() ) {
                $sNo = $row['recent'];
            }
        }

//        echo "<p>".$sNo."</p>";

        //insert into orders
        $orderInsertSQL = "INSERT INTO Orders(shippingAddress, totalPrice, dateOrdered, uid, sNo ) VALUES (?,?,CURRENT_DATE ,?,?)";
        if ( $user_order = $mysqli -> prepare($orderInsertSQL) ) {
            $user_order -> bind_param("ssss", $fullShippingAddress,$totalPrice, $userid, $sNo);
            $user_order -> execute();
//            echo "<p>You successfully made the order</p>";
        }

        else {
            throw new Exception();
        }

        //get max order number (most recent one)
        $oNo;
        $get_max_oNo = "SELECT MAX(oNo) AS recent FROM Orders";
        if ( $maxOno = $mysqli -> query($get_max_oNo)) {

            while ( $row = $maxOno -> fetch_assoc() ) {
                $oNo = $row['recent'];
            }
        }

        //populate order with items from user's cart
        $user_cart_sql = "SELECT * FROM HasCart WHERE uid = ?";
        if ( $user_cart = $mysqli -> prepare($user_cart_sql) ) {
            $user_cart -> bind_param("s",$userid);
            $user_cart -> execute();

            $result = $user_cart -> get_result();

//            echo "<p>".$result -> num_rows."</p>";
            //go thru each item in cart and update db
            while ( $row = $result -> fetch_assoc() ) {
                $pNo = $row['pNo'];
                $size = $row['size'];
                $quantity = $row['quantity'];

                //get the cost of that product and size from db
                $singluarProductCost;
                $product_cost_sql = "SELECT price FROM Product WHERE pNo = ? AND size = ?";
                if ( $product_cost = $mysqli -> prepare($product_cost_sql) ) {
                    $product_cost -> bind_param("ss", $pNo, $size );
                    $product_cost -> execute();

                    $product_cost_result = $product_cost -> get_result();

                    while ( $product_cost_row = $product_cost_result -> fetch_assoc() ) {
                        $singularProductCost = $product_cost_row['price'];
                    }
                }
                $productNetCost = $singularProductCost * $quantity;

                //watch out for case where user tries to buy something we don't have in inventory
                $update_inv_sql = "UPDATE HasInventory SET quantity = quantity - ? WHERE wNo = ? AND pNo = ? AND size = ? AND (quantity - ?) >= 0";
                if ( $update_inv = $mysqli -> prepare($update_inv_sql) ) {
                    $update_inv -> bind_param("sssss", $quantity, $warehouseId, $pNo, $size, $quantity);
                    $update_inv -> execute();
                }

                //we don't enough of this product in inventory, update order cost and skip this item, go to next
                else {
                    $update_order_sql = "UPDATE Orders SET totalPrice = totalPrice - ? WHERE shippingAddress = ? AND dateOrdered = CURRENT_DATE  AND uid = ? AND sNo = ?";
                    if ( $update_order = $mysqli -> prepare($update_order_sql) ) {
                        $update_order -> bind_param("ssss", $productNetCost, $fullShippingAddress, $userid, $sNo);
                        $update_order -> execute();
                        //TODO: add to array here
                    }
                    //something really went wrong lol
                    else {
                        throw new Exception();
                    }
                    continue;
                }
                //check that the product that user wants to buy isn't disabled
                $product_enabled_sql = "SELECT isEnabled FROM Product WHERE pNo = ? AND size = ?";
                if ( $product_enabled = $mysqli -> prepare($product_enabled_sql) ) {
                    $product_enabled -> bind_param("ss", $pNo, $size);
                    $product_enabled -> execute();

                    $product_enabled_result = $product_enabled -> get_result();

                    $product_enabled_status = false;
                    while ( $product_enabled_row = $product_enabled_result ->fetch_assoc() ) {
                        $product_enabled_status = $product_enabled_row['isEnabled'];
                    }
                    //item is removed from cart in finally statement
                    if ( !$product_enabled_status ) {
                        continue;
                    }
                }

                //create order product
                $hasOrder_insert_sql = "INSERT INTO HasOrder(oNo, pNo, size, quantity, price) VALUES (?,?,?,?,?)";
                if ( $hasOrder_insert = $mysqli -> prepare($hasOrder_insert_sql) ) {
                    $hasOrder_insert -> bind_param("sssss", $oNo, $pNo, $size, $quantity, $productNetCost);
                    $hasOrder_insert -> execute();
//                    echo "<p>Inserted an order into HasOrder</p>";
                }
            }

//            check to make sure that an order has products in it
            $order_product_count_sql = "SELECT COUNT(oNo) as prodCount FROM HasOrder WHERE oNo = ? GROUP BY oNo";
            if ( $order_product_error_check = $mysqli -> prepare($order_product_count_sql) ) {
//                echo "<p>the if statement executed</p>";
                $order_product_error_check -> bind_param("s", $oNo);
                $order_product_error_check -> execute();

                $order_product_error_check_result = $order_product_error_check -> get_result();
//                echo "<p>".$order_product_error_check_result -> num_rows."</p>";

                //if there are no products associated with this order number, then we are gonna delete the order from Orders
                if ( $order_product_error_check_result -> num_rows === 0 ) {
//                    echo "<p>".$oNo."</p>";
                    $remove_order_sql = "DELETE FROM Orders WHERE oNo = ?";

                    if ( $remove_order = $mysqli -> prepare($remove_order_sql) ) {
                        $remove_order -> bind_param("s", $oNo);
                        $remove_order -> execute();
                    }
                    //TODO: REPLACE WITH REDIRECT
                    //TODO: REPLACE WITH ACTUAL URL REDIRECt RACHELLE USE RELATIVE
                    header("Location: ../orderError.php");
                    $_SESSION['order_error'] = true;
//                    echo "<p>Our apologies! We do not have the products that you want to order in our inventory</p>";
//                    echo "<p><a href = \"../homeWithoutTables.php\" >Return Home</a></p>";
                }

                //its all good to delete their cart
                else {
                    $_SESSION['order_placed'] = true;
                    header("Location: ../orderPlaced.php");
//                    echo "<p>redirecting user</p>";
                }
            }
            else {
//                echo "<p>it hits the else and skips the if </p>";
            }
        }

    }
    else {
        die();
    }
}

catch (Exception $exception) {
    die();
}
finally {

    $remove_cart_sql = "DELETE FROM HasCart WHERE uid = ?";
    if ( $remove_cart = $mysqli -> prepare($remove_cart_sql) ) {
        $remove_cart -> bind_param("s", $userid);
        $remove_cart -> execute();
    }

    $mysqli -> close();
}

