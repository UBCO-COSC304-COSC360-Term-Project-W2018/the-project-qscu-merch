<?php
include "includes/init.php";

try {
    $headerSet = 1;

    //TODO: Uncomment this once i merge onto dev
    $user = $_SESSION['user'];
    $userid = $user->id;
//    $_SESSION['userid'] = 1;          //PURELY FOR TESTING

    if (!isset($_SESSION['user'])) {
        header('Location: http://localhost/the-project-qscu-merch/src/login.php');
        exit();
    } else {
        $userid = $_SESSION['userid'];
        echo $userid;
    }

    $firstName = "";
    $lastName = "";
    $fullName = "";
    $addressLine = "";
    $city = "";
    $province = "";
    $country = "";
    $postalcode = "";
    $creditCardName = "";
    $creditCardNum = "";
    $creditCardExpiryDate = "";
    $ccv = "";

    $mysqli = new mysqli (DBHOST, DBUSER, DBPASS, DBNAME);

    if ($mysqli->connect_errno) {
//    echo "<p> Unable to connect to database </p>";
        die();
    } else {
    echo "<p> You are connected to the database</p>";
    }
//get info user info if they exist
    $sql1 = "SELECT * FROM BillingInfo WHERE uid = ?";

    if ($user_billing_info = $mysqli->prepare($sql1)) {
        $user_billing_info->bind_param("s", $userid);
        $user_billing_info->execute();

        echo "<p>getting billing info</p>";

        $result = $user_billing_info->get_result();

        while ($row = $result->fetch_assoc()) {
            $addressLine = $row['address'];
            $city = $row['city'];
            $province = $row['province'];
            $country = $row['country'];
            $postalcode = $row['postalCode'];
            $creditCardNum = $row['creditCardNumber'];
            $creditCardExpiryDate = $row['cardExpiryDate'];
            $ccv = $row['CCV'];
        }
    }
//    echo "<p>".$addressLine."</p>";
//    echo "<p>".$city."</p>";
//    echo "<p>".$province."</p>";
//    echo "<p>".$country."</p>";
//    echo "<p>".$postalcode."</p>";
//    echo "<p>".$creditCardNum."</p>";
//    echo "<p>".$creditCardExpiryDate."</p>";
//    echo "<p>".$ccv."</p>";

    $sql2 = "SELECT fname, lname FROM user WHERE uid= ?";

    if ($user_info = $mysqli->prepare($sql2)) {
        $user_info->bind_param("s", $userid);
        $user_info->execute();

        $result = $user_info->get_result();

        while ($row = $result->fetch_assoc()) {
            $firstName = $row['fname'];
            $lastName = $row['lname'];
        }
    }
    $fullName = $firstName . " " . $lastName;
}

catch (Exception $exception) {
    die();
}
finally {
    $mysqli -> close();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/headerFooterHead.php" ?>
    <!--    always put my own stuff here below include :) -->
    <link rel="stylesheet" href="css/checkout.css">
    <script src="libs/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="script/checkout-validation.js"></script>

    <ul class="breadcrumb">
        <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
        <a href="viewCart.php">Cart</a> &gt; &gt;
        <a href="orderSummary.php">Order Summary</a> &gt; &gt;
        <a>Checkout</a>
    </ul>
</head>

