<?php
include "includes/init.php";

if (!isset($_SESSION['order_placed']) OR $_SESSION['order_placed'] === false) {
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
    <h1>Your order is on its way!</h1>

    <h2>But just in case you missed it, have you seen: </h2>
    <img src="images/orderTruck">
    <!-- put in a fun image -->


</main>
<?php include "footer.php" ?>
</body>
</html>