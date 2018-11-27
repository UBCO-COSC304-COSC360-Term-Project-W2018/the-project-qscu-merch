<?php
$headerSet = 0;
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
    $pNo = $_GET['pNo'];
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

  
  <ul class="breadcrumb">
        <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
        <a href="categorypage.php">Categories</a> &gt; &gt;
        <a>Product</a>
    </ul>
</head>
<!--    Body-->

<body>
	<?php include "header.php"; ?>
<main>
    <!--    make sure all the files that we update have the same and CORRECT width/height -->
    <div class="bigboi">
        <div class="container">
            <!--        TODO: find product src-->
            <img src="../src/images/pingpong.jpg" alt="Product Picture">

            <div class="sideContent">
                <div class="pName" name="pName">
                    <!--                    name of product - THIS WORKS!-->
                    <?php

                    $sql = "SELECT pname FROM Product WHERE pNo = ?";

                    if ($stmt = $con->prepare($sql)) {

                        $stmt->bind_param('i', $pNo);
                        $stmt->execute();
                        $stmt->bind_result($pname);
                        while ($stmt->fetch()) {

                            echo " <h1 title=' " . $pname . " ' >" . $pname . "</h1>";
                        }
                    } else {

                    }
                    ?>
                </div>
                <!--rating-->
                <div title="The average rating for this product" class="rating">


                    <!--                    TODO: THIS NEEDS TO BE CHECKED-->
                    <?php

                    $sql = "SELECT AVG(rating) FROM Reviews WHERE pNo=?";

                    if ($stmt = $con->prepare($sql)) {

                        $stmt->bind_param('i', $pNo);
                        $stmt->execute();
                        $stmt->bind_result($ratingAvg);
                        while ($stmt->fetch()) {

                            echo " <h1 title='" . $ratingAvg . "'>" . $ratingAvg . "</h1>";
                        }
                    } else {

                    }

                    switch ($ratingAvg) {
                        case 0:
                            echo "<p>
                        <span class=\"fa fa-star\"></span>
                        <span class=\"fa fa-star\"></span>
                        <span class=\"fa fa-star\"></span>
                        <span class=\"fa fa-star\"></span>
                        <span class=\"fa fa-star\"></span>
                    </p>";
                        case 1:
                            echo "<p>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star\"></span>
                        <span class=\"fa fa-star\"></span>
                        <span class=\"fa fa-star\"></span>
                        <span class=\"fa fa-star\"></span>
                    </p>";
                        case 2:
                            echo "<p>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star\"></span>
                        <span class=\"fa fa-star\"></span>
                        <span class=\"fa fa-star\"></span>
                    </p>";
                        case 3:
                            echo "<p>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star\"></span>
                        <span class=\"fa fa-star\"></span>
                    </p>";
                        case 4:
                            echo "<p>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star\"></span>
                    </p>";
                        case 5:
                            echo "<p>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star checked\"></span>
                        <span class=\"fa fa-star checked\"></span>
                    </p>";
                    }
                    ?>

