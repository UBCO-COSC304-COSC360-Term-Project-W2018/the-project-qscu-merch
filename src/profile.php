<?php
include "includes/init.php";

if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
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

    $query = 'SELECT address, city, province, country, postalCode, creditCardNumber, cardExpiryDate, CCV FROM BillingInfo WHERE uid = ?';
    mysqli_report(MYSQLI_REPORT_ALL);
    $stmt = $mysql->prepare($query);
    $stmt->bind_param('i', $_SESSION['user']->id);
    $stmt->execute();
    $stmt->bind_result($address1, $city1, $province1, $country1, $postalCode1, $creditCardNum1, $creditCardExpiryDate1, $ccv1);
    if ($stmt->fetch()) {
        $address = $address1;
        $city = $city1;
        $province = $province1;
        $country = $country1;
        $postalCode = $postalCode1;
        $creditCardNum = $creditCardNum1;
        $creditCardExpiryDate = $creditCardExpiryDate1;
        $ccv = $ccv1;
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


    <script src="script/imagePreview.js"></script>

</head>


<!--    Body-->

<body>
<?php include "header.php" ?>

<ul class="breadcrumb">
    <a href="homeWithoutTables.php">Home</a> &gt; &gt;
    <a>Profile</a>
</ul>

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
                <img id="imagePreview"
                     src="<?php echo 'data:' . $contentType . ';base64,' . base64_encode($profileImage) ?>"
                     alt="User Profile Image">
                <input type="file" name="uploadImage" id="uploadImage" required>
                <input type="hidden" name="action" value="uploadImage">
                <input id="uploadButton" type="submit" value="Upload">
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
                        <input type="email" id="emailInput" name="emailInput" placeholder=""
                               value="<?php echo $email ?>" readonly>

                        <label for="firstNameInput">First Name:</label>
                        <input type="text" id="firstNameInput" name="firstNameInput" placeholder=""
                               value="<?php echo $firstName ?>" readonly>

                        <label for="lastNameInput">Last Name:</label>
                        <input type="text" id="lastNameInput" name="lastNameInput" placeholder=""
                               value="<?php echo $lastName ?>" readonly>

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
                        <input type="password" id="oldPasswordInput" name="oldPasswordInput" placeholder="*******"
                               readonly>

                        <label for="passwordInput">New Password:</label>
                        <input type="password" id="passwordInput" name="passwordInput" placeholder="*******" readonly>

                        <label for="confirmPasswordInput">Confirm Password:</label>
                        <input type="password" id="confirmPasswordInput" name="confirmPasswordInput"
                               placeholder="*******" readonly>

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
                    <input type="text" name="billingAddress" id="billingAddressInput" maxlength="256" placeholder=""
                           value="<?php echo $address ?>" readonly>

                    <label for="billingCityInput">City: </label>
                    <input type="text" name="billingCity" id="billingCityInput" maxlength="256" placeholder=""
                           value="<?php echo $city ?>" readonly>

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
                    <input type="text" name="billingPostalCode" id="billingPostalCodeInput" maxlength="10"
                           placeholder="" value="<?php echo $postalCode ?>" readonly>

                    <label for="cardNumberInput">Credit Card Number:</label>
                    <input class="numberOnly" name="cardNumber" id="cardNumberInput" type="password" maxlength="19"
                           placeholder="" value="<?php echo $creditCardNum ?>" readonly>

                    <label for="expiryInput">Expiry Date:</label>
                    <input type="month" name="expiryInput" id="expiryInput" value="<?php echo $creditCardExpiryDate ?>"
                           readonly>

                    <label for="securityCodeInput">Security Code:</label>
                    <input class="numberOnly" type="password" name="securityCode" id="securityCodeInput" maxlength="4"
                           placeholder="***" value="<?php echo $ccv ?>" readonly>


                    <input type="hidden" name="action" value="billingInfo">
                    <input id="billingEditSave" type="button" value="Edit">
                </fieldset>
            </form>
        </div>
    </div>


    <div id="reviewsComments">
        <h3>Your Reviews & Replies:</h3>

        <?php
        //TODO: MAKE SURE THIS ALL WORKS WITH CUURRENT DB, WAS SIZE DROPPED???
        $userid = $_SESSION['user']->id;
        $mysqli;

        //TODO: put this in a try catch before brandon yells at you
        try {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

            //ok so get each review from database
            $get_review_sql = "SELECT * FROM Reviews WHERE uid = ?";

            if ($get_review = $mysqli->prepare($get_review_sql)) {
                $get_review->bind_param("s", $userid);
                $get_review->execute();

                $get_review_result = $get_review->get_result();

                while ($get_review_row = $get_review_result->fetch_assoc()) {
                    $uid = $userid;
                    $pNo = $get_review_row['pNo'];
                    $rating = $get_review_row['rating'];
                    $body = $get_review_row['comment'];
                    $date = $get_review_row['date'];
                    $isEnabled = $get_review_row['isEnabled'];
                    $pname = "";
                    $profile_image = "";
                    $content_type = "";
                    $formatted_date = date("M-d-y H:i:s", strtotime($date));

                    //TODO: Rachelle check if the review disabled. If yes, then ABORT MISSION
                    if ( !$isEnabled ) {
                        continue;
                    }

                    //get name of product
                    $product_name_sql = "SELECT pname FROM Product WHERE pNo = ?";
                    if ($product_name = $mysqli->prepare($product_name_sql)) {
                        $product_name->bind_param("s", $pNo);
                        $product_name->execute();

                        $product_name_result = $product_name->get_result();

                        while ($product_name_row = $product_name_result->fetch_assoc()) {
                            $pname = $product_name_row['pname'];
                        }
                    }

                    $image_details_sql = "SELECT profilePicture, contentType FROM User WHERE uid = ?";
                    if ( $image_details = $mysqli -> prepare($image_details_sql) ) {
                        $image_details -> bind_param("s", $uid);
                        $image_details -> execute();

                        $image_details_result = $image_details -> get_result();

                        while ( $image_details_row = $image_details_result -> fetch_assoc() ) {
                            $profile_image = $image_details_row['profilePicture'];
                            $content_type = $image_details_row['contentType'];
                        }
                    }
        //              src=\"<?php echo 'data:' . $contentType . ';base64,' . base64_encode($profileImage) \"
                    echo $contentType;


                    echo "<div class=\"review\">
                        <p class=\"userProfile\">

                            <img src=\"data:".$contentType. ';base64,' . base64_encode($profileImage)."\" alt=\"User's profile picture\" align=\"middle\">
                            <span>".$firstName." ".$lastName."</span>
                            <span class='time'>".$formatted_date."</span>
                        </p>
                        <p class=\"productName\">".$pname."</p>";

                    echo "<p class=\"userRating\">";
                    for ($x = 0; $x < 5; $x++) {
                        if ($x < $rating) {
                            echo "<span class=\"fa fa-star checked\"></span>";
                        } else {
                            echo "<span class=\"fa fa-star \"></span>";
                        }
                    }
                    echo "</p>
                      <p class=\"reviewDescription\">".$body."</p>
                    </div>";

                    $comment_on_review_sql = "SELECT * FROM Comment WHERE pNo = ? AND uid = ?";
                    if ( $comment_on_review = $mysqli -> prepare($comment_on_review_sql) ) {
                        $comment_on_review -> bind_param("ss", $pNo, $uid);
                        $comment_on_review -> execute();
                        echo "executed statement to get comments";

                        $comment_on_review_result = $comment_on_review -> get_result();

                        while ( $comment_on_review_row = $comment_on_review_result -> fetch_assoc() ) {
                            echo "entered while loop for comment";
                            $left_by = $comment_on_review_row['leftBy'];
                            $comment_date = $comment_on_review_row['date'];
                            $comment_text = $comment_on_review_row['comment'];
                            $comment_enabled = $comment_on_review_row['isEnabled'];
                            $commenter_profile_image = "";
                            $commenter_content_type = "";
                            $commenter_fname = "";
                            $commenter_lname = "";
                            //format date
                            $comment_formatted_date = date("M-d-y H-i-s", strtotime($comment_date));

                            if ( !$comment_enabled ) {
                                continue;
                            }
                            else {
                                //get commenter's first and last name
                                $commenter_name_details_sql = "SELECT fname, lname FROM User WHERE uid = ?";
                                if ( $commenter_name_details = $mysqli -> prepare($commenter_name_details_sql) ) {
                                    $commenter_name_details -> bind_param("s", $left_by);
                                    $commenter_name_details -> execute();

                                    $commenter_name_details_result = $commenter_name_details -> get_result();

                                    while ( $commenter_name_details_row = $commenter_name_details_result -> fetch_assoc() ) {
                                        $commenter_fname = $commenter_name_details_row['fname'];
                                        $commenter_lname = $commenter_name_details_row['lname'];
                                    }
                                }
                                else {
                                    echo "<p>something really went wrong getting the commenter's name lol</p>";
                                }
                                if ( $commenter_image_details = $mysqli -> prepare($image_details_sql) ) {
                                    $commenter_image_details -> bind_param("s", $left_by);
                                    $commenter_image_details -> execute();

                                    $commenter_image_details_result = $commenter_image_details -> get_result();

                                    while ( $commenter_image_details_row = $commenter_image_details_result -> fetch_assoc() ) {
                                        $commenter_profile_image = $commenter_image_details_row['profilePicture'];
                                        $commenter_content_type = $commenter_image_details_row['contentType'];
                                    }
                                }
                                else {
                                    echo "ok something went wrong getting commenter's image yikes lol";
                                }
                                echo "<div class=\"comment\">
                                        <p class=\"userProfile\">
                                            <img src=\"data:".$commenter_content_type.';base64,'.base64_encode($commenter_profile_image)."\" alt=\"User's profile picture\" align=\"middle\">
                                            <span>".$commenter_fname." ".$commenter_lname."</span>
                                            <span class='time'>".$comment_formatted_date."</span>
                                        </p>
                                        <p class=\"reviewDescription\">".$comment_text."</p>
                                  </div>";
                            }

                        }


                    }
                }
            }

            echo "<h3>Your Comments:</h3>";
            //get all comments made by this user.
            //a comment needs:name of user who left, date, profile pic, text
            $get_comment_sql = "SELECT * FROM Comment WHERE leftBy = ?";
            if ( $get_comment = $mysqli -> prepare($get_comment_sql) ) {
                $get_comment -> bind_param("s", $userid);
                $get_comment -> execute();

                $get_comment_result = $get_comment -> get_result();

                while ( $get_comment_row = $get_comment_result -> fetch_assoc() ) {
                    //i already have first and last name
                    $date = $get_comment_row['date'];
                    $text = $get_comment_row['comment'];
                    $enabled = $get_comment_row['isEnabled'];
                    $comment_formatted_date = date("M-d-y H:i:s", strtotime($date));
                    //query for
                    $content_type = $profileImage;
                    $profile_image = $contentType;

                    if ( !$enabled ) {
                        continue;
                    }

                    echo "<div class=\"comment\">
                                        <p class=\"userProfile\">
                            <img src=\"data:".$contentType. ';base64,' . base64_encode($profileImage)."\" alt=\"User's profile picture\" align=\"middle\">
                                            <span>".$firstName." ".$lastName."</span>
                                            <span class='time'>".$comment_formatted_date."</span>
                                        </p>
                                        <p class=\"reviewDescription\">".$text."</p>
                                  </div>";
                }
            }

        }
        catch ( Exception $exception ) {
            header('Location: login.php');
        }
        finally {
            $mysqli -> close();
        }

        ?>



        <!--TODO put this in a include file-->



<!--            <div class="comment">-->
<!--                <p class="userProfile">-->
<!--                    <img src="../src/images/profile.png" alt="User's profile picture" align="middle"> James-->
<!--                    <time datetime="2018-11-9">- November 9, 2018</time>-->
<!--                </p>-->
<!--                <p class="reviewTitle">-->
<!--                    You just don't get it-->
<!--                </p>-->
<!--                <p class="reviewDescription">Those are some dank zebra eye ping pongs!</p>-->
<!--            </div>-->
<!--            <div class="comment">-->
<!--                <p class="userProfile">-->
<!--                    <img src="../src/images/profile.png" alt="User's profile picture" align="middle"> Parsa R-->
<!--                    <time datetime="2018-10-24">- October 24, 2018</time>-->
<!--                </p>-->
<!--                <p class="reviewTitle">-->
<!--                    Great product!-->
<!--                </p>-->
<!--                <p class="reviewDescription">Those are some dank ping pongs!</p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="reviewBlock">-->
<!--        <p class="userProfile">-->
<!--            <img src="../src/images/profile.png" alt="User's profile picture" align="middle">User-->
<!--            Name-->
<!--            <time datetime="2018-10-24">- Month Day, Year</time>-->
<!--        </p>-->
<!--        <p class="userRating">-->
<!--            <span class="fa fa-star checked"></span>-->
<!--            <span class="fa fa-star checked"></span>-->
<!--            <span class="fa fa-star checked"></span>-->
<!--            <span class="fa fa-star "></span>-->
<!--            <span class="fa fa-star"></span>-->
<!--        </p>-->
<!---->
<!--        <p class="reviewTitle">-->
<!--            Review Title Here-->
<!--        </p>-->
<!--        <p class="reviewDescription">Review Description Here</p>-->
<!--    </div>-->
<!--        <h3>Your Reviews & Comments</h3>-->
<!--        -->
<!--            <!--TODO put this in a include file-->
<!--            <div class="reviewBlock">-->
<!--                <div class="review">-->
<!--                    <p class="userProfile">-->
<!--                        <img src="../src/images/profile.png" alt="User's profile picture" align="middle"><a href="#">Parsa-->
<!--                            R</a>-->
<!--                        <time datetime="2018-10-24">- October 24, 2018</time>-->
<!--                    </p>-->
<!--                    <p class="userRating">-->
<!--                        <span class="fa fa-star checked"></span>-->
<!--                        <span class="fa fa-star checked"></span>-->
<!--                        <span class="fa fa-star checked"></span>-->
<!--                        <span class="fa fa-star "></span>-->
<!--                        <span class="fa fa-star"></span>-->
<!--                    </p>-->
<!---->
<!--                    <p class="reviewTitle">-->
<!--                        Great product!-->
<!--                    </p>-->
<!--                    <p class="reviewDescription">Those are some dank ping pongs!</p>-->
<!--                </div>-->
<!--                <div class="comments">-->
<!--                    <div class="comment">-->
<!--                        <p class="userProfile">-->
<!--                            <img src="../src/images/profile.png" alt="User's profile picture" align="middle"> Not Parsa R-->
<!--                            <time datetime="2018-10-30">- October 30, 2018</time>-->
<!--                        </p>-->
<!--                        <p class="reviewTitle">-->
<!--                            Balls-->
<!--                        </p>-->
<!--                        <p class="reviewDescription">Its a bunch of balls</p>-->
<!--                    </div>-->
<!--                    <div class="comment">-->
<!--                        <p class="userProfile">-->
<!--                            <img src="../src/images/profile.png" alt="User's profile picture" align="middle"> James-->
<!--                            <time datetime="2018-11-9">- November 9, 2018</time>-->
<!--                        </p>-->
<!--                        <p class="reviewTitle">-->
<!--                            You just don't get it-->
<!--                        </p>-->
<!--                        <p class="reviewDescription">Those are some dank zebra eye ping pongs!</p>-->
<!--                    </div>-->
<!--                    <div class="comment">-->
<!--                        <p class="userProfile">-->
<!--                            <img src="../src/images/profile.png" alt="User's profile picture" align="middle"> Parsa R-->
<!--                            <time datetime="2018-10-24">- October 24, 2018</time>-->
<!--                        </p>-->
<!--                        <p class="reviewTitle">-->
<!--                            Great product!-->
<!--                        </p>-->
<!--                        <p class="reviewDescription">Those are some dank ping pongs!</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div class="reviewBlock">-->
<!--                <p class="userProfile">-->
<!--                    <img src="../src/images/profile.png" alt="User's profile picture" align="middle">User-->
<!--                    Name-->
<!--                    <time datetime="2018-10-24">- Month Day, Year</time>-->
<!--                </p>-->
<!--                <p class="userRating">-->
<!--                    <span class="fa fa-star checked"></span>-->
<!--                    <span class="fa fa-star checked"></span>-->
<!--                    <span class="fa fa-star checked"></span>-->
<!--                    <span class="fa fa-star "></span>-->
<!--                    <span class="fa fa-star"></span>-->
<!--                </p>-->
<!---->
<!--                <p class="reviewTitle">-->
<!--                    Review Title Here-->
<!--                </p>-->
<!--                <p class="reviewDescription">Review Description Here</p>-->
<!--            </div>-->

    </div>
</main>
<?php include "footer.php"; ?>
</body>
</html>

<!---->
<!--<div id="reviewsComments">-->
<!--    <h3>Your Reviews & Comments</h3>-->
<!---->
<!--    <!--TODO put this in a include file-->-->
<!--    <div class="reviewBlock">-->
<!--        <div class="review">-->
<!--            <p class="userProfile">-->
<!--                <img src="../src/images/profile.png" alt="User's profile picture" align="middle"><a href="#">Parsa-->
<!--                    R</a>-->
<!--                <time datetime="2018-10-24">- October 24, 2018</time>-->
<!--            </p>-->
<!--            <p class="userRating">-->
<!--                <span class="fa fa-star checked"></span>-->
<!--                <span class="fa fa-star checked"></span>-->
<!--                <span class="fa fa-star checked"></span>-->
<!--                <span class="fa fa-star "></span>-->
<!--                <span class="fa fa-star"></span>-->
<!--            </p>-->
<!---->
<!--            <p class="reviewTitle">-->
<!--                Great product!-->
<!--            </p>-->
<!--            <p class="reviewDescription">Those are some dank ping pongs!</p>-->
<!--        </div>-->
<!--        <div class="comments">-->
<!--            <div class="comment">-->
<!--                <p class="userProfile">-->
<!--                    <img src="../src/images/profile.png" alt="User's profile picture" align="middle"> Not Parsa R-->
<!--                    <time datetime="2018-10-30">- October 30, 2018</time>-->
<!--                </p>-->
<!--                <p class="reviewTitle">-->
<!--                    Balls-->
<!--                </p>-->
<!--                <p class="reviewDescription">Its a bunch of balls</p>-->
<!--            </div>-->
<!--            <div class="comment">-->
<!--                <p class="userProfile">-->
<!--                    <img src="../src/images/profile.png" alt="User's profile picture" align="middle"> James-->
<!--                    <time datetime="2018-11-9">- November 9, 2018</time>-->
<!--                </p>-->
<!--                <p class="reviewTitle">-->
<!--                    You just don't get it-->
<!--                </p>-->
<!--                <p class="reviewDescription">Those are some dank zebra eye ping pongs!</p>-->
<!--            </div>-->
<!--            <div class="comment">-->
<!--                <p class="userProfile">-->
<!--                    <img src="../src/images/profile.png" alt="User's profile picture" align="middle"> Parsa R-->
<!--                    <time datetime="2018-10-24">- October 24, 2018</time>-->
<!--                </p>-->
<!--                <p class="reviewTitle">-->
<!--                    Great product!-->
<!--                </p>-->
<!--                <p class="reviewDescription">Those are some dank ping pongs!</p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="reviewBlock">-->
<!--        <p class="userProfile">-->
<!--            <img src="../src/images/profile.png" alt="User's profile picture" align="middle">User-->
<!--            Name-->
<!--            <time datetime="2018-10-24">- Month Day, Year</time>-->
<!--        </p>-->
<!--        <p class="userRating">-->
<!--            <span class="fa fa-star checked"></span>-->
<!--            <span class="fa fa-star checked"></span>-->
<!--            <span class="fa fa-star checked"></span>-->
<!--            <span class="fa fa-star "></span>-->
<!--            <span class="fa fa-star"></span>-->
<!--        </p>-->
<!---->
<!--        <p class="reviewTitle">-->
<!--            Review Title Here-->
<!--        </p>-->
<!--        <p class="reviewDescription">Review Description Here</p>-->
<!--    </div>-->
<!---->
<!--</div>-->
