<?php
include "includes/init.php";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['pNo'])) {
        $pNo = sanitizeInput($_GET['pNo']);
    } else die("Please use a pNo when connecting to this page."); //TODO do something better in this case. -Jasper
}
$mysql;
try {
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user']->id;
        $name = $_SESSION['user']->firstName;
    }
    $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    if ($mysql->connect_errno) {
        die("Connection Failed: " . $mysql->connect_errno);
    }
    $query = "SELECT pname, AVG(rating) AS rating, image, contentType, description, price FROM Product LEFT JOIN Reviews ON Product.pNo = Reviews.pNo WHERE Product.pNo = ? GROUP BY Product.pNo";
    $stmt0 = $mysql->prepare($query);
    $stmt0->bind_param('i', $pNo);
    $stmt0->execute();
    $stmt0->bind_result($product['pname'], $product['rating'], $product['image'], $product['contentType'], $product['description'], $product['price']);
    $stmt0->fetch();
    $stmt0->close();
    $size = [];
    $query = "SELECT size FROM Product WHERE pNo = ?";
    $stmt = $mysql->prepare($query);
    $stmt->bind_param('i', $pNo);
    $stmt->execute();
    $stmt->bind_result($item);
    while ($stmt->fetch()) {
        switch ($item) {
            case 'single':
                array_push($size, 'single');
                break;
            case 'small':
                array_push($size, 'small');
                break;
            case 'medium':
                array_push($size, 'medium');
                break;
            case 'large':
                array_push($size, 'large');
                break;
            case 'xl':
                array_push($size, 'xl');
                break;
        }
    }
} catch (Exception $e) {
    die("Error with Cart. Session Terminated.");
} finally {
    $mysql->close();
}
?>

    <!DOCTYPE HTML>
    <html>

    <!--    Head-->
    <head>
        <meta charset="utf-8">
        <title>QSCU Merch Store</title>


        <?php include 'includes/headerFooterHead.php'; ?>
        <link rel="stylesheet" href="../src/css/singleProduct.css">
        <script type="text/javascript" src="script/quantity.js"></script>
        <script type="text/javascript" src="script/reviewModal.js"></script>
        <script type="text/javascript" src="script/addToCart.js"></script>


        <link rel="stylesheet" href="css/singleProduct.css">
    </head>
    <!--    Body-->

<body>

<?php include "header.php"; ?>
    <ul class="breadcrumb">
        <a href="homeWithoutTables.php">Home</a> &gt; &gt;
        <a href="searchpage.php">Categories</a> &gt; &gt;
        <a>Product</a>
    </ul>

    <main>
        <!--    make sure all the files that we update have the same and CORRECT width/height -->
        <div class="bigboi">
            <div class="container">
                <!--        TODO: find product src-->
                <img src="data:<?php echo $product['contentType']; ?>;base64,<?php echo base64_encode($product['image']); ?>" alt="Product Picture">

                <div class="sideContent">
                    <div class="pName" name="pName">
                        <h1 title="<?php echo $product['pname']; ?>"><?php echo $product['pname']; ?></h1>
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
                                    if ($i <= $ratingAvg) echo " checked";
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
                        <p><?php echo $product['description']; ?></p>
                    </div>
                    <!--quantity counter-->
                    <div class="quant">
                        <p>Quantity</p>
                        <!--                    TODO: need to send this somwehere-->

                        <!--                        <form id='myform'>-->

                        <input title="Decrease Quantity" type='button' value='-' class='qtyminus' field='quantity'/>
                        <input required id="quantity" type='number' name='quantity' value='1' min='1' placeholder="0" class='qty'/>
                        <input title="Increase Quantity" type='button' value='+' class='qtyplus' field='quantity'/>

                        <!-- added drop down menu -->


                        <!-- TODO: MAKE THIS TABLE DYNAMIC BASED ON PRODUCT -->
                        <select id="size" name="size" class="size" required>

                            <option selected value="">Select a size</option>
                            <?php
                            foreach ($size AS $key2 => $value2) {
                                if ($size[$key2] === 'single') {
                                    echo '<option value="single">No size</option>';
                                } else {
                                    echo '<option value="' . $size[$key2] . '">' . $size[$key2] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <!--TODO FIX ADD to cart button-->
                        <input id="pNo" type="hidden" value="<?php echo $pNo; ?>" name="pNo">
                        <button id="addToCartButton" title="Add to Cart" class="pageButtons">Add to Cart
                            <i class="fa fa-shopping-cart"></i>
                        </button>
                        <span id='addedToCart'></span>
                        <!--                        </form>-->

                    </div>

                    <!--            price-->
                    <div class="price">
                        <p>Listed Price:
                            <label class="oldPrice">CDN$<?php echo(floatval($product['price']) * 1.5); ?></label></p>
                        <p>Price: <label class="sale">CDN$<?php echo $product['price']; ?></label></p>
                    </div>
                </div>

            </div>
            <!--            TODO review block-->
            <section id="reviews">
                <h3>Reviews
                    <?php
                    if (isset($_SESSION['user'])) {
                        echo '<input type="hidden" id="UserLoggedIn">';
                        echo '<button title="Add Review" id="writeReviewButton" class="pageButtons" onclick="onWriteReview()">Write a Review <span class="fa fa-pencil"></button>';
                                        }
                    ?>

                </h3>
                <div id="reviewsContent">

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
                    <input type="hidden" id="reviewPNO" value="<?php echo $pNo; ?>">
                    <input type="hidden" id="reviewUID" value="<?php echo $user; ?>">
                    <h2> Overall Rating</h2>
                    <!-- added drop down rating -->

                    <form id="reviewInputForm">

                        <select id="ratingInput" class="ratingInput" required name="userRatingInput">
                            <!--TODO: change value of default selected option, how about null?-->
                            <option selected value="0">Select a rating</option>
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
                        <div id="statusHolderReview"></div>
                        <button title="Submit Form" id="reviewSubmitButton" onclick="onReviewSubmit()">Submit</button>
                    </div>
                    <h3 class="footerNote">We value your feedback!</h3>
                </div>
            </div>
        </div>

        <!--TODO MODEL FOR COMMENT-->
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
                        <textarea id="commentInput" name="userReviewInput" placeholder="Insert your comment here" rows="8"
                                  maxlength="400" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-submit">
                        <div id="statusHolderComment"></div>
                        <button title="Submit Form" id="commentSubmitButton" onclick="onCommentSubmit()">Submit</button>
                    </div>
                    <h3 class="footerNote">Keep the conversation going!</h3>
                </div>
            </div>
        </div>
    </main>
<?php
include "footer.php";
?>