<?php
    include("../api/route.php");
    use api\route;
    $departure = $_POST["departure"];
    $arrival = $_POST["arrival"];
    $duration = $_POST["duration"];
    $origin = $_POST["origin_id"];
    $destiny = $_POST["destiny_id"];
    $train_n = route::getNextTrainNumber();
    $lane = $_POST["lane"];
    $stations = array();
    array_push($stations, $origin);
    foreach (array_keys($_POST) as $station) {
        if ($station != "departure" && $station != "arrival" && $station != "duration" && $station != "origin_id" && $station != "destiny_id" && $station != "lane"){
            array_push($stations, $station);
        }
    }
    array_push($stations, $destiny);
    foreach ($stations as $i => $station) {
            $date1 = new DateTime($departure);
            $date1->modify('+'.$duration*($i).' minutes');
            $station_time = $date1->format('H:i');
            route::addRoute($lane, $station, $station_time, $train_n, ($i+1));
    }
    header("Location: ../schedule/view.php");
?>