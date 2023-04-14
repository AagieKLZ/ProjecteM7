<?php
    include("../api/route.php");
    include("../api/lines.php");
    use api\route;
    use api\lines;
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
    $origin_st = route::getStationNameById($origin)[0]['name'];
    $destiny_st = route::getStationNameById($destiny)[0]['name'];
    $variants = lines::getDirections($lane);
    foreach ($variants as $i => $variant) {
        if ($variant['Origin'] == $origin_st && $variant['Destiny'] == $destiny_st){
            $direction = $i;
        }
    }
    
    header("Location: ../schedule/view.php?lane=$lane&origin=$origin_st&destiny=$destiny_st&direction=$direction&success=true&action=new");
?>