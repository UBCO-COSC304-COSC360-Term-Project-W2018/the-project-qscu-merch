<?php
include 'includes/init.php';
include 'includes/validateAdmin.php';

validateAdminRequest($_SESSION);
$headerSet = 1;

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <?php include 'includes/headerFooterHead.php' ?>
        <link rel="stylesheet" href="css/adminList.css">
        <script src="script/admin_controller.js"></script>
        <script src="script/imagePreview.js"></script>
    </head>

    <body>
    <?php include "header.php"; ?>
    <main>
        <div id="container">
            <div id="mainTabs">
                <button id="btnProducts">Products</button>
                <button id="btnUsers">Users</button>
                <button id="btnPosts">Posts</button>
                <button id="btnAdminJunk">Admin Junk</button>
                <input id="subSearch" name="subSearch" type="text">
                <button id="btnSearch" onclick="onSearch()">Search</button>
                <label for="rbProductName">Product Name:</label>
                <input id="rbProductName" value="0" checked name="rbgroup" type="radio">
                <label for="rbProductCategory">Product Category:</label>
                <input id="rbProductCategory" value="1" name="rbgroup" type="radio">
                <label for="rbUserName">Users Name:</label>
                <input id="rbUserName" value="2" name="rbgroup" type="radio" disabled>
                <label for="rbUserEmail">Users Email:</label>
                <input id="rbUserEmail" value="3" name="rbgroup" type="radio" disabled>
                <label for="rbPostTitle">Post Title:</label>
                <input id="rbPostTitle" value="4" name="rbgroup" type="radio" disabled>
                <label for="rbPost">Post Body:</label>
                <input id="rbPost" value="5" name="rbgroup" type="radio" disabled>
            </div>


            <div id="productList">
                <div>
                    <h1 class="productHead">Product List</h1>
                    <button class="productHead" id="addProduct">Add Product</button>
                </div>
                <div id="newProduct" class="hidden">
                    <form method="post" action="action/addProduct.php" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td rowspan="3" colspan="3">
                                    <img id="imagePreview" height="100px" width="100px" src="" alt="image preview">
                                </td>
                                <td>
                                    <label for="productName">Product Name:</label>
                                </td>
                                <td>
                                    <input type="text" name="productName" id="productName" maxlength="50" required>
                                </td>
                                <td>
                                    <label for="productPrice">Price:</label>
                                </td>
                                <td>
                                    <input type="Number" step="0.01" name="productPrice" id="productPrice" required>
                                </td>
                                <td>
                                    <label for="chbSingleItem">Single Item:</label>
                                </td>
                                <td>
                                    <input type="checkbox" name="singleItem" id="chbSingleItem">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="file" id="uploadImage" name="uploadImage" required>
                                </td>
                                <td colspan="4" rowspan="2">
                                    <textarea placeholder="Product Description" maxlength="254" name="productDescription" id="productDescription"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit">
                                </td>
                                <td>
                                    <input id="formResetBtn" type="reset" onclick="resetPreview()">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="productContent">
                </div>
            </div>
            <div class="hidden" id="userList">
                <div>
                    <h1 class="userHead">User List</h1>
                </div>
                <div id="userContent">
                </div>
            </div>
            <div class="hidden" id="postList">
                <div>
                    <h1>Reviews and Comments</h1>
                </div>
                <div class="postContent">
                    <table class="productReview">
                        <tr>
                            <td colspan="5">
                                <span>Product Name: <a href="">Product Name</a></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="userReview">
                                    <tr>
                                        <td>
                                            <span>User Email:</span>
                                        </td>
                                        <td>
                                            <span>Email@email.com</span>
                                        </td>
                                        <td>
                                            <span>User Name:</span>
                                        </td>
                                        <td>
                                            <span>Jeff Bridges</span>
                                        </td>
                                        <td>
                                            <button onclick="onSearchUser(1)">Search User</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span>Review Tile:</span>
                                        </td>
                                        <td colspan="4">
                                            <span>This is a product</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span>Rating: 5/5</span>
                                        </td>
                                        <td>
                                            <span>Date Posted: 2018-11-23</span>
                                        </td>

                                        <td>
                                            <span>Review Status:</span>
                                        </td>
                                        <td>
                                            <span class="17PostStatus" data-status="setPost" >Enabled</span>
                                        </td>
                                        <td>
                                            <button class="17PostChange" onclick="onChangePostStatus(1,7)">Disable</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            This is a product review, is good products
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <table class="userComment">
                                                <tr>
                                                    <td>
                                                        <span>User Email:</span>
                                                    </td>
                                                    <td>
                                                        <span>notemail@email.com</span>
                                                    </td>
                                                    <td>
                                                        <span>User Name:</span>
                                                    </td>
                                                    <td>
                                                        <span>scarlett johansson</span>
                                                    </td>
                                                    <td>
                                                        <button onclick="onSearchUser(2)">Search User</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span>Comment Tile:</span>
                                                    </td>
                                                    <td colspan="4">
                                                        <span>Your Review sucks</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <span>Date Posted: 2018-11-24</span>
                                                    </td>

                                                    <td>
                                                        <span>Review Status:</span>
                                                    </td>
                                                    <td>
                                                        <span class="171PostStatus" data-status="unsetPost" >Enabled</span>
                                                    </td>
                                                    <td>
                                                        <button class="171PostChange" onclick="onChangePostStatus(1,7,1)">Disable</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="3" colspan="5">
                                                        write more in your review
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </main>
    </body>
    </html>

<?php
include "footer.php";
?>