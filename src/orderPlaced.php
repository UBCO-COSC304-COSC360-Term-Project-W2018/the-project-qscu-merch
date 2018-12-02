<?php
include "includes/init.php";

$headerSet = 1;

if ( !isset($_SESSION['order_placed']) OR $_SESSION['order_placed'] === false ) {
    header("Location: homeWithoutTables.php");
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
    <img src="images/truck.jpeg">

    <h1>Your order is on its way!</h1>

    <h3>We appreciate your business here at the QSCU!</h3>
    <p><a href="homeWithoutTables.php">Return Home to More Really Cool Things You Can Buy</a></p>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>


</main>
<?php include "footer.php" ?>
</body>
</html>