<!--                    default html-->
                    <p>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star "></span>
                        <span class="fa fa-star"></span>

                        <!--                <a href="#reviews">Reviews</a>-->
                    </p>
                </div>
                <!--description-->
                <div class=pDesc>
                    <h3> Description</h3>

                    <?php

                    $sql = "SELECT description FROM Product WHERE pNo=?";

                    if ($stmt = $con->prepare($sql)) {

                        $stmt->bind_param('i', $pNo);
                        $stmt->execute();
                        $stmt->bind_result($desc);
                        while ($stmt->fetch()) {

                            echo " <p>" . $desc . "</p>";
//                            echo " <h1 title=' " . $pname . " ' >" . $pname . "</h1>";

                        }
                    } else {

                    }

                    ?>

                </div>
                <!--quantity counter-->
                <div class="quant">
                    <p>Quantity</p>
                    <!--                    TODO: need to send this somwehere-->
                    <form id='myform' method='POST' action="http://www.randyconnolly.com/tests/process.php">
                        <input title="Decrease Quantity" type='button' value='-' class='qtyminus' field='quantity'/>
                        <input required type='text' name='quantity' value='' class='qty'/>
                        <input title="Increase Quantity" type='button' value='+' class='qtyplus' field='quantity'/>

                        <!-- added drop down menu -->

                        <select name="size" class="size" required>
                            <option selected value="">Select a size</option>
                            <option value="SML">Small (S)</option>
                            <option value="MED">Medium (M)</option>
                            <option value="LG">Large (L)</option>
                            <option value="XLG">Extra-Large (XL)</option>
                        </select>

                        <!--                    TODO: Liam needs pName and price -->
                        <button title="Add to Cart" class="pageButtons">Add to Cart <i class="fa fa-shopping-cart"></i>
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

                            echo "<p>Listed Price: <label class=\"oldPrice\">CDN$ $OldPrice</label>";
                        }
                    } else {
                        echo "Error - could not get price.";
                        die();
                    }

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
                </div>
            </div>

        </div>
        <section id="reviews">
            <h3>Reviews
                <button title="Add Review" id="writeReviewButton" class="pageButtons">Write a Review <span
                            class="fa fa-pencil">
                </button>
            </h3>
            <div class="review1">
                <p class=userProfile>
                    <img src="../src/images/profile.png" alt="User's profile picture" align="middle"><a href="#">Parsa
                        R</a>
                    <time datetime="2018-10-24">- October 24, 2018</time>
                    <!--                comment button-->
                    <button title="Add Comment" id="writeCommentButton" alt="Add Comment" class="pageButtons"><span
                                class="fa fa-comments-o"></button>
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

            <div class="review1">
                <p class="userProfile">
                    <img src="../src/images/profile.png" alt="User's profile picture" align="middle"><a href="#">User
                        Name</a>
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
        </section>
    </div>


    <!-- The Modal FOR writeReviewButton-->
    <div id="reviewModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="closeReview">&times;</span>
                <h1>Product Review</h1>
            </div>
            <div class="modal-body">

                <h2> Overall Rating</h2>
                <!-- added drop down rating -->

                <form id="reviewInputForm" method="POST" action="http://www.randyconnolly.com/tests/process.php">

                    <select class="ratingInput" required name="userRatingInput">
                        <!--TODO: change value of default selected option, how about null?-->
                        <option selected value="">Select a rating</option>
                        <option value="1">1 Star</option>
                        <option value="2">2 Star</option>
                        <option value="3">3 Star</option>
                        <option value="4">4 Star</option>
                        <option value="5">5 Star</option>
                    </select>

                    <!-- Review input -->
                    <h2>What did you like or dislike about it? What did you use this product for?</h2>
                    <div class="formElement">
                        <!-- max lenght is 200 chars and there are 3 rows -->
                        <textarea id="reviewInput" name="userReviewInput" placeholder="Write your review" rows="8"
                                  maxlength="400" required></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <div class="modal-submit">
                    <input title="Submit Form" type="submit" value="Submit">
                    </form>
                </div>
                <h3 class="footerNote">We value your feedback!</h3>
            </div>
        </div>
    </div>


    <!-- The Modal FOR writeCommentButton-->
    <div id="commentModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="closeComment">&times;</span>
                <h1>Add Comment</h1>
            </div>
            <div class="modal-body">
                <!-- Review input -->
                <h2>What's your comment?</h2>
                <div class="formElement">
                    <!-- max lenght is 200 chars and there are 3 rows -->
                    <textarea id="reviewInput" name="userReviewInput" placeholder="Insert your comment here" rows="8"
                              maxlength="400" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <div class="modal-submit">
                    <input title="Submit Form" type="submit" value="Submit">
                    </form>
                </div>
                <h3 class="footerNote">Keep the conversation going!</h3>
            </div>
        </div>
    </div>
</main>
<?php
include "footer.php";
?>
