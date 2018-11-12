
<?php
include "init.php";
include "header.php";
?>
<?php
/**
 * Created by PhpStorm.
 * User: Rachelle
 * Date: 2018-11-11
 * Time: 3:58 PM
 */

$uid;
$firstName="";
$lastName="";
$fullName="";
$addressLine="";
$city="";
$province="";
$country="";
$postalcode="";
$creditCardName="";
$creditCardNum="";
$creditCardExpiryDate="";
$ccv="";

$con = mysqli_connect("localhost", "40215162", "qscu42069!", "db_40215162");

if ( mysqli_connect_errno()) {
    echo "Failed to connect to MySQL";
}

$sql1 = "SELECT * FROM BillingInfo WHERE uid=".$uid;
if ($result = mysqli_query($con, $sql1)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $addressLine = $row['addressLine'];
        $city = $row['city'];
        $province = $row['province'];
        $country = $row['country'];
        $postalcode = $row['postalCode'];
        $creditCardNum = $row['creditCardNumber'];
        $creditCardExpiryDate = $row['cardExpiryDate'];
        $ccv = $row['CCV'];
    }
}

$sql2 = "SELECT fname, lname FROM User WHERE uid=".$uid;
if ($result = mysqli_query($con, $sql2)) {
    while($row = mysqli_fetch_row($result)) {
        $firstName = $row['fname'];
        $lastName = $row['lname'];
    }
}
$fullName = $firstName." ".$lastName;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check-Out</title>
    <script src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script type="text/javascript" src="libs/jquery-3.3.1.min.js">\x3C/script>')
    </script>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/checkout.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="icon" type="image/x-icon" href="images/QSCU_favicon.png"/>
    <script type="text/javascript" src="script/checkout-validation.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="icon" type="image/x-icon" href="images/QSCU_favicon.png"/>
    <link rel="stylesheet" href="css/footer.css">
</head>

<body>
<main>
    <form method="post" action="http://www.randyconnolly.com/tests/process.php" id="checkOutForm">

        <fieldset>
            <legend id="checkOutFormTitle">Check Out</legend>

            <div id="checkoutFormElements">
                <div id="checkoutFormInputElements">
                    <div id="creditCardElementsContainer">
                        <div id="ccNameContainer" class="checkoutContainer">
                            <label id="ccNameLabel" for="ccName" class="elementLabel">Name on Card: </label>
                            <input type="text" name="ccName" id="ccName" required <?php echo "value=".$fullName ?>>
                        </div>
                        <div id="ccNumContainer" class="checkoutContainer">
                            <label id="ccNumLabel" for="ccNum" class="elementLabel">Credit Card Number: </label>
                            <input type="number" name="ccNum" id="ccNum" required <?php echo "value=".$creditCardNum?>>
                        </div>

                        <div id="ccExpirationContainer" class="checkoutContainer">
                            <label id="ccExpDateLabel" for="ccExpiration" class="elementLabel">Expiry Date
                                (MMYY): </label>
                            <input type="text" name="ccExpiration" required id="ccExpiration" <?php echo "value=".$creditCardExpiryDate?>>
                        </div>

                        <div id="ccCCVContainer" class="checkoutContainer">
                            <label id="ccCCVLabel" for="ccCCV" class="elementLabel">CCV: </label>
                            <input type="number" name="ccv" required id="ccCCV" <?php "value=".$ccv ?>>
                        </div>
                    </div>
                    <div id="addressContainer" class="checkoutContainer">
                        <div id="billingAddressContainer" class="checkoutContainer">
                            <label id="billingAddressLabel" class="elementLabel">Billing Address: </label>
                            <div id="billingAddress">
                                <label class="elementLabel" for="billingAddressInput">Address Line: </label>
                                <input type="text" name="billingAddress" id="billingAddressInput" required <?php echo "value=".$addressLine ?>>
                            </div>

                            <div id="billingCity">
                                <label class="elementLabel" for="billingCityInput">City: </label>
                                <input type="text" name="billingCity" id="billingCityInput" required <?php echo "value=".$city ?>>
                            </div>

                            <div id="billingProvince">
                                <label class="elementLabel" for="billingProvinceInput">Province/State: </label>
                                <input type="text" name="billingProvince" id="billingProvinceInput" required <?php echo "value=".$province ?>>
                            </div>
                            <div id="billingCountry">
                                <label class="elementLabel" for="billingCountryInput">Country: </label>
                                <input type="text" name="billingCountry" id="billingCountryInput" required <?php echo "value=".$country ?>>
                            </div>

                            <div id="billingPostalCode">
                                <label class="elementLabel" for="billingPostalCodeInput">Postal Code: </label>
                                <input type="text" name="billingPostalCode" id="billingPostalCodeInput" required <?php echo "value=".$postalcode ?>>
                            </div>
                        </div>
                    </div>
                    <div id="shippingAddressRadioGroup">
                        <label class="elementLabel" for="shippingAddressRadioGroup">Select a shipping address: </label>
                        <input type="radio" name="shippingAddress" id="billingAddressRadio" checked="checked" value="1">Billing
                        address<br>
                        <input type="radio" name="shippingAddress" id="shippingAddressRadio" value="2">New shipping
                        address <br>
                    </div>
                    <!-- note these inputs do not have required class -->
                    <div id="shippingAddressContainer" class="checkoutContainer">
                        <div id="shippingAddress">
                            <label class="elementLabel">New Shipping Address:</label>
                            <label class="elementLabel" for="shippingAddressInput">Address Line: </label>
                            <input type="text" name="shippingAddress" id="shippingAddressInput">
                        </div>

                        <div id="shippingCity">
                            <label class="elementLabel" for="shippingCityInput">City: </label>
                            <input type="text" name="shippingCity" id="shippingCityInput">
                        </div>

                        <div id="shippingProvince">
                            <label class="elementLabel" for="shippingProvinceInput">Province/State: </label>
                            <input type="text" name="shippingProvince" id="shippingProvinceInput">
                        </div>

                        <div id="shippingCountry">
                            <label class="elementLabel" for="shippingCountryInput">Country: </label>
                            <input type="text" name="shippingCountry" id="shippingCountryInput">
                        </div>

                        <div id="shippingPostalCode">
                            <label class="elementLabel" for="shippingPostalCodeInput">Postal Code: </label>
                            <input type="text" name="shippingPostalCode" id="shippingPostalCodeInput">
                        </div>
                    </div>
                </div>
                <div id="checkoutButtonContainer" class="checkoutContainer">
                    <!--<button type="submit" id="checkOutButton">Confirm</button>-->
                    <input type="submit" id="checkOutButton">
                </div>
            </div>
        </fieldset>
    </form>

    <div id="paypalButtonContainer">
        <a href="https://www.paypal.com"><img src="images/paypal-checkout-button.png" alt="checkout using paypal"
                                              id="paypalButton"></a>
    </div>
</main>
</body>
</html>
<?php
include "footer.php";
?>

