<?php

namespace api;

if (!class_exists('dbClient')) {
    require_once('dbClient.php');
}

class route
{

    /**
     * Calculates the route between two stations
     * @param $originStationId int origin station id
     * @param $destinationStationId int destination station id
     * @return array with all routes between the two stations
     */
    public static function calculateRoute(int $originStationId, int $destinationStationId, string $time, int $page): array
    {
        // First check if the stations are in the same line, if they share a route
        $db = dbClient::getInstance();
        $sql = 'SELECT S1.route_id, R.colour, S1.time AS origin_time, S2.time AS destiny_time FROM schedules AS S1
        INNER JOIN schedules AS S2 ON (S1.train_num = S2.train_num) 
        INNER JOIN routes AS R ON (S1.route_id = R.name)
        WHERE S1.station_id = ? AND S2.station_id = ? AND S1.TIME < S2.TIME AND S1.TIME > ?
        ORDER BY S1.TIME LIMIT ? OFFSET ?;
        ';
        $offset = ($page - 1) * 10;
        $size = 10;
        return $db->query($sql, [$originStationId, $destinationStationId, $time, (int) $size, $offset]);
    }

    public static function getNumberOfRoutes(int $originStationId, int $destinationStationId, string $time): int
    {
        // First check if the stations are in the same line, if they share a route
        $db = dbClient::getInstance();
        $sql = 'SELECT COUNT(*) AS count FROM schedules AS S1
        INNER JOIN schedules AS S2 ON (S1.train_num = S2.train_num) 
        INNER JOIN routes AS R ON (S1.route_id = R.name)
        WHERE S1.station_id = ? AND S2.station_id = ? AND S1.TIME < S2.TIME AND S1.TIME > ?;
        ';
        $result = $db->query($sql, [$originStationId, $destinationStationId, $time]);
        if (count($result) == 0) {
            return 0;
        }
        return $result[0]['count'];
    }

    /**
     *
     * @param $name string station name
     * @return array returns an array with the station id
     */
    public static function getStationIdByName(string $name): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT id FROM stations WHERE name = ?;";
        $params = [$name];
        return $db->query($sql, $params);
    }

    /**
     * @param $id int station id
     * @return array returns an array with the station name
     */
    public static function getStationNameById(int $id): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT name FROM stations WHERE id = ?;";
        $params = [$id];
        return $db->query($sql, $params);
    }

    public static function getNextTrainNumber(): int{
        $db = dbClient::getInstance();
        $sql = "SELECT MAX(train_num) as number FROM schedules;";
        $result = $db->query($sql, []);
        return $result[0]['number'] + 1;
    }

    public static function addRoute(string $lane, int $station_id, string $time, int $train, int $stop_n): bool{
        $sql = "INSERT INTO schedules (route_id, station_id, time, train_num, stop_number) VALUES (?, ?, ?, ?, ?);";
        $params = [$lane, $station_id, $time, $train, $stop_n];
        $db = dbClient::getInstance();
        try {
            return $db->insert($sql, $params);
        } catch (\Exception $e) {
            return false;
        }
    }

}
