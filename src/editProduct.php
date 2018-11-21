<?php
include 'includes/session.php';
include 'includes/db_credentials.php';
include 'includes/inputValidation.php';
include 'includes/validateAdmin.php';

validateAdminRequest($_SESSION);



if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $fieldArray = array('pid','size');
        if(arrayExists($_GET,$fieldArray) && arrayExists($_GET,$fieldArray) && is_numeric($_GET['pid']) && isValidSizeInput($_GET['size']) ){






        }
}

?>

    <label for="productNumber">Product Number</label>
    <input type="Number" name="productNumber" id="productNumber">
    <label for="productName">Product Name:</label>
    <input type="text" name="productName" id="productName">
    <p>Product Size(s):</p>
    <label for="sizeSmall">sizeSmall</label>
    <input type="radio" value="small" id="sizeSmall" name="productSize">
    <label for="sizeMedium">Medium</label>
    <input type="radio" value="medium" id="sizeMedium" name="productSize">
    <label for="sizeLarge">Large</label>
    <input type="radio" value="large" id="sizeLarge" name="productSize">
    <label for="productPrice">Price:</label>
    <input type="Number" name="productPrice" id="productPrice">
    <label for="uploadImage">Avatar</label>
    <input type="file" id="uploadImage" name="uploadImage">