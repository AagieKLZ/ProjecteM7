<?php

namespace api;

include "dbClient.php";

class lines
{
    /**
     * Gets all the stations and their connections
     * @return array with all stations and their connections
     */
    static function getAllStationsWithConnections(): array
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
    static function getAllStations(): array
    {
        $db = new dbClient();
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
        $db = new dbClient();
        $sql = "SELECT DISTINCT route_id, colour FROM schedules
        INNER JOIN routes r on schedules.route_id = r.name
        WHERE station_id = ?
        ORDER BY route_id;";
        $params = [$stationId];
        return $db->query($sql, $params);
    }

    /**
     * Calculates the route between two stations
     * @param $originStationId int origin station id
     * @param $destinationStationId int destination station id
     * @return array with all routes between the two stations
     */
    static function calculateRoute(int $originStationId, int $destinationStationId, string $time = null): array
    {
        // First check if the stations are in the same line, if they share a route
        $db = new dbClient();
        $sql = "SELECT DISTINCT route_id FROM schedules
        WHERE station_id = ?;";
        // Get all the routes that pass through the origin and destination stations
        $params = [$originStationId];
        $originRoutes = $db->query($sql, $params);
        $params = [$destinationStationId];
        $destinationRoutes = $db->query($sql, $params);
        // Get the routes that pass through both stations
        $common = array_intersect(array_column($originRoutes, "route_id"), array_column($destinationRoutes, "route_id"));

        // If they have common routes
        if (count($common) > 0) {

            // Get the next train for each route
            $results = [];

            if ($originStationId < $destinationStationId) {
                $sql = "SELECT route_id, time, train_num, stop_number FROM schedules
                    WHERE route_id = ?
                    # Origin station
                    AND station_id = ?
                    AND time > ?
                    AND stop_number < (
                        SELECT stop_number FROM schedules
                        WHERE route_id = ?
                        # Destination station
                        AND station_id = ?
                        AND time > ?
                        LIMIT 1
                        )
                    LIMIT 3;";
            } else {
                $sql = "SELECT route_id, time, train_num, stop_number FROM schedules
                    WHERE route_id = ?
                    # Origin station
                    AND station_id = ?
                    AND time > ?
                    AND stop_number > (
                        SELECT stop_number FROM schedules
                        WHERE route_id = ?
                        # Destination station
                        AND station_id = ?
                        AND time > ?
                        LIMIT 1
                        )
                    LIMIT 10;";
            }

            // If time is not set, set it to the current time
            if ($time == null) {
                $time = date("H:i");
            }

            for ($i = 0; $i < count($common); $i++) {
                $params = [$common[$i], $originStationId, $time, $common[$i], $destinationStationId, $time];
                for ($j = 0; $j < count($db->query($sql, $params)); $j++) {
                    $results[] = $db->query($sql, $params)[$j];
                }
            }

            // Sort the results by time
            usort($results, function ($a, $b) {
                return $a["time"] <=> $b["time"];
            });
            // Return the first 5 results
//            return array_slice($results, 0, 5);
            return $results;
        } else {
            return [];
        }
    }

    /**
     * Gets the origin of a route, given a train number
     * @param $trainNumber int train number
     * @return array with route name, origin station id and name, time
     */
    private function getScheduleOriginByTrainNum(int $trainNumber): array
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
    private function getScheduleDestinationByTrainNum(int $trainNumber): array
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
     * Gets all the routes and their stations
     * @return array with all different lines and their origin and destination
     */
    private function getLines(): array
    {
        $db = new dbClient();
        $sql = "SELECT name FROM routes;";
        $routes = $db->query($sql, []);
        // TODO TO BE FINISHED
    }

    /**
     * @param $name string route name
     * @return array returns an array with all the stations of a route
     */
    private function getStationsByRoute(string $name): array
    {
        $db = new dbClient();
        $sql = "SELECT DISTINCT station_id, s.name FROM schedules
        INNER JOIN stations s ON s.id = schedules.station_id
        WHERE route_id = ?; ";
        $params = [$name];
        return $db->query($sql, $params);
    }

}