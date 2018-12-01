<?php
include 'includes/init.php';
include 'includes/validateAdmin.php';

validateAdminRequest($_SESSION);

$product = [];
$hasCategorys = [];
$notCategorys = [];
$headerSet = 1;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['pno']) && arrayExists($_GET, array('pno')) && arrayIsValidInput($_GET, array('pno'))) {


    $mysql;
    try {


        $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if ($mysql->errno) {
            throw new Exception();
        }

        $query = 'SELECT pname, price, image, contentType, description, isEnabled, size, quantity FROM Product NATURAL JOIN HasInventory WHERE pNo = ?';
        $stmt = $mysql->prepare($query);
        $stmt->bind_param('i', $_GET['pno']);
        $stmt->execute();
        $stmt->bind_result($pnameP, $priceP, $imageP, $contentTypeP, $descriptionP, $isEnabledP, $sizeP, $qtyP);

        if (!$stmt->fetch()) {
            throw new Exception();
        }

        $product = array('size' => [], 'pname' => $pnameP, 'price' => $priceP, 'image' => $imageP, 'contentType' => $contentTypeP, 'description' => $descriptionP, 'isEnabled' => $isEnabledP);
        $product['size'][$sizeP] = $qtyP;
        while ($stmt->fetch()) {
            $product['size'][$sizeP] = $qtyP;
        }


        $stmt->close();

        $query = 'SELECT cname, cid FROM Category NATURAL JOIN ProductInCategory WHERE pNo = ?';
        $stmt = $mysql->prepare($query);
        $stmt->bind_param('i', $_GET['pno']);
        $stmt->execute();

        $stmt->bind_result($cname1, $cid1);
        while ($stmt->fetch()) {
            $item = [];
            $item['cname'] = $cname1;
            $item['cid'] = $cid1;
            array_push($hasCategorys, $item);
        }

        $query = 'SELECT cname, cid FROM Category WHERE cid NOT IN(SELECT cid FROM ProductInCategory WHERE pNo = ?)';
        $stmt = $mysql->prepare($query);
        $stmt->bind_param('i', $_GET['pno']);
        $stmt->execute();
        $stmt->bind_result($cname2, $cid2);
        while ($stmt->fetch()) {
            $item = [];
            $item['cname'] = $cname2;
            $item['cid'] = $cid2;
            array_push($notCategorys, $item);
        }

    } catch (Exception $e) {
        $mysql->close();
        exit();
    } finally {
        $mysql->close();
    }
} else {
    header('location: adminList.php');
    die();
}

?>

<html>
<head>
    <?php include 'includes/headerFooterHead.php' ?>
    <link rel="stylesheet" href="css/editProduct.css">
    <script src="script/editProduct_Controller.js"></script>
    <script src="script/imagePreview.js"></script>
</head>
<body>
<?php include 'header.php' ?>
<main>
    <div id="innerContent">
        <div class="editProductContent">
            <table id="productTable">
                <tr>
                    <td rowspan="4" colspan="2">
                        <form method="post" action="action/changeProduct.php" enctype="multipart/form-data">
                            <table id="imageTable">
                                <tr>
                                    <th>Product Image:</th>

                                <tr>
                                    <td>
                                        <img id="imagePreview" width="100px" height="100px" src="<?php echo 'data:' . $product['contentType'] . ';base64,' . base64_encode($product['image']) ?>" alt="Product image">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="file" name="uploadImage" id="uploadImage" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="hidden" name="pno" value="<?php echo $_GET['pno'] ?>">
                                        <input class="button" type="submit" value="Upload">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>

                    <td>
                        <label for="productName">Product Name:</label>
                    </td>
                    <form method="post" action="action/changeProduct.php">
                        <td>
                            <input type="text" name="productName" id="productName" maxlength="500" placeholder="Enter Product Name" required value="<?php echo $product['pname'] ?>">

                        </td>
                        <td rowspan="4">
                            <table>
                                <tr>
                                    <td class="2">
                                        <span>Quantities</span>
                                    </td>
                                </tr>
                                <?php if (array_key_exists('single', $product['size'])) {
                                    echo '<tr><td><label for="smallQty">Single:</label></td><td><input type="number" id="singleQty" value="' . $product['size']['single'] . '" name="singleQty" required></td></tr>';
                                } else {

                                    echo '<tr><td><label for="smallQty">Small:</label></td><td><input type="number" id="smallQty" name="smallQty" value="' . $product['size']['small'] . '" required><input type="hidden"></td></tr>';
                                    echo '<tr><td><label for="mediumQty">Medium:</label></td><td><input type="number" id="mediumQty" name="mediumQty" value="' . $product['size']['medium'] . '" required></td></tr>';
                                    echo '<tr><td><label for="largeQty">Large:</label></td><td><input type="number" id="largeQty" name="largeQty" value="' . $product['size']['large'] . '" required></td></tr>';
                                    echo '<tr><td><label for="xlQty">XL:</label></td><td><input type="number" id="xlQty" name="xlQty" value="' . $product['size']['xl'] . '" required></td></tr>';

                                } ?>
                            </table>
                        <td>
                </tr>
                <tr>
                    <td>
                        <label for="productPrice">Price:</label>
                    </td>
                    <td>
                        <input type="Number" step="0.01" name="productPrice" id="productPrice" placeholder="$" value="<?php echo $product['price'] ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="productDescription">Description:</label>
                    </td>
                    <td>
                        <textarea rows="4" cols="50" name="productDescription" id="productDescription" maxlength="500" placeholder="Enter Description..."><?php echo $product['description'] ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="isEnabled">Product Enabled:</label>
                        <input type="checkbox" name="isEnable" id="isEnabled" <?php if ($product['isEnabled']) {
                            echo 'checked="checked"';
                        } ?>>
                    </td>
                    <td>
                        <input type="hidden" name="pno" value="<?php echo $_GET['pno'] ?>">
                        <input id="submitProduct" class="button" type="submit">
                    </td>
                </tr>
                </form>
            </table>
        </div>

        <div class="categoryContainer">

            <div class="categoryOptions">
                <div id="deleteButtons">
                    <div id="removeCategory">
                        <button class="button" onclick="removeCategory()">&lt;&lt; Remove Category From Product</button>
                    </div>
                    <div id="deleteCategory">
                        <button class="button" onclick="deleteCategory()">Delete Category</button>
                    </div>
                    <div class="hasNotCategorys">
                <?php foreach ($notCategorys AS $key1 => $value1) {
                    echo '<div class="categoryItem" data-pno="' . $_GET['pno'] . '" data-cid="' . $notCategorys[$key1]['cid'] . '"><p>' . $notCategorys[$key1]['cname'] . '</p></div>';
                } ?>
            </div>
                </div>
                <div>
                    <input type="text" id="newCategoryName" placeholder="Enter Category Name" data-pno="<?php echo $_GET['pno'] ?>">
                </div>
                <div id="addButtons">
                    <div id="addCategory">
                        <button class="button" onclick="addCategory()">Add Category To Product &gt;&gt;</button>
                    </div>
                    <div id="createCategory">
                        <button class="button" onclick="newCategory()">Create Category</button>
                    </div>
                    <div class="hasCategorys">
                <?php foreach ($hasCategorys AS $key2 => $value2) {
                    echo '<div class="categoryItem" data-pno="' . $_GET['pno'] . '" data-cid="' . $hasCategorys[$key2]['cid'] . '"><p>' . $hasCategorys[$key2]['cname'] . '</p></div>';
                } ?>

            </div>

                </div>
            </div>

        </div>
    </div>
</main>
<?php include 'footer.php' ?>
</body>

</html>