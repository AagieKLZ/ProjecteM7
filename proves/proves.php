<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include '../api/trainLines.php';

use api\trainLines;

echo "TEST";
?>

<form action="proves.php" method="get">
    <input type="number" name="train">
    <input type="submit" value="Submit">
</form>

<?php

echo json_encode(trainLines::getRouteByTrainNumber($_GET['train']));