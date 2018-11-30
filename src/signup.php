<?php
include "includes/init.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/headerFooterHead.php"?>
    <title>Sign-up</title>
    <link rel="stylesheet" href="css/login.css">
    <script type="text/javascript" src="script/client-side-validation.js"></script>



</head>
<body>
<?php include "header.php"?>

<ul class="breadcrumb">
    <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
    <a href="login.php">Login</a> &gt; &gt;
    <a>Sign Up</a>
</ul>
<main>
<div id="forms">

    <form id="signUpForm" method="post" action="action/createUser.php">
        <fieldset>
            <legend id="signUpTitle">Sign-Up</legend>
            <div id="signUpInputElements">
                <div class="SUformElement">
                    <label id="SUfnameLabel" class="signUpLabel" for="fnameInput">First name: </label>
                    <input type="text" name="firstName" id="fnameInput" required>
                </div>

                <div class="SUformElement">
                    <label id="SUlnameLabel" class="signUpLabel" for="lnameInput">Last name: </label>
                    <input type="text" name="lastName" id="lnameInput" required>
                </div>

                <div class="SUformElement">
                    <label id="SUemailLabel" class="signUpLabel" for="signUpEmailInput">Email: </label>
                    <input type="email" name="email" id="signUpEmailInput" required>
                </div>

                <div class="SUformElement">
                    <label id="SUpasswordLabel" class="signUpLabel" for="signUpPasswordInput">Password: </label>
                    <input type="password" name="password" id="signUpPasswordInput" required>
                </div>

                <div class="SUformElement">
                    <label id="SUconfirmPasswordLabel" class="signUpLabel" for="signUpPasswordConfirmationInput">Confirm Password: </label>
                    <input type="password" name="confirmPassword" id="signUpPasswordConfirmationInput" required>
                </div>
            </div>

            <div class="SUformElement">
                <button type="submit">Sign-up</button>
            </div>
        </fieldset>
    </form>
</div>
    <div id="loginLink">
        <p><a href="login.php">Already have an account?</a></p>
    </div>
</main>
<?php include "footer.php"; ?>
</body>
</html>