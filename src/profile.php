<?php 

$headerSet = 1;
include "includes/init.php";
include "header.php";
//$user = (isset($_SESSION["userId"]) ? $_SESSION["userId"] : null;
$name = isset($_SESSION["fName"])? $_SESSION["fName"]: null;


try{

$user = isset($_SESSION["userId"])? $_SESSION['userId']: null;

$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($con -> connect_errno){
	die("Connection Failed: ".$con -> connect_errno);
}


}
catch (Exception $e) {
	die("Error with Cart. Session Terminated.");
}
?>
<!DOCTYPE html>
<html lang="en">
<!--    Head-->

<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/reviewsComments.css">
	<?php include 'includes/headerFooterHead.php'?>
    <script type="text/javascript" src="script/profile_controller.js"></script>
</head>


<!--    Body-->

<body>

<main>
	<h2 id="welcome">
	     <?php echo "Welcome " . $name . "!"; ?>
	</h2>
    <div id="userProfile">
	    
        <div id="imageContent">
            <!--TODO DO NOT STYLE FORMS-->
            <!--They will not be there when it a admin in on the user page-->

            <!--TODO for brandon make action page-->
            <form method="post" action="">
	           
                <img id="profileImage" src="images/profile.png">
                <input type="file" value="Upload  Image">
	
            </form>
        </div>
        <div id="infoContent">
            <!--TODO DO NOT STYLE FORMS-->
            <!--They will not be there when it a admin in on the user page-->

            <!--TODO for brandon make action page-->
            <div id="personalContent">
	            <form>
	                <fieldset>
	                    <legend>Personal Information</legend>
	                    <label for="emailInput">Email:</label>
	                    <input type="email" id="emailInput" name="emailInput" placeholder="" readonly>
	
	                    <label for="firstNameInput">First Name:</label>
	                    <input type="text" id="firstNameInput" name="firstNameInput" placeholder="" readonly>
	
	                    <label for="lastNameInput">Last Name:</label>
	                    <input type="text" id="lastNameInput" name="lastNameInput" placeholder="" readonly>
	
	                    <input id="infoEditSave" type="button" value="Edit">
	                </fieldset>
	            </form>
            </div>
			<div id="passwordContent">
	            <form id="passwordContent">
	                <fieldset>
	                    <legend>Change Password:</legend>
	                    <label for="passwordInput">New Password:</label>
	                    <input type="password" id="passwordInput" name="passwordInput" readonly>
	
	                    <label for="confirmPasswordInput">Confirm Password:</label>
	                    <input type="password" id="confirmPasswordInput" name="confirmPasswordInput" readonly>
	
	                    <input id="passwordEditSave" type="button" value="Edit">
	                </fieldset>
	            </form>
			</div>
        </div>

        <div id="billingContent">
            <!--TODO DO NOT STYLE FORMS-->
            <!--They will not be there when it a admin in on the user page-->

            <!--TODO for brandon make action page-->
            <form id="billingLocation" method="post">
                <fieldset>
                    <legend>Billing Information:</legend>
                    <label for="billingAddressInput">Address Line: </label>
                    <input type="text" name="billingAddressInput" id="billingAddressInput" maxlength="256" placeholder="" readonly>

                    <label for="billingCityInput">City: </label>
                    <input type="text" name="billingCity" id="billingCityInput" maxlength="256" placeholder="" readonly>

                    <label for="billingProvinceInput">Province/State: </label>
                    <input type="text" name="billingProvince" id="billingProvinceInput" maxlength="256" placeholder="" readonly>

                    <label for="billingCountryInput">Country: </label>
                    <input type="text" name="billingCountry" id="billingCountryInput" maxlength="256" placeholder="" readonly>

                    <label for="billingPostalCodeInput">Postal Code: </label>
                    <input type="text" name="billingPostalCode" id="billingPostalCodeInput" maxlength="10" placeholder="" readonly>

                    <label for="cardNumberInput">Credit Card Number:</label>
                    <input class="numberOnly" id="cardNumberInput" type="text" name="cardNumberInput" maxlength="19" placeholder="" readonly>

                    <label for="expiryInput">Expiry Date:</label>
                    <input id="expiryInput" type="month" name="expiryInput" value="2018-05" readonly>

                    <label for="securityCodeInput">Security Code:</label>
                    <input class="numberOnly" id="securityCodeInput" type="text" form="securityCodeInput" maxlength="4" placeholder="***" readonly>

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
                <img src="../src/images/profile.png" alt="User's profile picture" align="middle"><a href="#">Parsa R</a>
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
                    <img src="../src/images/profile.png" alt="User's profile picture" align="middle">	Not Parsa R
                    <time datetime="2018-10-30">- October 30, 2018</time>
                </p>
                <p class="reviewTitle">
                    Balls
                </p>
                <p class="reviewDescription">Its a bunch of balls</p>
                </div>
                <div class="comment">
                    <p class="userProfile">
                        <img src="../src/images/profile.png" alt="User's profile picture" align="middle">	James
                        <time datetime="2018-11-9">- November 9, 2018</time>
                    </p>
                    <p class="reviewTitle">
                        You just don't get it
                    </p>
                    <p class="reviewDescription">Those are some dank zebra eye ping pongs!</p>
                </div>
                <div class="comment">
                    <p class="userProfile">
                        <img src="../src/images/profile.png" alt="User's profile picture" align="middle">	Parsa R
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
</body>
</html>
<?php
include "footer.php";
?>
