<?php
    include "../api/lines.php";
    use api\lines;
    if (!isset($_POST["direction"])) {
        $direction = "IDA";
    } else {
        $direction = $_POST["direction"];
    }
?>