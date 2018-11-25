<?php
include "includes/init.php";

if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

$email = "";
$firstName = "";
$lastName = "";
$isBanned = "";

$contentType = "";
$profileImage = "";


$address = "";
$city = "";
$province = "";
$country = "";
$postalCode = "";
$hiddenCardNumber = "";
$creditCardNum = "";
$creditCardExpiryDate = "";
$ccv = "";

$mysql;
try {
    $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    if ($mysql->errno) {
        throw new Exception();
    }
    $query = 'SELECT uEmail, fname, lname, contentType, profilePicture, customerBanned FROM User WHERE uid = ?';
    $stmt = $mysql->prepare($query);
    $stmt->bind_param('i', $_SESSION['user']->id);
    $stmt->execute();
    $stmt->bind_result($email1, $firstName1, $lastName1, $contentType1, $profileImage1, $isBanned1);

    $stmt->fetch();

    $email = $email1;
    $firstName = $firstName1;
    $lastName = $lastName1;
    $isBanned = $isBanned1;

    $contentType = $contentType1;
    $profileImage = $profileImage1;
    $stmt->close();

    $query = 'SELECT address, city, province, country, postalCode, creditCardNumber, cardExpiryDate FROM BillingInfo WHERE uid = ?';
    mysqli_report(MYSQLI_REPORT_ALL);
    $stmt = $mysql->prepare($query);
    $stmt->bind_param('i', $_SESSION['user']->id);
    $stmt->execute();
    $stmt->bind_result($address1, $city1, $province1, $country1, $postalCode1, $creditCardNum1, $creditCardExpiryDate1);
    if ($stmt->fetch()) {
        $address = $address1;
        $city = $city1;
        $province = $province1;
        $country = $country1;
        $postalCode = $postalCode1;
        $hiddenCardNumber = $creditCardNum1;
        $creditCardNum = str_repeat('*', strlen($creditCardNum1)) . substr($creditCardNum1, -4);
        $creditCardExpiryDate = $creditCardExpiryDate1;
    }


} catch (Exception $e) {
} finally {
    $mysql->close();
}


$user = $_SESSION['user']->id;
$name = $_SESSION['user']->firstName;
$headerSet = 1;
?>

<!DOCTYPE html>
<html lang="en">
<!--    Head-->

<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/reviewsComments.css">
    <?php include 'includes/headerFooterHead.php' ?>
    <script type="text/javascript" src="script/profile_controller.js"></script>
</head>


<!--    Body-->

