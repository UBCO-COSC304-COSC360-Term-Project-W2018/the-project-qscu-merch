<?php
$user = isset($_SESSION["userId"]) ? $_SESSION['userId'] : null;
$name = isset($_SESSION["fName"]) ? $_SESSION["fName"] : null;
?>

<!--HTML home page for shop.qscu.org-->
<!DOCTYPE HTML>
<html lang="en">

<header>
    <div id="htop">
        <a href="homeWithoutTables.php" id="logo"><img id="headerIcon" src="images/QSCU_whitePlain.png"
                                                       alt="Quantitative Sciences Course Union"/> </a>
        <h1 id="title">QSCU Merchandise Store</h1>
    </div>

    <div id="hbot"><?php
        if ($headerSet == 1) {
            echo '<div id="variablebutton" class="hbotline">
                			<a href="homeWithoutTables.php" id="homebutton">Home</a>
							</div>';
        } else {
            echo '<div id="variablebutton" class="hbotline">
	            		<div id="browsedropsection">
							<p id="browsedropbutton">Browse</p>
						</div>
					</div>';
        }
        ?>


        <div id="searchbar" class="hbotline">
            <form id="searchform">
                <label id="search" for="textinput">Search: </label>
                <input type="text" name="Search" id="textinput"/>
                <a href="searchpage.php" id="searchicon"><i class="fa fa-search"></i></a>
            </form>
        </div>

        <div id="profile" class="hbotline">
            <a href="cart.php"><img src="images/shoppingcart.png" alt="shopping cart icon" id="shoppingcart"/></a>

            <?php
            if (isset($_SESSION["fName"])) {
                echo "<a href='profile.php'>" . $name . "</a><a id='logout' href='../src/action/logout.php'>Logout</a>";
            } else {
                echo "<a href='login.php'>Login</a>";
            }
            ?>

        </div>

    </div>
</header>

