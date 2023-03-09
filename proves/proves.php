<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include '../api/rutesTren.php';

use api\rutesTren;

echo "TEST";
$res = rutesTren::getRouteByTrain(150);
// Display the result as a table
echo "<table border='1'>";
foreach ($res as $row) {
    echo "<tr>";
    foreach ($row as $field) {
        echo "<td>" . $field . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
