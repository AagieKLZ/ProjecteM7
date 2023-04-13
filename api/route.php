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
    public static function calculateRoute(int $originStationId, int $destinationStationId, string $time): array
    {
        // First check if the stations are in the same line, if they share a route
        $db = dbClient::getInstance();
        $sql = "SELECT DISTINCT route_id, colour
            FROM schedules
            INNER JOIN routes r ON schedules.route_id = r.name
            WHERE station_id = ?
            AND route_id IN (SELECT DISTINCT route_id
            FROM schedules
            INNER JOIN routes r ON schedules.route_id = r.name
            WHERE station_id = ?);";
        $common = $db->query($sql, [$originStationId, $destinationStationId]);
        // In case they share at least one route, we get trains that go from the origin to the destination
        if (count($common) > 0) {
            $sql = "";
            $params = [];
            if ($originStationId < $destinationStationId) {
                $sql = "SELECT *
                    FROM schedules s1
                    WHERE station_id = ?
                      AND time > ?
                      AND route_id IN (SELECT DISTINCT s1.route_id
                                        FROM schedules s1
                                        INNER JOIN routes r ON s1.route_id = r.name
                                        WHERE station_id = ?
                                        AND route_id IN (SELECT DISTINCT s2.route_id
                                        FROM schedules s2
                                        INNER JOIN routes r ON s2.route_id = r.name
                                        WHERE station_id = ?))
                      AND s1.stop_number < (SELECT s2.stop_number
                                          FROM schedules s2
                                          WHERE station_id = ?
                                          AND time > ?
                                          LIMIT 1)
                    ORDER BY time
                    LIMIT 10;";
                $params = [$originStationId, $time, $originStationId, $destinationStationId, $destinationStationId, $time];

            } else {
                $sql = "SELECT *
                    FROM schedules s1
                    WHERE station_id = ?
                      AND time > ?
                      AND route_id IN (SELECT DISTINCT s1.route_id
                                        FROM schedules s1
                                        INNER JOIN routes r ON s1.route_id = r.name
                                        WHERE station_id = ?
                                        AND route_id IN (SELECT DISTINCT s2.route_id
                                        FROM schedules s2
                                        INNER JOIN routes r ON s2.route_id = r.name
                                        WHERE station_id = ?))
                      AND s1.stop_number > (SELECT s2.stop_number
                                          FROM schedules s2
                                          WHERE station_id = ?
                                          AND time > ?
                                          LIMIT 1)
                    ORDER BY time
                    LIMIT 10;";
                $params = [$destinationStationId, $time, $destinationStationId, $originStationId, $originStationId, $time];
            }

            return $db->query($sql, $params);

        } else {
            return [];
        }
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

    /**
     * Method to get the time a train passes by a station
     * @param int $trainNum
     * @param int $station
     * @return array
     */
    public static function getTimeByTrainNumPassingByStation(int $trainNum, int $station): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT time FROM schedules WHERE train_num = ? AND station_id = ?;";
        $params = [$trainNum, $station];
        return $db->query($sql, $params);
    }

}