<?php
include "includes/init.php";
$headerSet = 1;

$_SESSION['userid']=1;

if (!isset($_SESSION['userid'])) {
    header('Location: http://localhost/the-project-qscu-merch/src/login.php');
    exit();
}
else {
    $userid = $_SESSION['userid'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/headerFooterHead.php"?>
    <!--    always put my own stuff here below include :) -->
    <link rel="stylesheet" href="css/checkout.css">
    <script type="text/javascript" src="script/checkout-validation.js"></script>
</head>

<body>
<?php include "header.php"?>
<main>
<h1>Your Order:</h1>
    <div id = "userOrderTable">
        <table>
            <tr>
                <th>Quantity</th>
                <th>Product</th>
                <th>Size</th>
                <th>Price</th>
            </tr>
            <?php
            $cartTwoDimArray = array();

            $mysqli = new mysqli ("localhost", "rachellegelden", "rachelle", "qscurachelle");

            $sql = "SELECT hascart.quantity, product.pname, hascart.size, product.price ".
                "FROM hascart JOIN product ON hascart.pno = product.pno AND hascart.size = product.size ".
                "WHERE hascart.uid = ?";

            if ( $user_cart = $mysqli -> prepare($sql)) {
                $user_cart -> bind_param("s", $userid);
                $user_cart -> execute();

                $result = $user_cart -> get_result();

                $count = 0;
                while ( $row = $result -> fetch_assoc() ) {
                    $quantity = $row['quantity'];
                    $product_name = $row['pname'];
                    $size = $row['size'];
                    $price = $row['price'];

                    $total_price = $price * $quantity;

                    $cartTwoDimArray[$count] = array( 'quantity' => $quantity, 'productName' => $product_name,
                        'size' => $size, 'totalPrice' => $total_price);
                    $count = $count + 1;
                }

                foreach ($cartTwoDimArray as $item) {
                    echo "<tr>
                            <td>".$item['quantity']."</td>
                            <td>".$item['productName']."</td>
                            <td>".$item['size']."</td>
                            <td>".$item['totalPrice']."</td>                           
                        </tr>";
                }
            }
            ?>
        </table>
    </div>
</main>
<?php include "footer.php"; ?>
</body>
</html>