<body>
<?php include "header.php" ?>
<main>
    <form method="post" action="orderSummary.php" id="checkOutForm">

        <fieldset>
            <legend id="checkOutFormTitle">Check Out</legend>

            <div id="checkoutFormElements">
                <div id="checkoutFormInputElements">
                    <div id="creditCardAndBillingAddressContainer">
                        <div id="creditCardElementsContainer">
                            <div id="ccNameContainer" class="checkoutContainer">
                                <label id="ccNameLabel" for="ccName" class="elementLabel">Name on Card: </label>
                                <input type="text" name="ccName" id="ccName" required value="<?php echo $fullName ?>">
                            </div>
                            <div id="ccNumContainer" class="checkoutContainer">
                                <label id="ccNumLabel" for="ccNum" class="elementLabel">Credit Card Number: </label>
                                <input type="number" name="ccNum" id="ccNum" required
                                       value="<?php echo $creditCardNum ?>">
                            </div>

                            <div id="ccExpirationContainer" class="checkoutContainer">
                                <label id="ccExpDateLabel" for="ccExpiration" class="elementLabel">Expiry Date
                                    (MMYY): </label>
                                <input type="text" name="ccExpiration" required id="ccExpiration"
                                       value="<?php echo $creditCardExpiryDate ?>">
                            </div>

                            <div id="ccCCVContainer" class="checkoutContainer">
                                <label id="ccCCVLabel" for="ccCCV" class="elementLabel">CCV: </label>
                                <input type="number" name="ccv" required id="ccCCV" value="<?php echo $ccv ?>">
                            </div>
                        </div>
                        <div id="addressContainer" class="checkoutContainer">
                            <div id="billingAddressContainer">
                                <label id="billingAddressLabel" class="elementLabel">Billing Address: </label>
                                <div id="billingAddress" class="checkoutContainer">
                                    <label class="elementLabel" for="billingAddressInput">Address Line: </label>
                                    <input type="text" name="billingAddress" id="billingAddressInput" required
                                           value="<?php echo $addressLine ?>">
                                </div>

                                <div id="billingCity" class="checkoutContainer">
                                    <label class="elementLabel" for="billingCityInput">City: </label>
                                    <input type="text" name="billingCity" id="billingCityInput" required
                                           value="<?php echo $city ?>">
                                </div>
                                <div id="billingCountry" class="checkoutContainer">
                                    <label class="elementLabel" for="billingCountryInput">Country: </label>
                                    <select name="billingCountry" id="billingCountrySelect">
                                        <option value="Canada">Canada</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canada">Canada</option>
                                    </select>
                                </div>
                                <div id="billingProvince" class="checkoutContainer">
                                    <label class="elementLabel" for="billingProvinceInput">Province/State: </label>
                                    <select name="billingProvince" id="billingProvinceSelect">
                                        <option value="AB">AB</option>
                                        <option value="BC">BC</option>
                                        <option value="MB">MB</option>
                                        <option value="NB">NB</option>
                                        <option value="NL">NL</option>
                                        <option value="NS">NS</option>
                                        <option value="NT">NT</option>
                                        <option value="NU">NU</option>
                                        <option value="ON">ON</option>
                                        <option value="PE">PE</option>
                                        <option value="QC">QC</option>
                                        <option value="SK">SK</option>
                                        <option value="YK">YK</option>
                                    </select>
                                </div>
                                <div id="billingPostalCode" class="checkoutContainer">
                                    <label class="elementLabel" for="billingPostalCodeInput">Postal Code: </label>
                                    <input type="text" name="billingPostalCode" id="billingPostalCodeInput" required
                                           value="<?php echo $postalcode ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="shippingAddressRadioGroup" class="checkoutContainer">
                        <label class="elementLabel" for="shippingAddressRadioGroup">Select a shipping address: </label>
                        <input type="radio" name="shippingAddressRadio" id="billingAddressRadio" checked="checked" value="1">Billing
                        address<br>
                        <input type="radio" name="shippingAddressRadio" id="shippingAddressRadio" value="2">New shipping
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
                            <select name="shippingProvince" id="shippingProvinceSelect">
                                <option value="AB">AB</option>
                                <option value="BC">BC</option>
                                <option value="MB">MB</option>
                                <option value="NB">NB</option>
                                <option value="NL">NL</option>
                                <option value="NS">NS</option>
                                <option value="NT">NT</option>
                                <option value="NU">NU</option>
                                <option value="ON">ON</option>
                                <option value="PE">PE</option>
                                <option value="QC">QC</option>
                                <option value="SK">SK</option>
                                <option value="YK">YK</option>
                            </select>                        </div>

                        <div id="shippingCountry">
                            <label class="elementLabel" for="shippingCountryInput">Country: </label>
                            <select name="shippingCountry" id="shippingCountrySelect">
                                <option value="Canada">Canada</option>
                            </select>
                        </div>
                        <div id="shippingPostalCode">
                            <label class="elementLabel" for="shippingPostalCodeInput">Postal Code: </label>
                            <input type="text" name="shippingPostalCode" id="shippingPostalCodeInput">
                        </div>
                    </div>
                </div>
                <div id="checkoutButtonContainer" class="checkoutContainer">
                    <input type="submit" name="submit" id="checkOutButton" value="Check-Out">
                </div>
            </div>
        </fieldset>
    </form>

    <script>
        $("#billingProvinceSelect").val("<?php echo $province ?>");
        $("#billingCountrySelect").val("<?php echo $country ?>");
    </script>

    <div id="paypalButtonContainer">
        <a href="https://www.paypal.com"><img src="images/paypal-checkout-button.png" alt="checkout using paypal"
                                              id="paypalButton"></a>
    </div>
</main>
<?php include "footer.php"; ?>
</body>
</html>




