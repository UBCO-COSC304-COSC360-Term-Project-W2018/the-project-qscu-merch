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
$sql = "SELECT pname, image, contentType, price FROM Product WHERE Product.pNo = ? GROUP BY Product.pNo";
if ($stmt = $con->prepare($sql)) {

    $stmt->bind_param('i', $pNo);
    $stmt->execute();
    $stmt->bind_result($product['pname'],$product['image'],$product['contentType'],$product['price']);
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
    <link rel="stylesheet" href="css/singleProduct.css">
    <?php include 'includes/headerFooterHead.php'; ?>
    <script type="text/javascript" src="script/quantity.js"></script>
    <script type="text/javascript" src="script/addToCart.js"></script>
    
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
                </div>
                <!--quantity counter-->
                <div class="quant">
                    <p>Quantity</p>
                    <!--                    TODO: need to send this somwehere-->
                    <form id='myform'>
                        <input title="Decrease Quantity" type='button' value='-' class='qtyminus' field='quantity'/>
                        <input required id='quantity' type='text' name='quantity' value='' class='qty'/>
                        <input title="Increase Quantity" type='button' value='+' class='qtyplus' field='quantity'/>

                        <!-- added drop down menu -->

                        <select id='size' name="size" class="size" required>
                            <option selected value="">Select a size</option>
                            <option value="single">single</option>
                            <option value="one">one</option>
                            <option value="LG">Large (L)</option>
                            <option value="XLG">Extra-Large (XL)</option>
                        </select>

                        <!--                    TODO: Liam needs pName and price -->
                        <?php echo "<input id='pNo' type='hidden' value='1' name='pNo'>" ?>
                        <button id='addToCartButton' title="Add to Cart" class="pageButtons">Add to Cart <i class="fa fa-shopping-cart"></i>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>

<?php
include "footer.php";
?>
