<?php
include "includes/init.php";
include "header.php";
?>
<!DOCTYPE HTML>

<html>
<head lang="en">
    <meta charset="utf-8">
        <link rel="stylesheet" href="css/error.css"/>
    <title>QSCU Merch Store</title>
    <?php include 'includes/headerFooterHead.php'; ?>
    <link rel="icon" type="image/x-icon" href="../src/images/QSCU_favicon.png"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<body>
<ul class="breadcrumb">
    <a href="homeWithoutTables.php">Home</a> &gt; &gt; <a>error404</a>
</ul>
<main>
    <div class="bigboi">
        <div id="content" class="error404">
            <h1>PAGE NOT FOUND (ERROR 404)</h1>

            <div class="entry-content">
                <p>Oops, the page you are looking for is not available.
                    <br>
                    Sorry about that.
                    <br>
                    Go back to the <a href="homeWithoutTables.php">home page</a>!</p>

                <img style="max-width: 50%;" src="resources/yikes-shrug.gif">
            </div>
        </div>
    </div>
</main>
</body>

</html>

<?php
include "footer.php";
?>


