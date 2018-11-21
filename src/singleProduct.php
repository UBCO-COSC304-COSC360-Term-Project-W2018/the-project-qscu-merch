<?php
$headerSet = 0;
include "includes/init.php";
include "header.php";

try{
<<<<<<< HEAD

$user = isset($_SESSION["userId"])? $_SESSION['userId']: null;

$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($con -> connect_errno){
	die("Connection Failed: ".$con -> connect_errno);
}
}
catch (Exception $e) {
	die("Error with Cart. Session Terminated.");
}

?>
<!DOCTYPE HTML>
<html lang="en">
<!--    Head-->

<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/singleProduct.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="icon" type="image/x-icon" href="images/QSCU_favicon.png" />
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="script/quantity.js"></script>
    <script type="text/javascript" src="../src/script/reviewModal.js"></script>

</head>


<!--    Body-->

<body>
<main>
=======
    $user = isset($_SESSION["userId"])? $_SESSION['userId']: null;

    $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

    if($con -> connect_errno){
        die("Connection Failed: ".$con -> connect_errno);
    }
}
catch (Exception $e) {
    die("Error with Cart. Session Terminated.");
}

?>

<!DOCTYPE HTML>
<html lang="en">

<!--    Head-->
<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="../src/css/header.css" />
    <link rel="stylesheet" href="../src/css/footer.css" />
    <link rel="stylesheet" href="../src/css/singleProduct.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="icon" type="image/x-icon" href="../src/images/QSCU_favicon.png" />
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="../src/script/quantity.js"></script>
    <script type="text/javascript" src="../src/script/reviewModal.js"></script>
>>>>>>> origin/Parsa


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
                <p>These ping pongs are directly from south Tunisia. They are the authentic hollowed out eyes of the western red and blue zebras. Buy now, while supplies last. 100% guaranteed to improve your beer-pong game! </p>
            </div>
            <!--quantity counter-->
            <div class="quant">
                <p>Quantity</p>
                <form id='myform' method='POST' action='#'>
                    <!--                    TODO: need to send this somwehere-->
                    <input type='button' value='-' class='qtyminus' field='quantity' />
                    <input type='text' name='quantity' value='0' class='qty' />
                    <input type='button' value='+' class='qtyplus' field='quantity' />

                    <!-- added drop down menu -->
                    <select class="size">
                        <option value="SML">Small (S)</option>
                        <option value="MED">Medium (M)</option>
                        <option value="LG">Large (L)</option>
                        <option value="XLG">Extra-Large (XL)</option>
                    </select>

                </form>
                <button class="addCart">Add to Cart <i class="fa fa-shopping-cart"></i></button>

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
        <!-- ORIGINAL -->
        <!-- <h3>Reviews <a href="login.html" class="fa fa-pencil"> Write a Review </a>
        </h3> -->
        <!-- PLAYING WITH -->
        <h3>Reviews
            <button id="writeReviewButton" class="addCart">Write a Review <span class="fa fa-pencil"></button>
        </h3>
        <div class="review1">
            <p class=userProfile>
                <img src="../src/images/profile.png" alt="User's profile picture" align="middle"><a href="#">Parsa R</a> <time datetime="2018-10-24">- October 24, 2018</time></p>
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
                <img src="../src/images/profile.png" alt="User's profile picture" align="middle"><a href="#">User Name</a> <time datetime="2018-10-24">- Month Day, Year</time></p>
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
        <!--
          <div class="review2">
              <p class="byline">By Parsa on <time datetime="2016-10-01">October 30, 2018</time></p>
              <p class="userReview">10/10 would buy again.</p>
          </div>
  -->
    </section>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h1>Product Review</h1>
        </div>
        <div class="modal-body">

            <h2> Overall Rating</h2>
            <!-- added drop down rating -->
            <select class="ratingInput">
                <!--TODO: change value of default selected option, how about null?-->
                <option  selected value="noStar">Select a rating</option>
                <option value="1">1 Star</option>
                <option value="2">2 Star</option>
                <option value="3">3 Star</option>
                <option value="4">4 Star</option>
                <option  value="5">5 Star</option>
            </select>


            <form id="contactForm" method="post" action="http://www.randyconnolly.com/tests/process.php">

                <!-- Review input -->
                <h2>What did you like or dislike about it? What did you use this product for?</h2>
                <div class="formElement">
                    <!-- max lenght is 200 chars and there are 3 rows -->
                    <textarea id="reviewInput" name="userReviewInput" placeholder="Write your review" rows="8" maxlength="400" required></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="reivewInputSubmit">
                <button formaction="http://www.randyconnolly.com/tests/process.php" type="submit" id="SubmitButton" onsubmit="alert('Thank you for your review!');">Submit</button>
            </div>
            <h3 class="footerNote">We value your feedback!</h3>


        </div>
    </div>

</div>

<?php
include "footer.php";
?>
