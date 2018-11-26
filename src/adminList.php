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
                <button id="btnSearch">Search</button>
                <label for="rbProductName">Product Name:</label>
                <input id="rbProductName" checked name="rbgroup" type="radio">
                <label for="rbProductCategory">Product Category:</label>
                <input id="rbProductCategory" value="0" name="rbgroup" type="radio">
                <label for="rbUserName">Users Name:</label>
                <input id="rbUserName" value="1" name="rbgroup" type="radio" disabled>
                <label for="rbUserEmail">Users Email:</label>
                <input id="rbUserEmail" value="2" name="rbgroup" type="radio" disabled>
                <label for="rbPostTitle">Post Title:</label>
                <input id="rbPostTitle" value="3" name="rbgroup" type="radio" disabled>
                <label for="rbPost">Post Body:</label>
                <input id="rbPost" value="4" name="rbgroup" type="radio" disabled>
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
                    <!--                    TODO style me-->
                    <!--                    the table is created dynamically and repeats do not use ids only classes and tag selection-->
                    <!--                    this product has 4 sizes-->
                    <!--                    you can change the html but leave the temp data so i can change the dynamic builder-->
                    <table class="productItem">
                        <tr class="productHeaders">
                            <td class="productNameTitle"><span>product1</span></td>
                            <td class="productSizeTitle"><span>Size</span></td>
                            <td class="productPriceTitle"><span>Price</span></td>
                            <td class="productQuantityTitle"><span>Quantity</span></td>
                        </tr>
                        <tr>
                            <td rowspan="4" class="productImage">
                                <img src="data:image/jpeg;base64,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" alt="product Image">
                            </td>
                            <td class="productSize"><span>small</span></td>
                            <td class="productPrice"><span>3.00</span></td>
                            <td class="productQuantity"><span>0</span></td>
                        </tr>
                        <tr>
                            <td class="productSize"><span>medium</span></td>
                            <td class="productPrice"><span>2.00</span></td>
                            <td class="productQuantity"><span>0</span></td>
                        </tr>
                        <tr>
                            <td class="productSize"><span>large</span></td>
                            <td class="productPrice"><span>1.00</span></td>
                            <td class="productQuantity"><span>0</span></td>
                        </tr>
                        <tr>
                            <td class="productSize"><span>xl</span></td>
                            <td class="productPrice"><span>4.00</span></td>
                            <td class="productQuantity"><span>0</span></td>
                        </tr>
                        <tr>
                            <td class="editProduct" colspan="4">
                                <form action="editProduct.php?pno=23"><input type="submit" value="Edit Product"></form>
                            </td>
                        </tr>
                    </table>
                    <!--                    TODO style me-->
                    <!--                    the table is created dynamically and repeats do not use ids only classes and tag selection-->
                    <!--                    this product has 1 size or is a single product-->
                    <!--                    you can change the html but leave the temp data so i can change the dynamic builder-->
                    <table class="productItem">
                        <tr>
                            <td class="productNameTitle"><span>single item</span></td>
                            <td class="productSizeTitle"><span>Size</span></td>
                            <td class="productPriceTitle"><span>Price</span></td>
                            <td class="productQuantityTitle"><span>Quantity</span></td>
                        </tr>
                        <tr>
                            <td rowspan="4" class="productImage">
                                <img src="data:image/jpeg;base64,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" alt="product Image">
                            </td>
                            <td class="productSize"><span>single</span></td>
                            <td class="productPrice"><span>90000.00</span></td>
                            <td class="productQuantity"><span>0</span></td>
                        </tr>
                        <tr>
                            <td class="productSize"><span></span></td>
                            <td class="productPrice"><span></span></td>
                            <td class="productQuantity"><span></span></td>
                        </tr>
                        <tr>
                            <td class="productSize"><span></span></td>
                            <td class="productPrice"><span></span></td>
                            <td class="productQuantity"><span></span></td>
                        </tr>
                        <tr>
                            <td class="productSize"><span></span></td>
                            <td class="productPrice"><span></span></td>
                            <td class="productQuantity"><span></span></td>
                        </tr>
                        <tr>
                            <td class="editProduct" colspan="4">
                                <form action="editProduct.php?pno=27"><input type="submit" value="Edit Product"></form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="hidden" id="userList">
                <div>
                    <h1 class="userHead">User List</h1>
                </div>
                <div id="userContent">
                    <!--                    TODO style me-->
                    <!--                    the table is created dynamically and repeats do not use ids only classes and tag selection-->
                    <!--                    you can change the html but leave the temp data so i can change the dynamic builder-->
                    <!--                    Make new classes as any class with a number in front of it is uneque to each user-->
                    <table class="userTable">
                        <tr>
                            <td class="1ProfileImage" rowspan="2" colspan="2">
                                <img class="1ProfileImage" src="data:image/jpeg;base64,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" alt="User Profile Image">
                            <td>Name:</td>
                            <td colspan="2">Rachelle Gelden</td>
                            <td>Email:</td>
                            <td>rachelle@gelden.com</td>
                        </tr>
                        <tr>
                            <td>Account Status:</td>
                            <td><span class="1UserStatus">Admin</span></td>
                            <td>
                                <button class="1ChangeStatus" data-status="false" onclick="onChangeStatus(1)">Change
                                    Status
                                </button>
                            </td>
                            <td>
                                <button class="1SendRecovery" onclick="onSendRecovery(1)">Send Recovery Email</button>
                            </td>
                            <td>
                                <button class="1CopyRecovery" onclick="onCopyRecovery(1)">Copy Recovery Token</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button onclick="onRemoveImage(1)">Remove Image</button>
                            </td>
                            <td>
                                <button class="1BanUser" onclick="onBanUser(1)" disabled="">ban</button>
                            </td>
                            <td>
                                <button class="1AdminUser" onclick="onAdminUser(1)" disabled="">Remove Admin</button>
                            </td>
                            <td>
                                <form method="get" action="">
                                    <button>View Users Order History</button>
                                </form>
                            </td>
                            <td>
                                <form method="get" action="">
                                    <button>View Users Reviews</button>
                                </form>
                            </td>
                            <td>
                                <form method="get" action="">
                                    <button>View Users Comments</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <table class="hidden" id="postList">
                <caption>Post List</caption>
                <thead>
                <tr>
                    <th>
                        <span>posts</span>
                    </th>
                    <td>
                    </td>
                </tr>
                </thead>
                <tr>
                    <td class="listName">
                        <span>post</span>
                    </td>
                    <td class="reviewButton">
                        <button>post</button>
                    </td>
                </tr>
            </table>

        </div>
    </main>
    </body>
    </html>

<?php
include "footer.php";
?>