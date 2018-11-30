<?php
include "includes/init.php";

if (isset($_SESSION['user'])) {
    header('location: profile.php');
}

$errorType;
$error;

if(isset($_SESSION['hasError'])){
    $errorType = $_SESSION['errorType'];
    $error = $_SESSION['error'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <?php include 'includes/headerFooterHead.php';?>
    <link rel="stylesheet" href="css/login.css">
    <script type="text/javascript" src="libs/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="script/forgot-password-validation.js"></script>
</head>
<body>
<?php include "header.php"; ?>
<ul class="breadcrumb">
	<a href = "homeWithoutTables.php">Home</a> &gt; &gt;
	<a href = "login.php">Login</a> &gt; &gt;
	<a>Forgot Password</a>
</ul>
<main>
<div id="forms">
    <form id="passForgetForm" method="post">
        <fieldset>
            <legend id="loginTitle">Forgot Password</legend>
			<div id="statusHolder"></div>
            <div id="loginFormInputElements">
                <div class="loginFormElements">
                    <label id="loginEmailLabel" class="loginLabel">Email: </label>
                    <input type="email" name="email" id="forgetPassEmailInput" placeholder="your@email.com" required>
                </div>
            </div>
            <div class="loginFormElement">
                <button id="sendResetEmailButton">Send Reset Email</button>
            </div>

            <div class="loginFormElement">
                <a href="login.php">&lt; Back to login</a>
            </div>
        </fieldset>
    </form>
</div>
    <div id="createAccountLink">
        <p><a href="signup.php">Don't have an account?</a></p>
    </div>
</main>
<?php include "footer.php"; ?>
</body>
</html>

