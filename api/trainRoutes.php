<?php

namespace api;

include "dbClient.php";

class trainRoutes
{
    /**
     * Gets all the stops of a route and its times, given a train number
     * @param $trainNumber int train number
     * @return array with route name, destination station id and name, time, each row is a stop,
     */
    static function getRouteByTrainNumber(int $trainNumber): array
    {
        $db = new dbClient();
        $sql = "SELECT route_id, station_id,  name, time, stop_number
        FROM schedules
        INNER JOIN stations ON station_id = stations.id
        WHERE train_num = ?
        ORDER BY stop_number;";
        $params = [$trainNumber];
        return $db->query($sql, $params);
    }

    /**
     * Gets all the routes that pass through a station, given a station id
     * @param $stationId int station id
     * @return array with all routes that pass through the station, each row is a route [route, time it passes, train number, origin, destination]
     */
    static function getRoutesByStationId(int $stationId, string $time = null): array
    {
        if ($time == null) {
            $time = date("H:i:s");
        }
        $db = new dbClient();
        $sql = "SELECT route_id, time, train_num FROM schedules
        WHERE station_id = ?
        AND time > ?
        ORDER BY time
        LIMIT 10;";
        $params = [$stationId, $time];
        $routes = $db->query($sql, $params);
        // Maps routes and add origin and destination
        return array_map(function ($route) {
            $route["origin"] = (new trainRoutes)->getRouteOrigin($route["train_num"]);
            $route["destination"] = (new trainRoutes)->getRouteDestination($route["train_num"]);
            return $route;
        }, $routes);
    }

    /**
     * Gets the origin of a route, given a train number
     * @param $trainNumber int train number
     * @return array with route name, origin station id and name, time
     */
    private function getRouteOrigin(int $trainNumber): array
    {
        $db = new dbClient();
        $sql = "SELECT route_id, s.id, s.name, time FROM schedules
        INNER JOIN stations s on schedules.station_id = s.id
        WHERE train_num = ?
        ORDER BY stop_number LIMIT 1";
        $params = [$trainNumber];
        return $db->query($sql, $params);
    }

    /**
     * Gets the final destination of a route, given a train number
     * @param $trainNumber int train number
     * @return array with route name, destination station id and name, time
     */
    private function getRouteDestination(int $trainNumber): array
    {
        $db = new dbClient();
        $sql = "SELECT route_id, s.id, s.name, time FROM schedules
        INNER JOIN stations s on schedules.station_id = s.id
        WHERE train_num = ?
        ORDER BY stop_number DESC LIMIT 1";
        $params = [$trainNumber];
        return $db->query($sql, $params);
    }

    /**
     * Gets the name of a station, given a station id
     * @param $stationId int station id
     * @return array with station name
     */
    static function getStationName(int $stationId): array
    {
        $db = new dbClient();
        $sql = "SELECT name FROM stations WHERE id = ?;";
        $params = [$stationId];
        return $db->query($sql, $params);
    }

    /**
     * Gets all the stations and their ids
     * @return array with all stations and their ids
     */
    static function getAllStations(): array
    {
        $db = new dbClient();
        $sql = "SELECT id, name FROM stations;";
        $stations = $db->query($sql,[]);
        usort($stations, function ($a, $b) {
            return $a["name"] <=> $b["name"];
        });
        return $stations;
    }


}