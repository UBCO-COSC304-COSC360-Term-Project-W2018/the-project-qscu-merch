<?php
include "includes/init.php";
try {
  //    TODO this needs to be changed the query part doesnt have a trycatch

  $con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

  if($con -> connect_errno){
  	die("Connection Failed: ".$con -> connect_errno);
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
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="css/searchpage.css"/>
    <?php include 'includes/headerFooterHead.php';?>
    <script type="text/javascript" src="script/search_controller.js"></script>
</head>


<!--    Body-->

<body>

<?php include "header.php"?>

<ul class="breadcrumb">
    <a href = "homeWithoutTables.php">Home</a> &gt; &gt;
    <a>Search</a>
</ul>

    <!-- Main Body -->
<main>
	<div id="main">
		<div id="refinecol">
				<form id="refineform">
					<fieldset id="refinefieldset">
						<legend>Refine Results</legend>

            <div id="itemsperpage">
              <p class="refinelabel"><label>Items per Page:</label></p>
							<input type="number" id="iperpage" value="6" min="2" max="25" step="1">
							<output name="price" for="max"></output><br>
            </div>

						<div id="pricerange">
							<p class="refinelabel"><label>Price Range:</label></p>
							<input type="range" id="max" name="pricemax" value="1000">
							<output name="price" for="max"></output><br>
						</div>

						<div id="colourselect">
							<p class="refinelabel"><label id="colour">Colour:</label></p>
							<input type="checkbox" name="colour1" value="Blue"> Blue<br>
							<input type="checkbox" name="colour2" value="Red"> Red<br>
							<input type="checkbox" name="colour3" value="Green"> Green<br>
							<input type="checkbox" name="colour4" value="Orange"> Orange<br>
							<input type="checkbox" name="colour5" value="Purple"> Purple<br>
							<input type="checkbox" name="colour6" value="Red"> Grey<br>
							<input type="checkbox" name="colour7" value="Red"> Black<br>
						</div>
						<div id="colourselect">
							<p class="refinelabel"><label id="colour">Rating:</label></p>
							<input type="checkbox" name="all" value="all"> All<br>
							<input type="checkbox" name="5liams" value="5"> 5 Stars<br>
							<input type="checkbox" name="4liams" value="4"> 4 Stars<br>
							<input type="checkbox" name="3liams" value="3"> 3 Stars<br>
							<input type="checkbox" name="2liams" value="2"> 2 Stars<br>
							<input type="checkbox" name="1liam" value="1"> 1 Star<br>
							<input type="checkbox" name="unrated" value="0"> Unrated<br>
						</div>
					</fieldset>
				</form>
		</div>

  	<div id="categoryviews">
  		<div id="sortby">
  			<p id='searchResultsTitle'>Search Results<?php if(isset($_GET['Search'])) echo " for: &quot;".$_GET['Search']."&quot;";?></p> <!--could include what we searched for in this line. Simple Query, extra -->
    		<form id="sortform">
    			<label id="sortlabel">Sort By:</label>
    			<select name="sort" id="sort">
    				<option value="liamspicks">Liam's Picks</option>
    				<option value="rating">Rating</option>
    				<option value="lowtohigh">Price: Low to High</option>
    				<option value="hightolow">Price: High to Low</option>
    			</select>
    		</form>
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
