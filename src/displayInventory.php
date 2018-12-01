<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "includes/init.php";
include "includes/validateAdmin.php";

validateAdminRequest($_SESSION);
$user = null;
$name = null;
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user']->id;
    $name = $_SESSION['user']->firstName;
}

$con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if ($con->connect_errno) {
    die("Connection Failed: " . $con->connect_errno);
}

?>
<!DOCTYPE HTML>
<html>
<!--    Head-->

<head lang="en">
    <meta charset="utf-8">
    <title>QSCU Merch Store</title>
    <link rel="stylesheet" href="css/displayInventory.css"/>
    <?php include 'includes/headerFooterHead.php' ?>

</head>

<!--    Body-->

<body>
<?php include "header.php"; ?>
<main>

    <p id="warehousepagetitle">Warehouse Product Inventory List <a id='btn' href="../src/adminList.php">Return To
            Admin</a></p>
    <!--Div that will hold the pie chart-->
    <div id="container">
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>

        <?php
        try {
            $inventoryProduct = array();

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
                            //TODO: THIS IS THE GRAPH INPUTS
                            $itemName = array("label" => $pname, "y" => $quantity);
                            array_push($inventoryProduct, $itemName);

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
        } catch (Exception $e) {
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
            title: {
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
</html>