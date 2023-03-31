<?php
    $origin = $_POST['origin'];
    $destiny = $_POST['destiny'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    include "../api/route.php";
    use api\route;
    $origin_id = route::getStationIdByName($origin)[0]["id"];
    $destiny_id = route::getStationIdByName($destiny)[0]["id"];
    header("Location: ../schedule.php?origin=$origin_id&destiny=$destiny_id&date=$date&time=$time");