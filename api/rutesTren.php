<?php

namespace api;

include "dbClient.php";

class rutesTren
{
    /**
     * @param $trainId int id del tren
     * @return mixed array amb la ruta del tren i la hora de cada parada
     */
    static function getRouteByTrain($trainId)
    {
        $db = new dbClient();
        $sql = "SELECT linia, parades.id_parada, nom, hora
        FROM horarios
        INNER JOIN parades ON horarios.id_parada = parades.id_parada
        WHERE id_viaje = ?
        ORDER BY orden;";
        $params = [$trainId];
        return $db->query($sql, $params);
    }

    static function getRoutesByStationId($stationId)
    {
        $db = new dbClient();
    }

    private function getRouteOrigin($trainId)
    {
        $db = new dbClient();

    }

    private function getRouteDestination($trainId)
    {
        $db = new dbClient();
        $sql = "SELECT linia, horarios.id_parada, p.nom, hora FROM horarios
        INNER JOIN parades p on horarios.id_parada = p.id_parada
        WHERE id_viaje = ?
        ORDER BY orden DESC LIMIT 1;";
        $params = [$trainId];
        return $db->query($sql, $params);
    }
}