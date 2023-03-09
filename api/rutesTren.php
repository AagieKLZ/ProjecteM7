<?php

namespace api;

include "dbClient.php";

class rutesTren
{
    static function getRouteByTrain($train)
    {
        $db = new dbClient();
        $sql = "SELECT linia, nom, hora
FROM horarios
         INNER JOIN parades ON horarios.id_parada = parades.id_parada
WHERE id_viaje = ?
ORDER BY orden;";
        $params = [$train];
        return $db->query($sql, $params);
    }
}