<?php
/*
Assumptions:
-address is comma delimited
-orders are placed and shipped on the same day
-every shipment is coming from warehouse 1
-price in HasOrder is the cost of quantity * price
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        if ($isBanned_user = $mysqli->prepare($banned_user_sql)) {
            $isBanned_user->bind_param("s", $userid);
            $isBanned_user->execute();

            $isBanned_user->bind_result($dbUserBanned);
            $isBanned_user_status = false;

            while ($isBanned_user->fetch()) {
                $isBanned_user_status = $dbUserBanned;
            }
            $isBanned_user -> close();
        }

        if ($isBanned_user_status) {
            if (isset($_SESSION['kicked_out'])) {
                $_SESSION['kicked_out'] = true;
            } else {
                $_SESSION['kicked_out'] = true;
            }
            //TODO: change the URL
            header('Location: logout.php');
            exit();
        }
        $warehouseId = 1;
        $items_not_available = array();

        //create shipment- a new shipment will be created for each order (:
        $createShipment = "INSERT INTO Shipment(dateShipped, uid, shippedFrom) VALUES (CURRENT_DATE ,?,?)";
        if ($shipment = $mysqli->prepare($createShipment)) {
//            echo "<p>creating shipmment</p>";
            $shipment->bind_param("ss", $userid, $warehouseId);
            $shipment->execute();
//            echo "<p>Shipment successfully created</p>";
        } else {
//            echo "<p>threw shipment exception</p>";
            throw new Exception();
        }

        //get the shipping number of the shipment that was just made
        $sNo_column_name = "sNo";
        $sNo_table_name = "Shipment";
        $sNo;
        $get_max_sNo = "SELECT MAX(sNo) AS recent FROM Shipment";
        if ($maxSno = $mysqli->query($get_max_sNo)) {

            while ($row = $maxSno->fetch_assoc()) {
                $sNo = $row['recent'];
            }
        }

//        echo "<p>shipping number is:".$sNo."</p>";

        //insert into orders
        $orderInsertSQL = "INSERT INTO Orders(shippingAddress, totalPrice, dateOrdered, uid, sNo ) VALUES (?,?,CURRENT_DATE ,?,?)";
        if ($user_order = $mysqli->prepare($orderInsertSQL)) {
//            echo "<p>inserting into orders</p>";
            $user_order->bind_param("ssss", $fullShippingAddress, $totalPrice, $userid, $sNo);
            $user_order->execute();
//                echo "<p>query really executed</p>";
            }
//            echo "<p>You successfully made the order</p>";
        } else {
//            echo "<p>Throwing exception at orderInsertSQL</p>";
            throw new Exception();
        }

        //get max order number (most recent one)
        $oNo = 0;
        $get_max_oNo = "SELECT MAX(oNo) AS recent FROM Orders";
        if ($maxOno = $mysqli->query($get_max_oNo)) {
//            echo "<p>the ordder number here is</p>";
            while ($row = $maxOno->fetch_assoc()) {
                $oNo = $row['recent'];
//                echo "<p>".$oNo."</p>";
            }
        }

//        echo "<p>order number is".$oNo."</p>";
        $twoDimArray = array();
        $count = 0;
        //populate order with items from user's cart
        $user_cart_sql = "SELECT * FROM HasCart WHERE uid = ?";
        //getting items from cart, prices are set to zero
//        echo "<p>before if statement</p>";
        if ($user_cart = $mysqli->prepare($user_cart_sql)) {
//            echo "<p>yoou are in if statement</p>";
            $user_cart->bind_param("s", $userid);
            $user_cart->execute();

            $user_cart->bind_result($dbUid, $dbPno, $dbSize, $dbQuantity);

            //go thru each item in cart and update db
            while ($user_cart->fetch()) {
//                echo "<p>youre adding an item to the 2d array</p>";
                $pNo = $dbPno;
                $size = $dbSize;
                $quantity = $dbQuantity;

//                echo "<p>before adding to the array</p>";
                $twoDimArray[$count] = array('pNo' => $pNo, 'size' => $size, 'quantity' => $quantity, 'singularPrice' => 0, 'netPrice' => 0, 'included' => 1);
//                echo "<p>after adding to the array</p>";
                $count = $count + 1;

            }
        } else {
//            echo "<p>an exception was thrown making the array of items </p>";
            throw new Exception();
        }

        for ($i = 0; $i < $count; $i = $i + 1) {
//            echo "<p>entered for loop declaring variables</p>";
            $cart_pNo = $twoDimArray[$i]['pNo'];
//            echo "<p>".$cart_pNo."</p>";
            $cart_size = $twoDimArray[$i]['size'];
//            echo "<p>".$cart_size."</p>";
            $cart_quantity = $twoDimArray[$i]['quantity'];
//            echo "<p>".$cart_quantity."</p>";
            $warehouseId = 1;
            $singularProductCost;
            $productNetCost;

            print_r($twoDimArray);

            $product_cost_sql = "SELECT price FROM Product WHERE pNo=? AND size=?";
            if ($product_cost = $mysqli->prepare($product_cost_sql)) {
//                echo "<p>preparing price</p>";
                $product_cost->bind_param("ss", $cart_pNo, $cart_size);
                $product_cost->execute();
//                echo "<p>This is the var dump of ".var_dump($product_cost->execute())."</p>";

                $product_cost->bind_result($dbPrice);
//                echo "<p>This is the var dump of ".var_dump($product_cost->bind_result($dbPrice))."</p>";
//                echo "<p>This is the var dump of ".var_dump($product_cost->fetch())."</p>";
//                echo "<p>".var_dump($dbPrice)."</p>";
//                $product_cost->error();
                while ($product_cost->fetch()) {
//                    echo "<p>enter product fetch loop</p>";
                    $singularProductCost = $dbPrice;
                    $productNetCost = $singularProductCost * $cart_quantity;
                    $twoDimArray[$i]['singularPrice'] = $singularProductCost;
                    $twoDimArray[$i]['netPrice'] = $productNetCost;
//                    echo "<p>".$singularProductCost."</p>";
//                    print_r($twoDimArray);
                }

                $product_cost ->close();

            } else {
                $twoDimArray[$i]['included'] = 0;
            }

            //watch out for case where user tries to buy something we don't have in inventory
            $update_inv_sql = "UPDATE HasInventory SET quantity = quantity - ? WHERE wNo = ? AND pNo = ? AND size = ? AND (quantity - ?) >= 0";
            //we have enough in inventory so we update it
            if ($update_inv = $mysqli->prepare($update_inv_sql)) {
//                echo "<p>updating order has inventory </p>";
                $update_inv->bind_param("sssss", $cart_quantity, $warehouseId, $cart_pNo, $cart_size, $cart_quantity);
                $update_inv->execute();
//                echo "<p>var dump for executing update inv".var_dump($update_inv->execute())."</p>";
//                echo "<p> updated rows: ". $update_inv->affected_rows."</p>";
            } //we don't enough of this product in inventory, update order cost and skip this item, go to next
            if ( ($update_inv->affected_rows) === 0){
//                echo "<p>entered if for updating order because there isn't enough in inventory</p>";
                //we don't have enough so we remove it from their order
                $update_order_sql = "UPDATE Orders SET totalPrice = totalPrice - ? WHERE shippingAddress = ? AND dateOrdered = CURRENT_DATE  AND uid = ? AND sNo = ?";
                if ($update_order = $mysqli->prepare($update_order_sql)) {
//                    echo "<p>updating order cause its not in inventory</p>";
                    $update_order->bind_param("ssss", $twoDimArray[$i]['netPrice'], $fullShippingAddress, $userid, $sNo);
                    $update_order->execute();
                    $twoDimArray[$i]['included'] = 0;
                    //TODO: add to array here
                } //something really went wrong lol
                else {
//                    echo "<p>Throwing exception at updateOrderSQL</p>";
                    throw new Exception();
                }
            }

            //check that the product that user wants to buy isn't disabled
            $product_enabled_sql = "SELECT isEnabled FROM Product WHERE pNo = ? AND size = ?";
            if ($product_enabled = $mysqli->prepare($product_enabled_sql)) {

                $product_enabled->bind_param("ss", $cart_pNo, $cart_size);
                $product_enabled->execute();

                $product_enabled->bind_result($dbProductEnabled);

                $product_enabled_status = true;
                while ($product_enabled->fetch()) {
                    $product_enabled_status = $dbProductEnabled;
                }
                //item is removed from cart in finally statement
                if (!$product_enabled_status) {
                    $twoDimArray[$i]['included'] = 0;
                }
            }

//            create order product
            $hasOrder_insert_sql = "INSERT INTO HasOrder(oNo, pNo, size, quantity, price) VALUES (?,?,?,?,?)";
            if ($twoDimArray[$i]['included'] == 1) {
                if ($hasOrder_insert = $mysqli->prepare($hasOrder_insert_sql)) {
                    $hasOrder_insert->bind_param("sssss", $oNo, $cart_pNo, $cart_size, $cart_quantity, $twoDimArray[$i]['netPrice']);
                    $hasOrder_insert->execute();
                }
            }

        }


//        //populate order with items from user's cart
//        $user_cart_sql = "SELECT * FROM HasCart WHERE uid = ?";
//        if ($user_cart = $mysqli->prepare($user_cart_sql)) {
//            $user_cart->bind_param("s", $userid);
//            $user_cart->execute();
//
//            $user_cart->bind_result($dbUid, $dbPno, $dbSize, $dbQuantity);
//
////            echo "<p>".$result -> num_rows."</p>";
//            //go thru each item in cart and update db
//            while ($user_cart->fetch()) {
//                $pNo = $dbUid;
//                $size = $dbPno;
//                $quantity = $dbQuantity;
//
//                //get the cost of that product and size from db
//                $singluarProductCost;
//                $product_cost_sql = "SELECT price FROM Product WHERE pNo = ? AND size = ?";
//                echo "<p>beginning of if-statement</p>";
//                $product_cost = $mysqli->prepare($product_cost_sql);
//                echo var_dump($product_cost);
//                print_r($mysqli->error_list);
//                if ($product_cost = $mysqli->prepare($product_cost_sql)) {
//                    echo "<p>entered if-statement</p>";
//                    $product_cost->bind_param("ss", $pNo, $size);
//                    echo "<p>binded param</p>";
//                    $product_cost->execute();
//                    echo "<p>executed</p>";
//
////                    $product_cost_result = $product_cost->get_result();
//                    $product_cost->bind_result($dbPrice);
//                    echo "<p>binded result</p>";
//                    echo "<p>".$dbPrice."</p>";
//
//                    while ($product_cost->fetch()) {
//                        echo "<p>entering product cost loop</p>";
//                        $singularProductCost = $dbPrice;
//                        echo "<p>".$singularProductCost."</p>";
//                    }
//                }
//                echo "<p>exited if statement</p>";
//                $productNetCost = $singularProductCost * $quantity;
//
//                //watch out for case where user tries to buy something we don't have in inventory
//                $update_inv_sql = "UPDATE HasInventory SET quantity = quantity - ? WHERE wNo = ? AND pNo = ? AND size = ? AND (quantity - ?) >= 0";
//                if ($update_inv = $mysqli->prepare($update_inv_sql)) {
//                    $update_inv->bind_param("sssss", $quantity, $warehouseId, $pNo, $size, $quantity);
//                    $update_inv->execute();
//                } //we don't enough of this product in inventory, update order cost and skip this item, go to next
//                else {
//                    $update_order_sql = "UPDATE Orders SET totalPrice = totalPrice - ? WHERE shippingAddress = ? AND dateOrdered = CURRENT_DATE  AND uid = ? AND sNo = ?";
//                    if ($update_order = $mysqli->prepare($update_order_sql)) {
//                        $update_order->bind_param("ssss", $productNetCost, $fullShippingAddress, $userid, $sNo);
//                        $update_order->execute();
//                        //TODO: add to array here
//                    } //something really went wrong lol
//                    else {
//                        echo "<p>Throwing exception at updateOrderSQL</p>";
//                        throw new Exception();
//                    }
//                    continue;
//                }
//                //check that the product that user wants to buy isn't disabled
//                $product_enabled_sql = "SELECT isEnabled FROM Product WHERE pNo = ? AND size = ?";
//                if ($product_enabled = $mysqli->prepare($product_enabled_sql)) {
//                    $product_enabled->bind_param("ss", $pNo, $size);
//                    $product_enabled->execute();
//
////                    $product_enabled_result = $product_enabled->get_result();
//
//                    $product_enabled->bind_result($dbProductEnabled);
//
//                    $product_enabled_status = false;
//                    while ($product_enabled->fetch()) {
//                        $product_enabled_status = $dbProductEnabled;
//                    }
//                    //item is removed from cart in finally statement
//                    if (!$product_enabled_status) {
//                        continue;
//                    }
//                }
//
//                //create order product
//                $hasOrder_insert_sql = "INSERT INTO HasOrder(oNo, pNo, size, quantity, price) VALUES (?,?,?,?,?)";
//                if ($hasOrder_insert = $mysqli->prepare($hasOrder_insert_sql)) {
//                    $hasOrder_insert->bind_param("sssss", $oNo, $pNo, $size, $quantity, $productNetCost);
//                    $hasOrder_insert->execute();
////                    echo "<p>Inserted an order into HasOrder</p>";
//                }
//            }
        //END OF WHILE

//            check to make sure that an order has products in it
        $order_product_count_sql = "SELECT COUNT(oNo) as prodCount FROM HasOrder WHERE oNo = ? GROUP BY oNo";
        if ($order_product_error_check = $mysqli->prepare($order_product_count_sql)) {
//            echo "<p>entered count for order number</p>";
            $order_product_error_check->bind_param("s", $oNo);
            $order_product_error_check->execute();

//            $order_product_error_check->bind_result($dbProdCount);
            $order_product_error_check->store_result();
            $order_product_error_check->bind_result($db_count_order);

            $count_of_orders = 0;
            while ( $order_product_error_check -> fetch() ){
                $count_of_orders = $db_count_order;
            }
//            echo "<p>".$count_of_orders."</p>";
//                $order_product_error_check_result = $order_product_error_check->get_result();
//                echo "<p>".$order_product_error_check_result -> num_rows."</p>";

            //if there are no products associated with this order number, then we are gonna delete the order from Orders
//            echo "<p>var dump of count orders bool is: ".var_dump($count_of_orders===0)."</p>";
            if ($count_of_orders === 0) {
//                    echo "<p>".$oNo."</p>";
//                echo "<p>the number values in order is 0</p>";
                $remove_order_sql = "DELETE FROM Orders WHERE oNo = ?";

                if ($remove_order = $mysqli->prepare($remove_order_sql)) {
                    $remove_order->bind_param("s", $oNo);
                    $remove_order->execute();
                }

                header("Location: ../orderError.php");
//                echo "<p>THis is where i would redirect to orderError</p>";
                $_SESSION['order_error'] = true;
//                    echo "<p>Our apologies! We do not have the products that you want to order in our inventory</p>";
//                    echo "<p><a href = \"../homeWithoutTables.php\" >Return Home</a></p>";
            } //its all good to delete their cart
            else {
//                echo "<p>I am in the else part of num orders</p>";
                $_SESSION['order_placed'] = true;
                header("Location: ../orderPlaced.php");
//                echo "<p>THis is where i would redirect to order Placed</p>";
//                    echo "<p>redirecting user</p>";
            }



    } else {
//        echo "<p>This is where I would redirect to error 404</p>";
        header('location: ../error404.php');
    }
} catch (Exception $exception) {
    $mysqli->close();
    header('location: ../error404.php');
    exit();
} finally {

    $mysqli = new mysqli (DBHOST, DBUSER, DBPASS, DBNAME);

    $remove_cart_sql = "DELETE FROM HasCart WHERE uid = ?";
    if ($remove_cart = $mysqli->prepare($remove_cart_sql)) {
        $remove_cart->bind_param("s", $userid);
        $remove_cart->execute();
    }

    $mysqli->close();
}

