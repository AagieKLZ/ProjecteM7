<?php

namespace api;

include "dbClient.php";

class lines
{
    /**
     * Gets all the stations and their connections
     * @return array with all stations and their connections
     */
    public static function getAllStationsWithConnections(): array
    {
        $stations = self::getAllStations();
        return array_map(function ($station) {
            $station["connections"] = (new lines)->getConnectionsOfStation($station["id"]);
            return $station;
        }, $stations);
    }

    /**
     * Gets all the stations and their ids
     * @return array with all stations and their ids
     */
    public static function getAllStations(): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT id, name FROM stations;";
        $stations = $db->query($sql, []);
        usort($stations, function ($a, $b) {
            return $a["name"] <=> $b["name"];
        });
        return $stations;
    }

    /**
     * Gets all the routes where you can transfer from in a station
     * @param int $stationId station id
     * @return array with all routes where you can transfer from in a station
     */
    private function getConnectionsOfStation(int $stationId): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT DISTINCT route_id, colour FROM schedules
        INNER JOIN routes r on schedules.route_id = r.name
        WHERE station_id = ?
        ORDER BY route_id;";
        $params = [$stationId];
        return $db->query($sql, $params);
    }

    /**
     * Gets the origin of a route, given a train number
     * @param $trainNumber int train number
     * @return array with route name, origin station id and name, time
     */
    private function getScheduleOriginByTrainNum(int $trainNumber): array
    {
        $db = dbClient::getInstance();
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
    private function getScheduleDestinationByTrainNum(int $trainNumber): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT route_id, s.id, s.name, time FROM schedules
        INNER JOIN stations s on schedules.station_id = s.id
        WHERE train_num = ?
        ORDER BY stop_number DESC LIMIT 1";
        $params = [$trainNumber];
        return $db->query($sql, $params);
    }

    /**
     * Gets all the routes and their stations
     * @return array with all different lines and their origin and destination
     */
    public static function getLines(): array
    {
        $db = dbClient::getInstance();
        $sql = "CALL list_all_lines()";
        return $db->query($sql, []);        
    }

    public static function getDistinctLines(): array {
        $db = dbClient::getInstance();
        $sql = "SELECT DISTINCT name FROM routes;";
        return $db->query($sql, []);
    }

    public static function getDirections(string $name): array{
        $db = dbClient::getInstance();
        $sql = "CALL get_line_variants(?)";
        $params = [$name];
        return $db->query($sql, $params);
    }

    /**
     * @param $name string route name
     * @return array returns an array with all the stations of a route
     */
    private function getStationsByRoute(string $name): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT DISTINCT station_id, s.name FROM schedules
        INNER JOIN stations s ON s.id = schedules.station_id
        WHERE route_id = ?; ";
        $params = [$name];
        return $db->query($sql, $params);
    }

}