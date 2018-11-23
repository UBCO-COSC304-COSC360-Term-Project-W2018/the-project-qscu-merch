<?php
//session has to be first in the file
include "includes/session.php";

if(isset($_SESSION["userId"])){
    header("location: profile.php");
}

$errorType;
$error;

if(isset($_SESSION['hasError'])){
    $errorType = $_SESSION['errorType'];
    $error = $_SESSION['error'];
}
$headerSet = 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login/Sign-up</title>
    <? include 'includes/headerFooterHead.php'?>
    <link rel="stylesheet" href="css/login.css">
    <script type="text/javascript" src="script/client-side-validation.js"></script>


</head>
<body>
<?include "header.php"; ?>
<main>
<div id="forms">
    <form id="loginForm" method="post" action="action/getLogin.php">
        <fieldset>
            <legend id="loginTitle">Login</legend>
            <div id="loginFormInputElements">
                <div class="loginFormElements">
                    <label id="loginEmailLabel" class="loginLabel">Email: </label>
                    <input type="email" name="email" id="loginEmailInput" placeholder="your@email.com" required>
                </div>

                <div class="loginFormElement">
                    <label id="loginPasswordLabel" class="loginLabel">Password: </label>
                    <input type="password" name="password" id="loginPasswordInput" placeholder="********" required>
                </div>
            </div>
            <div class="loginFormElement">
                <button type="submit" id="loginSubmitButton">Login</button>
            </div>

            <div class="loginFormElement">
                <a href="#">Forgot Password?</a>
            </div>
        </fieldset>
    </form>

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
</main>
<?php include "footer.php"; ?>
</body>
</html>

