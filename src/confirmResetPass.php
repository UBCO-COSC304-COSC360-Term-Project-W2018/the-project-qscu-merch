<?php
include("includes/init.php");
$valid = false;
if(isset($_GET['uid'])&&isset($_GET['token'])){
    try {
		
		$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
		
		if (!$con||$con->connect_errno) {
			die("Connection Failed: " . $con->connect_errno);
		}
		
		$uid = sanitizeInput($_GET['uid']);
		$token = sanitizeInput($_GET['token']);
		
		$sql = "SELECT uid FROM User WHERE uid = ? AND authToken = ? LIMIT 1";
		if ($stmt = $con->prepare($sql)) {
			
			$stmt->bind_param('is', $uid, $token);
			$stmt->execute();
			$stmt->bind_result($uido);
			while($stmt->fetch()) {
				$valid = true;
			}
			
		} else {
			echo mysqli_error($con);
		}
	} catch (Exception $e) {
		
	}
	
} else {
	header("Location: homeWithoutTables.php");
}

$headerSet = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <?php include 'includes/headerFooterHead.php';?>
    <link rel="stylesheet" href="css/login.css">
    <script type="text/javascript" src="libs/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="script/forgot-password-validation.js"></script>
</head>
<body>
<?php include "header.php"; ?>
<ul class="breadcrumb">
	<a href = "homeWithoutTables.php">Home</a> &gt; &gt;
	<a>New Password</a>
</ul>
<main>
<div id="forms">
    <form id="newPassForm" method="post" action="action/editUser.php"><!--TODO: give this form an action that can nicely update a user's password -->
        <fieldset>
            <legend id="loginTitle">Reset Password</legend>
			<?php if (!$valid):?>
			<p>Unforunately, this token is invalid.</p>
			<?php else:?>
			<div id="statusHolder"></div>
            <div id="loginFormInputElements">
                <div class="SUformElement">
                    <label id="SUpasswordLabel" class="signUpLabel" for="signUpPasswordInput">Password: </label>
                    <input type="password" name="password" id="signUpPasswordInput" required>
                </div>

                <div class="SUformElement">
                    <label id="SUconfirmPasswordLabel" class="signUpLabel" for="signUpPasswordConfirmationInput">Confirm Password: </label>
                    <input type="password" id="signUpPasswordConfirmationInput" required>
                </div>
            </div>
            <div class="loginFormElement">
				<input type="hidden" name="action" value="changePassword" required>
				<input type="hidden" name="uid" value="<?php echo $uid;?>" required>
				<input type="hidden" name="authToken" value="<?php echo $token;?>" required>
                <button type="submit">Save Password</button>
            </div>
			<?php endif;?>
            <div class="loginFormElement">
                <a href="login.php">&lt; Back to login</a>
            </div>
        </fieldset>
    </form>
</div>
</main>
<?php include "footer.php"; ?>
</body>
</html>