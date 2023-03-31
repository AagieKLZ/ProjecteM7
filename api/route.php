<?php

namespace api;

include "dbClient.php";

class route
{

    /**
     * Calculates the route between two stations
     * @param $originStationId int origin station id
     * @param $destinationStationId int destination station id
     * @return array with all routes between the two stations
     */
    public static function calculateRoute(int $originStationId, int $destinationStationId, string $time = null): array
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
                $sql = "SET @st1 = ?;
                    SET @st2 = ?;
                    SET @time = '?';
                    
                    SELECT *
                    FROM schedules s1
                    WHERE station_id = @st1
                      AND time > @time
                      AND route_id IN (SELECT DISTINCT s1.route_id
                                        FROM schedules s1
                                        INNER JOIN routes r ON s1.route_id = r.name
                                        WHERE station_id = @st1
                                        AND route_id IN (SELECT DISTINCT s2.route_id
                                        FROM schedules s2
                                        INNER JOIN routes r ON s2.route_id = r.name
                                        WHERE station_id = @st2))
                      AND s1.stop_number < (SELECT s2.stop_number
                                          FROM schedules s2
                                          WHERE station_id = @st2
                                          AND time > @time
                                          LIMIT 1)
                    ORDER BY time
                    LIMIT 10;";
                $params = [$originStationId, $destinationStationId, $time];
            }
            else {
                $sql = "SET @st1 = ?;
                    SET @st2 = ?;
                    SET @time = '?';
                    
                    SELECT *
                    FROM schedules s1
                    WHERE station_id = @st1
                      AND time > @time
                      AND route_id IN (SELECT DISTINCT s1.route_id
                                        FROM schedules s1
                                        INNER JOIN routes r ON s1.route_id = r.name
                                        WHERE station_id = @st1
                                        AND route_id IN (SELECT DISTINCT s2.route_id
                                        FROM schedules s2
                                        INNER JOIN routes r ON s2.route_id = r.name
                                        WHERE station_id = @st2))
                      AND s1.stop_number > (SELECT s2.stop_number
                                          FROM schedules s2
                                          WHERE station_id = @st2
                                          AND time > @time
                                          LIMIT 1)
                    ORDER BY time
                    LIMIT 10;";
                $params = [$destinationStationId, $originStationId, $time];
            }

            return $db->query($sql, $params);

        } else {
            return [];
        }
    }

}