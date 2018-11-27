<?php
$headerSet = 0;
include "includes/init.php";
include "header.php";

try {
    $user = isset($_SESSION["userId"]) ? $_SESSION['userId'] : null;

    $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

    if ($con->connect_errno) {
        die("Connection Failed: " . $con->connect_errno);
    }
} catch (Exception $e) {
    die("Error with Cart. Session Terminated.");
}

?>

<!DOCTYPE HTML>
<html lang="en">

<!--    Head-->
<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="../src/css/singleProduct.css">
    <?php include 'includes/headerFooterHead.php' ?>
    <script type="text/javascript" src="../src/script/quantity.js"></script>
    <script type="text/javascript" src="../src/script/reviewModal.js"></script>
    <script type="text/javascript" src="../src/script/commentModal.js"></script>


</head>
<!--    Body-->

<body>

<ul class="breadcrumb">
    <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
    <a href="categorypage.php">Categories</a> &gt; &gt;
    <a>Product</a>
</ul>

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
            </div>
            <!--rating-->
            <div class="rating">
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
                <p>These ping pongs are directly from south Tunisia. They are the authentic hollowed out eyes of the
                    western red and blue zebras. Buy now, while supplies last. 100% guaranteed to improve your beer-pong
                    game! </p>
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

                    <button title="Add to Cart" class="pageButtons">Add to Cart <i class="fa fa-shopping-cart"></i></button>
                </form>

            </div>

            <!--            price-->
            <div class="price">
                <p>Listed Price: <label class="oldPrice">CDN$299.99</label></p>

                <p>Price: <label class="sale">CDN$199.99</label>


                </p>
            </div>
        </div>

    </div>
    <section id="reviews">
        <h3>Reviews
            <button title="Add Review" id="writeReviewButton" class="pageButtons">Write a Review <span class="fa fa-pencil">
            </button>
        </h3>
        <div class="review1">
            <p class=userProfile>
                <img src="../src/images/profile.png" alt="User's profile picture" align="middle"><a href="#">Parsa R</a>
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
            <span class="close">&times;</span>
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
            <span class="close">&times;</span>
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

<?php
include "footer.php";
?>
