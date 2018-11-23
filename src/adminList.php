<?php
include 'includes/session.php';
include 'includes/validateAdmin.php';

validateAdminRequest($_SESSION);

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <?php include 'includes/headerFooterHead.php'?>
        <link rel="stylesheet" href="css/adminList.css">
        <script src="script/admin_controller.js"></script>
    </head>

    <body>
    <?php include "header.php";?>
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
                <label for="rbUserName">User Name:</label>
                <input id="rbUserName" value="1" name="rbgroup" type="radio" disabled>
                <label for="rbUserEmail">User Email:</label>
                <input id="rbUserEmail" value="2" name="rbgroup" type="radio" disabled>
                <label for="rbPostTitle">Post Title:</label>
                <input id="rbPostTitle" value="3" name="rbgroup" type="radio" disabled>
                <label for="rbPost">Post Body:</label>
                <input id="rbPost" value="4" name="rbgroup" type="radio" disabled>
            </div>


            <table id="productList">
                <caption>Product List</caption>
                <table class="productItem">
                    <tr>
                        <td class="productName" colspan="2">
                            <span>product name</span>
                        </td>
                        <td class="productPrice">
                            <span>Price</span>
                        </td>
                        <td class="productQuantity">
                            <span>Quantity</span>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3" class="productImage">
                            <img src="">
                        </td>
                        <td class="productSize">
                            <span>Small</span>
                        </td>
                        <td class="productPrice">
                            <span>1.3</span>
                        </td>
                        <td class="productQuantity">
                            <span>4</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="productSize">
                            <span>Medium</span>
                        </td>
                        <td class="productPrice">
                            <span>1.3</span>
                        </td>
                        <td class="productQuantity">
                            <span>4</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="productSize">
                            <span>Large</span>
                        </td>
                        <td class="productPrice">
                            <span>1.3</span>
                        </td>
                        <td class="productQuantity">
                            <span>4</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button>Edit</button>
                        </td>
                        <td class="productSize">
                            <span>Extra Large</span>
                        </td>
                        <td class="productPrice">
                            <span>1.3</span>
                        </td>
                        <td class="productQuantity">
                            <span>4</span>
                        </td>
                    </tr>
                </table>
            </table>
            <table class="hidden" id="userList">
                <caption>User List</caption>
                <thead>
                <tr>
                    <th>
                        <span>User Email</span>
                    </th>
                    <td>
                    </td>
                </tr>
                </thead>
                <tr>
                    <td class="listName">
                        <span>user1@eamil.com</span>
                    </td>
                    <td class="reviewButton">
                        <button>Review</button>
                    </td>
                </tr>
            </table>
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