<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include '../api/rutesTren.php';

use api\rutesTren;

echo "TEST";
?>

<form action="proves.php" method="get">
    <input type="number" name="train">
    <input type="submit" value="Submit">
</form>

<?php

echo json_encode(rutesTren::getRouteByTrain($_GET['train']));