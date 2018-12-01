<?php
include "includes/init.php";

//if ( !isset($_SESSION['user'])) {
//    header("Location: homeWithoutTables.php");
//    exit();
//}
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    } else {
        //getting the user object
        //TODO: RACHELLE REMEMBER TO UNCOMMENT THIS WHEN YOU ARE DONE TESTING
        $user = $_SESSION['user'];
        $userid = $user->id;

    }
    if (!isset($_POST['ccName']) || !isset($_POST['ccNum']) || !isset($_POST['ccExpiration'])
            || !isset($_POST['ccv']) || !isset($_POST['billingAddress']) || !isset($_POST['billingCity'])
            || !isset($_POST['billingProvince']) || !isset($_POST['billingCountry']) || !isset($_POST['billingPostalCode'])
            || !isset($_POST['shippingAddressRadio']) || !isset($_POST['shippingAddress']) || !isset($_POST['shippingCity'])
            || !isset($_POST['shippingProvince']) || !isset($_POST['shippingCountry']) || !isset($_POST['shippingPostalCode'])) {
        header("Location: homeWithoutTables.php");
        exit();
    }
    //all variables set
    else {
        $mysqli;
        try {
            $ccName = $_POST['ccName'];
            $ccNum = $_POST['ccNum'];
            $ccExp = $_POST['ccExpiration'];
            $ccCCV = $_POST['ccv'];

            $radio = $_POST['shippingAddressRadio'];
            $billingAddressLine = $_POST['billingAddress'];
            $billingCity = $_POST['billingCity'];
            $billingProvince = $_POST['billingProvince'];
            $billingCountry = $_POST['billingCountry'];
            $billingPostalCode = $_POST['billingPostalCode'];


            $mysqli = new mysqli (DBHOST, DBUSER, DBPASS, DBNAME);

            $sql = "UPDATE BillingInfo SET country = ?, province = ?, city = ?, address = ?,
                        postalCode = ?, creditCardNumber = ?, cardExpiryDate = ?, ccv=?
                         WHERE uid = ?";


            //update DB with billing info
            if ( $user_billing_info = $mysqli -> prepare($sql) ) {
                $user_billing_info -> bind_param("sssssssss", $billingCountry, $billingProvince, $billingCity,
                    $billingAddressLine, $billingPostalCode, $ccNum, $ccExp, $ccCCV, $userid );
                $user_billing_info -> execute();
            }
            else {
                throw new Exception();
            }

            $shippingAddressLine;
            $shippingCity;
            $shippingProvince;
            $shippingCountry;
            $shippingPostalCode;

            //case where billing address = shipping address
            if ( $radio == 1 ) {
                $shippingAddressLine = $billingAddressLine;
                $shippingCity = $billingCity;
                $shippingProvince = $billingProvince;
                $shippingCountry = $billingCountry;
                $shippingPostalCode = $billingPostalCode;

            }
            else if ( $radio == 2 ) {
                $shippingAddressLine = $_POST['shippingAddress'];
                $shippingCity = $_POST['shippingCity'];
                $shippingProvince = $_POST['shippingProvince'];
                $shippingCountry = $_POST['shippingCountry'];
                $shippingPostalCode = $_POST['shippingPostalCode'];
            }

        }
        catch (Exception $exception) {
//            die();
            echo $mysqli->error_list;
            echo "<p>went to catch</p>";
        }

    }
}
//a POST method wasn't used
else {
//    die();
    header("Location: homeWithoutTables.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/headerFooterHead.php" ?>
    <!--    always put my own stuff here below include :) -->
    <link rel="stylesheet" href="css/orderSummary.css">
    <script src="libs/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="script/orderSummary.js"></script>

</head>

<body>
<?php include "header.php" ?>

<ul class="breadcrumb">
    <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
    <a href="viewCart.php">Cart</a> &gt; &gt;
    <a href="checkout.php">Checkout</a>>>
    <a>Your Order</a>
</ul>
<main id="orderSummaryBody">
    <h1>Your Order:</h1>
    <div id="userOrderTableContainer">
        <table id="userOrderTable">
            <thead>
            <tr class="userOrderTableRow" id="userOrderTableFieldNames">
                <th>Quantity</th>
                <th>Product</th>
                <th>Size</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $cartTwoDimArray = array();


            $sql = "SELECT hascart.quantity, product.pname, hascart.size, product.price " .
                "FROM hascart JOIN product ON hascart.pno = product.pno AND hascart.size = product.size " .
                "WHERE hascart.uid = ?";

            if ($user_cart = $mysqli->prepare($sql)) {
                $user_cart->bind_param("s", $userid);
                $user_cart->execute();

                $result = $user_cart->get_result();

                $count = 0;
                $subtotal = 0;
                while ($row = $result->fetch_assoc()) {
                    $quantity = $row['quantity'];
                    $product_name = $row['pname'];
                    $size = $row['size'];
                    $price = $row['price'];

                    $total_price = $price * $quantity;
                    $subtotal = $subtotal + $total_price;

                    $cartTwoDimArray[$count] = array('quantity' => $quantity, 'productName' => $product_name,
                        'size' => $size, 'totalPrice' => $total_price);
                    $count = $count + 1;
                }

                foreach ($cartTwoDimArray as $item) {
                    echo "<tr class=\"userOrderTableRow\">
                            <td>" . $item['quantity'] . "</td>
                            <td>" . $item['productName'] . "</td>
                            <td>" . $item['size'] . "</td>
                            <td>" . $item['totalPrice'] . "</td>                           
                        </tr>";
                }
            }

            $taxTotal = 0;
            $tax = 0;
            switch ($shippingProvince) {
                case 'AB' :
                    $tax = 0.05;
                    break;
                case 'BC' :
                    $tax = 0.12;
                    break;
                case 'MB' :
                    $tax = 0.13;
                    break;
                case 'NB' :
                    $tax = 0.15;
                    break;
                case 'NL' :
                    $tax = 0.15;
                    break;
                case 'NS' :
                    $tax = 0.15;
                    break;
                case 'NT' :
                    $tax = 0.05;
                    break;
                case 'NU' :
                    $tax = 0.05;
                    break;
                case 'ON' :
                    $tax = 0.13;
                    break;
                case 'PE' :
                    $tax = 0.15;
                    break;
                case 'QC' :
                    $tax = 0.14975;
                    break;
                case 'SK' :
                    $tax = 0.11;
                    break;
                case 'YK' :
                    $tax = 0.05;
                    break;
                default :
                    $tax = 0;
            }

            $taxTotal = number_format((float)($subtotal * $tax), 2, '.', '');
            $netTotal = number_format((float)($subtotal + $taxTotal), 2, '.', '');

            $fullShippingAddress = $shippingAddressLine.",".$shippingCity.",".$shippingProvince.",".$shippingCountry.",".$shippingPostalCode;

            if (isset($_SESSION['fullShippingAddress'])) {
                $_SESSION['fullShippingAddress'] = $fullShippingAddress;
            }
            else {
                $_SESSION['fullShippingAddress'] = $fullShippingAddress;
            }

            if (isset($_SESSION['totalCost']) ) {
                $_SESSION['totalCost'] = $netTotal;
            }
            else {
                $_SESSION['totalCost'] = $netTotal;
            }



            ?>
            </tbody>
        </table>
    </div>
    <div id="orderSummaryCostInfoContainer">
        <div id="orderSummaryCostInfo" class="orderSummaryCostContents">
            <p>Subtotal: $<?php echo $subtotal ?> </p>
            <p>Taxes: $<?php echo $taxTotal ?></p>
            <p id="orderSummary_totalCost">Total Cost: $<?php echo $netTotal ?></p>
            <button type="button" id="editOrderButton">Edit</button>
            <button type="button" id="confirmOrderButton">Confirm</button>
        </div>
    </div>
</main>
<?php include "footer.php"; ?>
</body>
</html>

<script>
    console.log("hit the script tag");

    $('#editOrderButton').click(function() {
        location.replace("http://localhost/the-project-qscu-merch/src/viewcart.php");
    });

    $('#confirmOrderButton').click(function () {
        location.replace("http://localhost/the-project-qscu-merch/src/action/checkout-action.php");

        //call the ajax function which will link to the action php file

    });
</script>
