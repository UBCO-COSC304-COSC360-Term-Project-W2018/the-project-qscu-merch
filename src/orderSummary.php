<?php
include "includes/init.php";

$province = $_POST['billingProvince'];
$headerSet = 1;

$_SESSION['userid'] = 1;

if (!isset($_SESSION['userid'])) {
    header('Location: http://localhost/the-project-qscu-merch/src/login.php');
    exit();
} else {
    $userid = $_SESSION['userid'];
}

//use $_POST to get the right info

if (isset($_POST['shippingAddressRadio'])) {
    echo "<p>".$_POST['shippingAddressRadio']."</p>";
    echo "say what";
}
else {
    echo "<p>it didn't work</p>";
}
echo "<p>hellooooooooo</p>";
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

            $mysqli = new mysqli ("localhost", "rachellegelden", "rachelle", "qscurachelle");

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
            switch ($province) {
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

            $taxTotal = number_format((float)($total_price * $tax), 2, '.', '');
            $netTotal = number_format((float)($subtotal + $taxTotal), 2, '.', '');
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
        // location.replace("http://localhost/the-project-qscu-merch/src/action/checkout-action.php");
        <?php echo "<p>hello</p>" ?>

        //call the ajax function which will link to the action php file

    });
</script>
