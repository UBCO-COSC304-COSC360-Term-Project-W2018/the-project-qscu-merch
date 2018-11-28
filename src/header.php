<?php
if(!isset($isImportAdmin)){
    include 'includes/validateAdmin.php';
}
$user = null;
$name = null;
if(isset($_SESSION['user'])){
    $user = $_SESSION['user']->id;
    $name = $_SESSION['user']->firstName;
}
?>

<header>
    <div id="htop">
        <a href="homeWithoutTables.php" id="logo"><img id="headerIcon" src="images/QSCU_whitePlain.png"
                                                       alt="Quantitative Sciences Course Union"/> </a>
        <h1 id="title">QSCU Merchandise Store</h1>
    </div>

</header>
<header class="sticky top">
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
            <form id="searchform" action="searchpage.php" method="get">
                <label id="search" for="textinput">Search: </label>
                <input type="text" name="Search" id="textinput"/>
                <a href="searchpage.php" id="searchicon"><i class="fa fa-search"></i></a>
            </form>
        </div>

        <div id="profile" class="hbotline">
            <a href="viewCart.php"><img src="images/shoppingcart.png" alt="shopping cart icon" id="shoppingcart"/></a>

            <?php
            if (isset($user)) {
                if(isAdmin($user)){
                    echo "<a href='profile.php'>" . $name . "</a><a id='admin' href='adminList.php'>Admin</a><a id='logout' href='../src/action/logout.php'>Logout</a>";
                }else{
                    echo "<a href='profile.php'>" . $name . "</a><a id='logout' href='../src/action/logout.php'>Logout</a>";
                }

            } else {
                echo "<a href='login.php'>Login</a>";
            }
            ?>

        </div>

    </div>
</header>