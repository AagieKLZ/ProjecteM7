<?php
    include("../api/route.php");
    use api\route;

    if (isset($_POST["departure"]) && isset($_POST["arrival"]) && isset($_POST["train_n"]) && isset($_POST["origin"]) && isset($_POST["destiny"]) && isset($_POST["line"]) && isset($_POST["direction"])){
        $origin = route::getStationIdByName($_POST["origin"])[0]["id"];
        $destiny = route::getStationIdByName($_POST["destiny"])[0]["id"];
        $regex = '/^([0-5][0-9]):([0-5][0-9])$/';
        
        if (!preg_match($regex, $_POST["departure"]) || !preg_match($regex, $_POST["arrival"])){
            header("Location: ./view.php?success=false&action=edit&lane=" . $_POST["line"] . "&origin=" . urlencode($_POST["origin"]) . "&destiny=" . urlencode($_POST["destiny"]) . "&direction=" . $_POST["direction"]);
            exit();
        }
        $date1 = new DateTime($_POST["departure"]);
        $date2 = new DateTime($_POST["arrival"]);
        if ($date1 > $date2){
            header("Location: ./view.php?success=false&action=edit&lane=" . $_POST["line"] . "&origin=" . urlencode($_POST["origin"]) . "&destiny=" . urlencode($_POST["destiny"]) . "&direction=" . $_POST["direction"]);
            exit();
        }
        if (route::changeTime($_POST["train_n"], $origin, $_POST["departure"]) && route::changeTime($_POST["train_n"], $destiny, $_POST["arrival"])){
            header("Location: ./view.php?success=true&action=edit&lane=" . $_POST["line"] . "&origin=" . urlencode($_POST["origin"]) . "&destiny=" . urlencode($_POST["destiny"]) . "&direction=" . $_POST["direction"]);
        } else {
            header("Location: ./view.php?success=false&action=edit&lane=" . $_POST["line"] . "&origin=" . urlencode($_POST["origin"]) . "&destiny=" . urlencode($_POST["destiny"]) . "&direction=" . $_POST["direction"]);
        }
    } else {
        header("Location: ./view.php?success=false&action=edit&lane=" . $_POST["line"] . "&origin=" . urlencode($_POST["origin"]) . "&destiny=" . urlencode($_POST["destiny"]) . "&direction=" . $_POST["direction"]);
    }