<body>
<?php include "header.php" ?>
<main>
    <h2 id="welcome">
        <?php echo "Welcome " . $name . "!"; ?>
    </h2>
    <div id="userProfile">

        <div id="imageContent">
            <!--TODO DO NOT STYLE FORMS-->
            <!--They will not be there when it a admin in on the user page-->

            <!--TODO for brandon make action page-->
            <form method="post" action="action/editUser.php" enctype="multipart/form-data">
              <img id="profileImage"<?php echo 'src="data:' + $contentType + ';base64,' + base64_encode($profileImage)+ '" alt="User Profile Image"';?>>
                <input type="file" value="Upload  Image" name="uploadImage" id="uploadImage" required>
                <input type="hidden" name="action" value="uploadImage">
                <input type="submit" value="Upload">
            </form>
        </div>
        <div id="infoContent">
            <!--TODO DO NOT STYLE FORMS-->
            <!--They will not be there when it a admin in on the user page-->

            <!--TODO for brandon make action page-->
            <div id="personalContent">
                <form method="post" action="action/editUser.php">
                    <fieldset>
                        <legend>Personal Information</legend>
                        <label for="emailInput">Email:</label>
                        <input type="email" id="emailInput" name="emailInput" placeholder="" value="<?php echo $email ?>" readonly>

                        <label for="firstNameInput">First Name:</label>
                        <input type="text" id="firstNameInput" name="firstNameInput" placeholder="" value="<?php echo $firstName ?>" readonly>

                        <label for="lastNameInput">Last Name:</label>
                        <input type="text" id="lastNameInput" name="lastNameInput" placeholder="" value="<?php echo $lastName ?>" readonly>

                        <input type="hidden" name="action" value="userInfo">
                        <input id="infoEditSave" type="button" value="Edit">
                    </fieldset>
                </form>
            </div>
            <div id="passwordContent">
                <form id="passwordContent" method="post" action="action/editUser.php">
                    <fieldset>
                        <legend>Change Password:</legend>
                        <label for="oldPasswordInput">Old Password:</label>
                        <input type="password" id="oldPasswordInput" name="oldPasswordInput" placeholder="*******" readonly>

                        <label for="passwordInput">New Password:</label>
                        <input type="password" id="passwordInput" name="passwordInput" placeholder="*******" readonly>

                        <label for="confirmPasswordInput">Confirm Password:</label>
                        <input type="password" id="confirmPasswordInput" name="confirmPasswordInput" placeholder="*******" readonly>

                        <input type="hidden" name="action" value="changePassword">
                        <input id="passwordEditSave" type="button" value="Edit">
                    </fieldset>
                </form>
            </div>
        </div>

        <div id="billingContent">
            <!--TODO DO NOT STYLE FORMS-->
            <!--They will not be there when it a admin in on the user page-->

            <!--TODO for brandon make action page-->
            <form id="billingLocation" method="post" action="action/editUser.php">
                <fieldset>
                    <legend>Billing Information:</legend>
                    <label for="billingAddressInput">Address Line: </label>
                    <input type="text" name="billingAddress" id="billingAddressInput" maxlength="256" placeholder="" value="<?php echo $address ?>" readonly>

                    <label for="billingCityInput">City: </label>
                    <input type="text" name="billingCity" id="billingCityInput" maxlength="256" placeholder="" value="<?php echo $city ?>" readonly>

                    <label for="billingProvinceInput">Province/State: </label>
                    <select name="billingProvince" id="billingProvinceInput" disabled>
                        <option value="AB"<?php if ($province === 'AB') {
                            echo ' selected';
                        } ?>>AB
                        </option>
                        <option value="BC"<?php if ($province === 'BC') {
                            echo ' selected';
                        } ?>>BC
                        </option>
                        <option value="MB"<?php if ($province === 'MB') {
                            echo ' selected';
                        } ?>>MB
                        </option>
                        <option value="NB"<?php if ($province === 'NB') {
                            echo ' selected';
                        } ?>>NB
                        </option>
                        <option value="NL"<?php if ($province === 'NL') {
                            echo ' selected';
                        } ?>>NL
                        </option>
                        <option value="NS"<?php if ($province === 'NS') {
                            echo ' selected';
                        } ?>>NS
                        </option>
                        <option value="NT"<?php if ($province === 'NT') {
                            echo ' selected';
                        } ?>>NT
                        </option>
                        <option value="NU"<?php if ($province === 'NU') {
                            echo ' selected';
                        } ?>>NU
                        </option>
                        <option value="ON"<?php if ($province === 'ON') {
                            echo ' selected';
                        } ?>>ON
                        </option>
                        <option value="PE"<?php if ($province === 'PE') {
                            echo ' selected';
                        } ?>>PE
                        </option>
                        <option value="QC"<?php if ($province === 'QC') {
                            echo ' selected';
                        } ?>>QC
                        </option>
                        <option value="SK"<?php if ($province === 'SK') {
                            echo ' selected';
                        } ?>>SK
                        </option>
                        <option value="YK"<?php if ($province === 'YK') {
                            echo ' selected';
                        } ?>>YK
                        </option>
                    </select>

                    <!--                    <label for="billingCountryInput">Country: </label>-->
                    <!--                    <input type="text" name="billingCountry" id="billingCountryInput" maxlength="256" placeholder="" readonly>-->

                    <label for="billingPostalCodeInput">Postal Code: </label>
                    <input type="text" name="billingPostalCode" id="billingPostalCodeInput" maxlength="10" placeholder="" value="<?php echo $postalCode ?>" readonly>

                    <label for="cardNumberInput">Credit Card Number:</label>
                    <input class="numberOnly" name="cardNumber" id="cardNumberInput" type="text" maxlength="19" placeholder="" value="<?php echo $creditCardNum ?>" readonly>
                    <input type="hidden" name="hiddenCarNumber" value="<?php echo $hiddenCardNumber?>">

                    <label for="expiryInput">Expiry Date:</label>
                    <input type="month" name="expiryInput" id="expiryInput" value="<?php echo $creditCardExpiryDate ?>" readonly>

                    <label for="securityCodeInput">Security Code:</label>
                    <input class="numberOnly" type="text" name="securityCode" id="securityCodeInput" maxlength="4" placeholder="***" readonly>


                    <input type="hidden" name="action" value="billingInfo">
                    <input id="billingEditSave" type="button" value="Edit">
                </fieldset>
            </form>
        </div>
    </div>

    <div id="reviewsComments">
        <h3>Your Reviews & Comments</h3>

        <!--TODO put this in a include file-->
        <div class="reviewBlock">
            <div class="review">
                <p class="userProfile">
                    <img src="../src/images/profile.png" alt="User's profile picture" align="middle"><a href="#">Parsa
                        R</a>
                    <time datetime="2018-10-24">- October 24, 2018</time>
                </p>
                <p class="userRating">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star "></span>
                    <span class="fa fa-star"></span>
                </p>

                <p class="reviewTitle">
                    Great product!
                </p>
                <p class="reviewDescription">Those are some dank ping pongs!</p>
            </div>
            <div class="comments">
                <div class="comment">
                    <p class="userProfile">
                        <img src="../src/images/profile.png" alt="User's profile picture" align="middle"> Not Parsa R
                        <time datetime="2018-10-30">- October 30, 2018</time>
                    </p>
                    <p class="reviewTitle">
                        Balls
                    </p>
                    <p class="reviewDescription">Its a bunch of balls</p>
                </div>
                <div class="comment">
                    <p class="userProfile">
                        <img src="../src/images/profile.png" alt="User's profile picture" align="middle"> James
                        <time datetime="2018-11-9">- November 9, 2018</time>
                    </p>
                    <p class="reviewTitle">
                        You just don't get it
                    </p>
                    <p class="reviewDescription">Those are some dank zebra eye ping pongs!</p>
                </div>
                <div class="comment">
                    <p class="userProfile">
                        <img src="../src/images/profile.png" alt="User's profile picture" align="middle"> Parsa R
                        <time datetime="2018-10-24">- October 24, 2018</time>
                    </p>
                    <p class="reviewTitle">
                        Great product!
                    </p>
                    <p class="reviewDescription">Those are some dank ping pongs!</p>
                </div>
            </div>
        </div>

        <div class="reviewBlock">
            <p class="userProfile">
                <img src="../src/images/profile.png" alt="User's profile picture" align="middle">User
                Name
                <time datetime="2018-10-24">- Month Day, Year</time>
            </p>
            <p class="userRating">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star "></span>
                <span class="fa fa-star"></span>
            </p>

            <p class="reviewTitle">
                Review Title Here
            </p>
            <p class="reviewDescription">Review Description Here</p>
        </div>

    </div>
</main>
<?php include "footer.php"; ?>
</body>
</html>
