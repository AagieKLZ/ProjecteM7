<?php
include '../api/stations.php';

use api\stations;

if (isset($_POST["station"])){
    stations::createNew($_POST["station"]);
}

header("Location: view.php?success=true&station=".$_POST["station"]);
exit();
?>