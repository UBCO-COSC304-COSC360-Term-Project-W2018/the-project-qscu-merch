<?php
include "includes/init.php";


try {
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user']->id;
        $name = $_SESSION['user']->firstName;
    }
    $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

    if ($con->connect_errno) {
        die("Connection Failed: " . $con->connect_errno);
    }
} catch (Exception $e) {
    die("Error with Cart. Session Terminated.");
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['pNo'])) $pNo = $_GET['pNo'];
  else die("Please use a pNo when connecting to this page."); //TODO do something better in this case. -Jasper
}
$sql = "SELECT pname, AVG(rating) AS rating, image, contentType, description, price FROM Product LEFT JOIN Reviews ON Product.pNo = Reviews.pNo WHERE Product.pNo = ? GROUP BY Product.pNo";
if ($stmt = $con->prepare($sql)) {

    $stmt->bind_param('i', $pNo);
    $stmt->execute();
    $stmt->bind_result($product['pname'],$product['rating'],$product['image'],$product['contentType'],$product['description'],$product['price']);
    $stmt->fetch();

} else {
  die(mysqli_error($con));
}
?>

<!DOCTYPE HTML>
<html>

<!--    Head-->
<head>
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>

    <link rel="stylesheet" href="../src/css/singleProduct.css">
    <?php include 'includes/headerFooterHead.php' ?>
    <script type="text/javascript" src="../src/script/quantity.js"></script>
    <script type="text/javascript" src="../src/script/reviewModal.js"></script>
    <script type="text/javascript" src="../src/script/commentModal.js"></script>

    <link rel="stylesheet" href="css/singleProduct.css">
    <?php include 'includes/headerFooterHead.php'; ?>
    <script type="text/javascript" src="script/quantity.js"></script>
    <script type="text/javascript" src="script/reviewModal.js"></script>
    <!--    <script type="text/javascript" src="../src/script/commentModal.js"></script>-->

  

</head>
<!--    Body-->

<body>

<?php include "header.php";?>
  
    <ul class="breadcrumb">
        <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
        <a href="categorypage.php">Categories</a> &gt; &gt;
        <a>Product</a>
    </ul>

<main>
    <!--    make sure all the files that we update have the same and CORRECT width/height -->
    <div class="bigboi">
        <div class="container">
            <!--        TODO: find product src-->
            <img src="data:<?php echo $product['contentType'];?>;base64,<?php echo base64_encode($product['image']);?>" alt="Product Picture">

            <div class="sideContent">
                <div class="pName" name="pName">
                  <h1 title="<?php echo $product['pname'];?>"><?php echo $product['pname'];?></h1>
                </div>
                <!--rating-->
                <div title="The average rating for this product" class="rating">
                  <p>
                    <!--                    TODO: THIS NEEDS TO BE CHECKED-->
  
                  </p>
                </div>
                <!--description-->
                <div class="pDesc">
                    <h3> Description</h3>
                    <p><?php echo $product['description'];?></p>
                </div>
                <!--quantity counter-->
                <div class="quant">
                    <p>Quantity</p>
                    <!--                    TODO: need to send this somwehere-->
                    <form id='myform' method='POST' action="action/addToCart.php">
                        <input title="Decrease Quantity" type='button' value='-' class='qtyminus' field='quantity'/>
                        <input required type='text' name='quantity' value='' class='qty'/>
                        <input title="Increase Quantity" type='button' value='+' class='qtyplus' field='quantity'/>

                        <!-- added drop down menu -->

                        <select name="size" class="size" required>
                            <option selected value="">Select a size</option>
                            <option value="single">single</option>
                            <option value="one">one</option>
                            <option value="LG">Large (L)</option>
                            <option value="XLG">Extra-Large (XL)</option>
                        </select>

                        <!--                    TODO: Liam needs pName and price -->
                        <?php echo "<input type='hidden' value='1' name='pNo' />" ?>
                        <button type="submit" title="Add to Cart" class="pageButtons">Add to Cart <i class="fa fa-shopping-cart"></i>
                        </button>
                    </form>

                </div>

                <!--            price-->
                <div class="price">



                    <?php


                    $sqlOldPrice = "SELECT price*1.5 AS oldPrice FROM Product";

                    if ($query = $con->query($sqlOldPrice)) {

                        while ($field = $query->fetch_assoc()) {

                            $OldPrice = $field['oldPrice'];

                            echo "<p>Listed Price: <label class=\"oldPrice\">CDN$" . $OldPrice . "</label>";
                        }
                    } else {
                        echo "Error - could not get price.";
                        die();
                    } ?>



<!--    make sure all the files that we update have the same and CORRECT width/height -->
<div class="bigboi">
    <div class="container">
        <img src="../src/images/pingpong.jpg" alt="Product Picture">

        <div class="sideContent">
            <!--            name of product-->
            <div class="pName">
                <h1>Ping Pongs
                </h1>
                <!--                sub-title stuff -->
                <p>3 Balls per pack</p>
                    <?php
                    $sqlPrice = "SELECT price FROM Product";
                    //                    $sqlOldPrice = "SELECT price+100 FROM Product";

                    if ($query = $con->query($sqlPrice)) {

                        while ($field = $query->fetch_assoc()) {

                            $price = $field['price'];

                            echo "<p>Price: <label class=\"sale\">CDN$$price</label>";
                        }
                    } else {
                        echo "Error - could not get price.";
                        die();
                    }
                    ?>

                    <!--                    else  if ($query = $con->query($sqlOldPrice)) {-->
                    <!---->
                    <!--                    while ($field = $query->fetch_assoc()) {-->
                    <!---->
                    <!--                    $OldPrice = $field['price'];-->
                    <!---->
                    <!---->
                    <!---->
                    <!--                        }-->
                    <!--                    <p>Listed Price: <label class="oldPrice">CDN$299.99</label></p>-->

                    <!--                    <p>Price: <label class="sale">CDN$199.99</label>-->


                    </p>
                  <p>Listed Price: <label class="oldPrice"CDN$<?php echo ($product['price']*1.5);?></label></p>
                  <p>Price: <label class="sale">CDN$<?php echo $product['price'];?></label></p>
                </div>
            </div>

        </div>
</main>
<?php
include "footer.php";
?>
