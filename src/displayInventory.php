<?php
$headerSet = 1;
include "includes/init.php";
include "includes/validateAdmin.php";

validateAdminRequest($_SESSION);
$user = null;
$name = null;
if(isset($_SESSION['user'])){
    $user = $_SESSION['user']->id;
    $name = $_SESSION['user']->firstName;
}

$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if($con -> connect_errno){
    die("Connection Failed: ".$con -> connect_errno);
}

?>
<!DOCTYPE HTML>
<html>
<!--    Head-->

<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="css/home.css"/>
    <link rel="stylesheet" href="css/displayInventory.css"/>
    <?php include 'includes/headerFooterHead.php'?>


    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            // data.addColumn('number', )
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
                ['Mushrooms', 3],
                ['Onions', 1],
                ['Olives', 1],
                ['Zucchini', 1],
                ['Pepperoni', 2]
            ]);

            // Set chart options
            var options = {'title':'How Much Pizza I Ate Last Night',
                'width':400,
                'height':300};

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>

</head>


<!--    Body-->

<body>
<?php include "header.php";?>
<main>

	<p id="warehousepagetitle">Warehouse Product Inventory List <a id='btn' href="../src/adminList.php">Return To Admin</a></p>
    <!--Div that will hold the pie chart-->
    <div id="container">
    <div id="chart_div"></div>
<?php
try {


    $sqlWH = "SELECT wNo, location FROM Warehouse";


    $warehouses = array();
    $locs = array();
    if ($WH = $con->prepare($sqlWH)) {
        $WH->execute();
        $WH->bind_result($wNo, $loc);
        while ($WH->fetch()) {
            array_push($warehouses, $wNo);
            array_push($locs, $loc);

        }


        $sqlProds = "SELECT pNo, size, quantity, pname FROM HasInventory NATURAL JOIN Product WHERE wNo = ?";
        $len = count($warehouses);

        for ($x = 0; $x < $len; $x++) {
            echo '<table class="warehousetables"><tr><th>Warehouse Number</th><th>Location</th></tr>';
            echo "<tr><td>" . $warehouses[$x] . "</td>";
            echo "<td>" . $locs[$x] . "</td></tr>";
            echo '<tr><td colspan="4"><table  class="producttables" >';
            echo '<th>Product Id</th><th>Product Name</th> <th>Size</th> <th>Quantity</th></tr>';
            if ($prods = $con->prepare($sqlProds)) {
                $prods->bind_param('i', $warehouses[$x]);
                $prods->execute();

                $prods->bind_result($pNo, $size, $quantity, $pname);

                while ($prods->fetch()) {

                    echo "<tr><td>" . $pNo . "</td>";
                    echo "<td>" . $pname . "</td>";
                    echo "<td>" . $size . "</td>";
                    echo "<td>" . $quantity . "</td></tr>";
                }


            } else {
                die();
            }


            echo "</table></td></tr>";

        }
    } else {
        throw new Exception();
    }

    echo "</table>";
    $con->close();
}
catch(Exception $e) {
    $con->close();
    header("Location: adminList.php");
    exit();
}
?>
    </div>
</main>

<?php
include "footer.php";
?>

</body>
</html>