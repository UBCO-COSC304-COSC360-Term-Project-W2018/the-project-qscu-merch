<?php
include "includes/init.php";
try {
  //    TODO this needs to be changed the query part doesnt have a trycatch

  $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

  if($con -> connect_errno){
  	die("Connection Failed: ".$con -> connect_errno);
  }
	$sqlCats = "SELECT cid, cname FROM Category";
  if(!($cats = $con->query($sqlCats))) {
		die("Category Query failed.");
	}
} catch (Exception $e) {
	die("Session Terminated.");
}
$headerSet = 0;
?>
<!DOCTYPE HTML>
<html>
<!--    Head-->

<head lang="en">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/searchpage.css"/>
    <?php include 'includes/headerFooterHead.php';?>
    <script type="text/javascript" src="script/search_controller.js"></script>
</head>


<!--    Body-->

<body>

<?php include "header.php"?>

<ul class="breadcrumb">
    <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
    Search
</ul>

    <!-- Main Body -->
<main>
	<div id="main">
		<div id="refinecol">
				<form id="refineform">
					<fieldset id="refinefieldset">
						<legend>Refine Results</legend>

            <div id="itemsperpage">
              <p class="refinelabel"><label>Items per Page:</label>
							<input type="number" id="iperpage" value="6" min="2" max="25" step="1">
							</p>
            </div>
						<!--<div id="pricerange">
							<p class="refinelabel"><label>Price Range:</label></p>
							<input type="range" id="max" name="pricemax" value="1000">
							<output name="price" for="max"></output><br>
						</div>-->

						<div id="colourselect">
							<p class="refinelabel"><label id="colour">Category: </label></p>

              <?php
                $check = isset($_GET['cat'])&&$_GET['cat']!="";
                if (!$check) {
                  echo "<input type=\"radio\" name=\"category\" value=\"-1\" id=\"cat-1\" checked=\"true\">";
                } else {
                  echo "<input type=\"radio\" name=\"category\" value=\"-1\" id=\"cat-1\">";
                }
                echo "<label for=\"cat-1\">ALL</label><br>";
    						foreach($cats as $cat) {
                  if ($check) {
                    $curCat = urldecode($_GET['cat']);
                    if ($cat['cname']==$curCat) {
                      echo "<input type=\"radio\" name=\"category\" value=\"" . $cat['cid'] . "\" id=\"cat" . $cat['cid'] . "\" checked=\"true\">";
                    } else {
                      echo "<input type=\"radio\" name=\"category\" value=\"" . $cat['cid'] . "\" id=\"cat" . $cat['cid'] . "\">";
                    }
                  } else {
                    echo "<input type=\"radio\" name=\"category\" value=\"" . $cat['cid'] . "\" id=\"cat" . $cat['cid'] . "\">";
                  }
                  echo "<label for=\"cat".$cat['cid']."\">" . $cat['cname'] . "</label><br>";
    						}
    					?>
						</div>
						<button id="refineSearchBtn">Refine Results</button>
					</fieldset>
					
				</form>
		</div>

  	<div id="categoryviews">
  		<div id="sortby">
        <p id='searchResultsTitle'>Search Results<?php if(isset($_GET['Search'])) echo " for: &quot;".$_GET['Search']."&quot;";?></p> <!--could include what we searched for in this line. Simple Query, extra -->
<!--
    		<form id="sortform">
    			<label id="sortlabel">Sort By:</label>
    			<select name="sort" id="sort">
    				<option value="rating">Rating</option>
    				<option value="lowtohigh">Price: Low to High</option>
    				<option value="hightolow">Price: High to Low</option>
    			</select>
    		</form>
-->
  		</div>

      <div id="resultHolder">
        <input type="hidden" id="searchTransferForLoad" value="<?php if(isset($_GET['Search'])) echo $_GET['Search'];?>">
      </div>

		</div>
	</div>
	<div id="pagenumber">
		<p id="number">
		</p>
	</div>
</main>
<?php include "footer.php"; ?>
