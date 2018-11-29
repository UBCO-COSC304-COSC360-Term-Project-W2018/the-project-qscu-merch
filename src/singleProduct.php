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
	$stmt->close();
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
<<<<<<< HEAD
    <?php include 'includes/headerFooterHead.php' ?>
<<<<<<< HEAD
<!--    <script type="text/javascript" src="libs/jquery-3.3.1.min.js"></script>-->
    <script type="text/javascript" src="script/reviewModal.js"></script>
<!--    <script type="text/javascript" src="../src/script/quantity.js"></script>-->
    <!--    <script type="text/javascript" src="script/reviewModal.js"></script>-->
<!--    <script type="text/javascript" src="../src/script/commentModal.js"></script>-->
    <link rel="stylesheet" href="css/singleProduct.css">
<!--    --><?php //include 'includes/headerFooterHead.php'; ?>
<!--    <script type="text/javascript" src="script/quantity.js"></script>-->
=======
=======
    <?php include 'includes/headerFooterHead.php'; ?>
>>>>>>> b44f281d8445e934f81b03f9f2d7fc4cb8500a18
    <script type="text/javascript" src="script/quantity.js"></script>
    <script type="text/javascript" src="script/reviewModal.js"></script>

    <script type="text/javascript" src="script/addToCart.js"></script>
    <!--<script type="text/javascript" src="script/commentModal.js"></script>-->
<<<<<<< HEAD
    <link rel="stylesheet" href="css/singleProduct.css">
>>>>>>> 9ad80de4f61a139c000d1930b774566e871db333
    <!--    <script type="text/javascript" src="../src/script/commentModal.js"></script>-->
=======
>>>>>>> b44f281d8445e934f81b03f9f2d7fc4cb8500a18

    <link rel="stylesheet" href="css/singleProduct.css">
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
                    <?php
                    $ratingAvg = $product['rating'];
                    if ($ratingAvg && $ratingAvg != NULL) {
                      for ($i = 0; $i < 5; $i++) {
                        echo "<span class=\"fa fa-star";
                        if ($i <= $ratingAvg) echo "checked";
                        echo "\"></span>";
                      }
                    } else {
                      echo "Rating for this product not available.";
                    }
                    ?>
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

                    <form id='myform'>

                        <input title="Decrease Quantity" type='button' value='-' class='qtyminus' field='quantity'/>
                        <input required id="quantity" type='text' name='quantity' value='' class='qty'/>
                        <input title="Increase Quantity" type='button' value='+' class='qtyplus' field='quantity'/>

                        <!-- added drop down menu -->

						<!-- TODO: MAKE THIS TABLE DYNAMIC BASED ON PRODUCT -->
                        <select name="size" class="size" required>
                            <option selected value="">Select a size</option>
						<?php 
						$sql2 = "SELECT size FROM Product WHERE pNo = ?";
						if ($stmt2 = $con->prepare($sql2)) {
							$stmt2->bind_param('i', $pNo);
							$stmt2->execute();
							$stmt2->bind_result($product['size']);
							while($stmt2->fetch()) {
								echo "<option value='".$product['size'].">".$product['size']."</option>";
							}
						}
						?>
                           <option value="single">single</option>
                            <option value="MED">Medium (M)</option>
                            <option value="LG">Large (L)</option>
                            <option value="XLG">Extra-Large (XL)</option>
                        </select>

                        <!--                    TODO: Liam needs pName and price -->


						            <input id="pNo" type="hidden" value="<?php echo $pNo;?>" name="pNo">
                        <button id="addToCartButton" title="Add to Cart" class="pageButtons">Add to Cart <i class="fa fa-shopping-cart"></i>


                        </button>
                        <span id="addedToCart"></span>
                    </form>

                </div>

                <!--            price-->
                <div class="price">
                  <p>Listed Price: <label class="oldPrice">CDN$<?php echo (floatval($product['price'])*1.5);?></label></p>
                  <p>Price: <label class="sale">CDN$<?php echo $product['price'];?></label></p>
                </div>
            </div>

        </div>
        <section id="reviews">
            <h3>Reviews
                <button title="Add Review" id="writeReviewButton" class="pageButtons" onclick={console.log("test")}>Write a Review <span
                            class="fa fa-pencil">
                </button>
            </h3>
            <?php
              $sqlReviews = "SELECT User.uid, rating, comment, date, isEnabled, profilePicture, contentType, fname, lname FROM Reviews LEFT JOIN User ON Reviews.uid = User.uid WHERE Reviews.pNo = ?";
              if ($stmt = $con->prepare($sqlReviews)) {
                  $pNo = sanitizeInput($pNo);
                  $stmt->bind_param('i', $pNo);
                  $stmt->execute();
                  $stmt->bind_result($review['uid'],$review['rating'],$review['comment'],$review['date'],$review['isEnabled'], $review['profilePicture'], $review['contentType'], $review['fname'], $review['lname']);
                  while($stmt->fetch()) {
                    echo "<div class='review1'>";
                      echo "<p class='userProfile'>";
                        echo "<img src='data:".$review['contentType'].";base64,".base64_encode($review['profilePicture'])."' alt='".$review['fname']." ".$review['lname']." Profile Picture' align='middle'>";
                        echo "<a href='#'>".$review['fname']." ".substr($review['lname'], 0, 1)."</a>";
                        echo "<time datetime='".$review['date']."'>".$review['date']."</time>";
                        echo "<button title='Add Comment' id='writeCommentButton' alt='Add Comment' class='pageButtons'><span class='fa fa-comments-o'></span></button>";
						//TODO: change the id in the line above to something like a class so that multiple comments wont fuck it up
                      echo "</p>";
                      echo "<p class='userRating'>";
                        for ($i = 0; $i < 5; $i++) {
                          echo "<span class=\"fa fa-star";
                          if ($i <= $review['rating']) echo " checked";
                          echo "\"></span>";
                        }
                      echo "<p class='reviewTitle'>".$review['fname']." ".substr($review['lname'],0,1)." says:</p>";
                      echo "<p class='reviewDescription'>".$review['comment']."</p>";
                    echo "</div>";
                  }
              }
            ?>
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
                <input type="hidden" id="reviewPNO" value="<?php echo $pNo; ?>">
                <input type="hidden" id="reviewUID" value="<?php echo $user; ?>">
                <h2> Overall Rating</h2>
                <!-- added drop down rating -->

                <form id="reviewInputForm">

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
                    <div id="statusHolder"></div>
                    <button title="Submit Form" id="reviewSubmitButton" value="Submit">Submit</button>
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
</body>
</html>

