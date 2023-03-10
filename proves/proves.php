<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include '../api/trainRoutes.php';

use api\trainRoutes;

echo "TEST PAGE";
?>

    <form action="proves.php" method="get">
        <label for="train">Enter train number to see all stops:</label>
        <label>
            <input type="number" name="train">
        </label>
        <input type="submit" value="Submit">
    </form>

    <form action="proves.php" method="get">
        <label for="station">Enter station id to see all routes:</label>
        <label>
            <input type="number" name="station">
        </label>
        <label>
            <select name="time">
                <option value="now">Now</option>
                <?php
                for ($i = 0; $i < 24; $i++) {
                    for ($j = 0; $j < 60; $j += 30) {
                        $time = sprintf("%02d:%02d", $i, $j);
                        echo "<option value='$time'>$time</option>";
                    }
                }
                ?>
            <input type="submit" value="Submit">
        </label></form>

    Or select an station:
    <form action="proves.php" method="get">
        <?php
        $stations = trainRoutes::getAllStations();
        echo "<select name='station'>";
        foreach ($stations as $station) {
            echo "<option value='" . $station["id"] . "'>" . $station["name"] . "</option>";
        }
        echo "</select>";
        ?>
        <input type="submit" value="Submit">
    </form>


<style>
    table {
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
        padding: 0.85rem;
    }
</style>

<?php

if (isset($_GET["train"])) {
    $trainNumber = $_GET["train"];
    $stops = trainRoutes::getRouteByTrainNumber($trainNumber);
    echo "<h2>Stops of train $trainNumber</h2>";
    echo "<table>";
    echo "<tr><th>Route</th><th>Station</th><th>Time</th></tr>";
    foreach ($stops as $stop) {
        echo "<tr><td>" . $stop["route_id"] . "</td><td>" . $stop["name"] . "</td><td>" . $stop["time"] . "</td></tr>";
    }
    echo "</table>";
}

if (isset($_GET["station"]) && !empty($_GET["station"])) {
    $stationId = $_GET["station"];
    $time = $_GET["time"];
    if ($time == "now") {
        $routes = trainRoutes::getRoutesByStationId($stationId);
    } else {
        $routes = trainRoutes::getRoutesByStationId($stationId, $time);
    }
    $stationName = trainRoutes::getStationName($stationId)[0]["name"];
    echo "<h2>Routes that pass through station $stationId, $stationName</h2>";
    echo "<table>";
    echo "<tr><th>Route</th><th>Time</th><th>Train</th><th>Origin</th><th>Destination</th></tr>";
    foreach ($routes as $route) {
        echo "<tr><td>" . $route["route_id"] . "</td><td>" . $route["time"] . "</td><td>" . $route["train_num"] . "</td><td>" . $route["origin"][0]["name"] . "</td><td>" . $route["destination"][0]["name"] . "</td></tr>";
    }
    echo "</table>";
}