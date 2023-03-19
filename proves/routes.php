<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include '../api/trainRoutes.php';

use api\trainRoutes;

echo "TEST PAGE";

$stations = trainRoutes::getAllStations();

?>

<form action='routes.php' method='get'>
    <label>
        ORIGIN:
        <select name='origin'>
            <?php
            foreach ($stations as $station) {
                echo "<option value='" . $station["id"] . "'>" . $station["name"] . "</option>";
            }

            ?>
        </select>
    </label>
    <label>
        DESTINATION:
        <select name='destination'>
            <?php
            foreach ($stations as $station) {
                echo "<option value='" . $station["id"] . "'>" . $station["name"] . "</option>";
            }
            ?>
        </select>
    </label>
    <input type='submit' value='Submit'>
</form>

<?php
if(isset($_GET["origin"]) && isset($_GET["destination"])){
    $origin = $_GET["origin"];
    $destination = $_GET["destination"];
    $routes = trainRoutes::calculateRoute($origin, $destination);

    ?>
<h2>Routes between <?php echo trainRoutes::getStationName($origin)[0]["name"] ?> and <?php echo trainRoutes::getStationName($destination)[0]["name"] ?></h2>

<?php
    echo "<table>";
    echo "<tr><th>Route</th></tr>";
    foreach ($routes as $route) {
        echo "<tr><td>" . $route["route_id"] . "</td>";
        echo "<td>" . $route["time"] . "</td>";
        echo "<td>" . $route["train_num"] . "</td>";
        echo "</tr>";

    }
    echo "</table>";
}