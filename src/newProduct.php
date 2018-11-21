<?php
include 'includes/session.php';
include 'includes/validateAdmin.php';
//TODO remove dev statement.
$_SESSION['userid'] = 11;

validateAdminRequest($_SESSION);

?>

<html>
<head>

</head>
<body>
<form method="post" action="action/addProduct.php" enctype="multipart/form-data">
    <label for="productName">Product Name:</label>
    <input type="text" name="productName" id="productName">
    <label for="productPrice">Price:</label>
    <input type="Number" step="0.01" name="productPrice" id="productPrice">
    <label for="uploadImage">Product Image:</label>
    <input type="file" id="uploadImage" name="uploadImage">
    <label for="productDescription">Product Description</label>
    <textarea rows="4" cols="50" name="productDescription" id="productDescription"></textarea>
    <input type="submit">
    <input type="reset">
</form>

</body>
</html>