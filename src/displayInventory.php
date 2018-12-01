<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
    <link rel="stylesheet" href="css/displayInventory.css"/>
    <?php include 'includes/headerFooterHead.php'?>



</head>


<!--    Body-->

<body>
<?php include "header.php";?>
<main>

	<p id="warehousepagetitle">Warehouse Product Inventory List <a id='btn' href="../src/adminList.php">Return To Admin</a></p>
    <!--Div that will hold the pie chart-->
    <div id="container">
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>

<!--        <div id="chart_div"></div>-->
<?php
try {
    $inventoryProduct = array();
//        array("label"=> $pname, "y"=> $quantity),
//        array("label"=> "Activities and Entertainments", "y"=> 261),
//        array("label"=> "Health and Fitness", "y"=> 158),
//        array("label"=> "Shopping & Misc", "y"=> 72),
//        array("label"=> "Transportation", "y"=> 191),
//        array("label"=> "Rent", "y"=> 573),
//        array("label"=> "Travel Insurance", "y"=> 126)
//    );


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
//                    $itemName = array('pno'=>$pNo, 'pname'=>$pname, 'qty'=> $quantity);
//                    array("label"=> "Food + Drinks", "y"=> 590),
//                    $itemName = array('pno'=>$pNo, 'pname'=>$pname, 'qty'=> $quantity);
                    $itemName = array("label"=>$pname, "y"=>$quantity);
                    array_push($inventoryProduct, $itemName);

//                    array_push($inventoryProduct, $itemName);

                    echo "<tr><td>" . $pNo . "</td>";
                    echo "<td>" . $pname . "</td>";
                    echo "<td>" . $size . "</td>";
                    echo "<td>" . $quantity . "</td></tr>";
                }
//                $inventoryProduct = array("label"=>$pname, "y"=>$quantity);



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
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            title:{
                text: "QSCU Product/Price Chart"
            },
            subtitles: [{
                text: "Currency Used: Thai Baht (฿) - use the top right button to save as PNG/JPG"
            }],
            data: [{
                type: "pie",
                showInLegend: "true",
                legendText: "{label}",
                indexLabelFontSize: 16,
                indexLabel: "{label} - #percent%",
                yValueFormatString: "฿#,##0",
                dataPoints:
                <?php echo json_encode($inventoryProduct, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
</script>

</body>
<!---->
<!--Load the AJAX API-->
<!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
<!--<script type="text/javascript">-->
<!---->
<!--    // Load the Visualization API and the corechart package.-->
<!--    google.charts.load('current', {'packages':['corechart']});-->
<!---->
<!--    // Set a callback to run when the Google Visualization API is loaded.-->
<!--    google.charts.setOnLoadCallback(drawChart);-->
<!---->
<!--    // Callback that creates and populates a data table,-->
<!--    // instantiates the pie chart, passes in the data and-->
<!--    // draws it.-->
<!--    function drawChart() {-->
<!---->
<!--        // Create the data table.-->
<!--        var data = new google.visualization.DataTable();-->
<!--        // data.addColumn('number', )-->
<!---->
<!--        var inventoryName = $("#inventoryStatusPHP").val();-->
<!--        var inventoryQuantity = $("#inventoryStatusPHP.qty").val();-->
<!---->
<!--        data.addColumn('string', 'Topping');-->
<!--        data.addColumn('number', 'Slices');-->
<!--        data.addRow([inventoryName.val, inventoryQuantity]);-->
<!---->
<!--        //-->
<!--        // data.addRows([-->
<!--        //     ['Mushrooms', 3],-->
<!--        //     ['Onions', 1],-->
<!--        //     ['Olives', 1],-->
<!--        //     ['Zucchini', 1],-->
<!--        //     ['Pepperoni', 2]-->
<!--        // ]);-->
<!---->
<!--        // Set chart options-->
<!--        var options = {'title':'QSCU Store Inventory',-->
<!--            'width':700,-->
<!--            'height':500};-->
<!---->
<!--        // Instantiate and draw our chart, passing in some options.-->
<!--        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));-->
<!--        chart.draw(data, options);-->
<!--    }-->
<!--</script>-->
</html>