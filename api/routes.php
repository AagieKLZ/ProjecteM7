<?php

namespace api;
include "./db/dbClient.php";

class routes
{
    function getRouteByTrain($train) {
        $sql = 'SELECT * FROM horarios WHERE id_viaje = ? ORDER BY orden';
    }
}