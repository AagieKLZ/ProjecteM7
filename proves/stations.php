<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include '../api/trainRoutes.php';

use api\trainRoutes;

echo "TEST PAGE";

$stations = trainRoutes::getAllStationsWithConnections();

echo "<table>";
echo "<tr><th>Station</th><th>Connections</th></tr>";
foreach ($stations as $station) {
    echo "<tr><td>" . $station["name"] . "</td><td>";
    foreach ($station["connections"] as $connection) {
        echo $connection["route_id"];
        echo " ";
        echo $connection["colour"];
    }
    echo "</td></tr>";
}