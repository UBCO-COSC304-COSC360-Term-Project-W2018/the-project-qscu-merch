<?php
include 'includes/session.php';
include 'includes/db_credentials.php';
include 'includes/inputValidation.php';
include 'includes/validateAdmin.php';

validateAdminRequest($_SESSION);

$product = [];
$hasCategorys = [];
$notCategorys = [];
$headerSet = 1;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['pno'])) {
    $fieldArray = array('pno');
    if (arrayExists($_GET, $fieldArray) && arrayExists($_GET, $fieldArray) && is_numeric($_GET['pno'])) {


        $mysql;
        try {


            $mysql = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            if ($mysql->errno) {
                throw new Exception();
            }


            $query = 'SELECT pname, size, price, image, contentType, description, isEnabled FROM Product WHERE pNo = ?';
            $stmt = $mysql->prepare($query);
            $stmt->bind_param('i', $_GET['pno']);
            $stmt->execute();
            $stmt->bind_result($product['pname'], $product['size'], $product['price'], $product['image'], $product['contentType'], $product['description'], $product['isEnabled']);
            if (!$stmt->fetch()) {
                throw new Exception();
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
    }
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
<?php include 'header.php'?>
<main>
    <div class="editProductContent">
        <table>
            <tr>
                <td rowspan="4" colspan="2">
                    <form method="post" action="action/changeProduct.php" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td rowspan="2">
                                    <img id="imagePreview" src="<?php echo 'data:' . $product['contentType'] . ';base64,' . base64_encode($product['image']) ?>" alt="Product image">
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
                                    <input type="submit" value="Upload">
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
                <td colspan="2">
                    <label for="productName">Product Name</label>
                </td>
                <td colspan="3">
                    <label for="productDescription">Description:</label>
                </td>
            </tr>
            <form method="post" action="action/changeProduct.php">
                <tr>
                    <td colspan="2">
                        <input type="text" name="productName" id="productName" maxlength="254" required value="<?php echo $product['pname'] ?>">
                    </td>
                    <td rowspan="4" colspan="3">
                        <textarea rows="4" cols="50" name="productDescription" id="productDescription" maxlength="254"><?php echo $product['description'] ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="productPrice">Price:</label>
                    </td>
                    <td>
                        <input type="Number" step="0.01" name="productPrice" id="productPrice" value="<?php echo $product['price'] ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="pno" value="<?php echo $_GET['pno'] ?>">
                        <input type="submit">
                    </td>

                    <td>
                        <label for="isEnabled">Product Enabled</label>
                        <input type="checkbox" name="isEnable" id="isEnabled" <?php if ($product['isEnabled']) {echo 'checked="checked"';} ?>>
                    </td>
                </tr>
            </form>
        </table>
    </div>

    <div class="categoryContainer">
        <div class="hasNotCategorys">
            <?php foreach ($notCategorys AS $key1 => $value1) {
                echo '<div class="categoryItem" data-pno="' . $_GET['pno'] . '" data-cid="' . $notCategorys[$key1]['cid'] . '"><p>' . $notCategorys[$key1]['cname'] . '</p></div>';
            } ?>
        </div>
        <div class="categoryOptions">
            <input type="text" name="newCategoryName" data-pno="<?php echo $_GET['pno']?>" id="newCategoryName">
            <button id="newCategoryNameBtn" onclick="newCategory()">New Category</button>
            <button id="deleteCategory" onclick="deleteCategory()">Delete Category</button>
            <button id="addCategory" onclick="addCategory()">Add Category &gt;&gt;</button>
            <button id="removeCategory" onclick="removeCategory()">&lt;&lt; Remove Category</button>
        </div>
        <div class=" hasCategorys
            ">
            <?php foreach ($hasCategorys AS $key2 => $value2) {
                echo '<div class="categoryItem" data-pno="' . $_GET['pno'] . '" data-cid="' . $hasCategorys[$key2]['cid'] . '"><p>' . $hasCategorys[$key2]['cname'] . '</p></div>';
            } ?>

        </div>
    </div>
</main>
<?php include 'footer.php'?>
</body>

</html>