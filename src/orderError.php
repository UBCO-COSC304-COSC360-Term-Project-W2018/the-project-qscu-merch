<?php
include "includes/init.php";

if (!isset($_SESSION['order_error']) OR $_SESSION['order_error'] === false) {
    header('Location: homeWithoutTables.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/headerFooterHead.php" ?>
    <!--    always put my own stuff here below include :) -->

</head>

<body>
<?php include "header.php" ?>
<main>
    <p>Our apologies! We do not have the products that you want to order in our inventory</p>
    <p><a href=\"../homeWithoutTables.php\">Return Home</a></p>
    <img style="max-width: 50%;" src="resources/yikes-shrug.gif">
</main>
<?php include "footer.php"; ?>
</body>
</html>

