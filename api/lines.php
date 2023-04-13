<?php

namespace api;

if (!class_exists('dbClient')) {
    require_once('dbClient.php');
}


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

    public static function getDistinctLines(): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT DISTINCT name FROM routes;";
        return $db->query($sql, []);
    }

    public static function getDirections(string $name): array
    {
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

    public static function getAllTrainsBetween(string $origin, string $destiny): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT
            S.train_num,
            S.time AS arrival_time,
            S1.time AS departure_time,
            last_stop AS stops,
            ST1.name AS origin,
            ST2.name AS destiny
        FROM
            schedules AS S
        INNER JOIN(
            SELECT
                train_num,
                MAX(stop_number) AS last_stop
            FROM
                schedules
            GROUP BY
                train_num
        ) AS S2
        ON
            (S2.train_num = S.train_num)
        INNER JOIN(
            SELECT
                train_num,
                time,
                station_id AS first_stop
            FROM
                schedules
            WHERE
                stop_number = 1
        ) AS S1
        ON
            (S1.train_num = S.train_num)
        INNER JOIN stations AS ST1 ON (ST1.id = S1.first_stop)
        INNER JOIN stations AS ST2 ON (ST2.id = S.station_id)
        WHERE
            S.stop_number = S2.last_stop
        AND ST1.name = ? AND ST2.name = ?
        ORDER BY S1.time;";
        return $db->query($sql, [$origin, $destiny]);
    }

    public static function getAllStationsBetween(string $origin, string $destiny): array
    {
        $sql = "SELECT
        stop_number, ST.name
    FROM
        schedules AS S
    INNER JOIN stations AS ST ON (ST.id = S.station_id)
    WHERE
        train_num =(
        SELECT
            train_num
        FROM
            (
            SELECT
                S.train_num,
                S.time AS arrival_time,
                S1.time AS departure_time,
                last_stop AS stops,
                ST1.name AS origin,
                ST2.name AS destiny
            FROM
                schedules AS S
            INNER JOIN(
                SELECT
                    train_num,
                    MAX(stop_number) AS last_stop
                FROM
                    schedules
                GROUP BY
                    train_num
            ) AS S2
        ON
            (S2.train_num = S.train_num)
        INNER JOIN(
            SELECT
                train_num,
                TIME,
                station_id AS first_stop
            FROM
                schedules
            WHERE
                stop_number = 1
        ) AS S1
    ON
        (S1.train_num = S.train_num)
    INNER JOIN stations AS ST1
    ON
        (ST1.id = S1.first_stop)
    INNER JOIN stations AS ST2
    ON
        (ST2.id = S.station_id)
    WHERE
        S.stop_number = S2.last_stop AND ST1.Name = ? AND ST2.name = ?
    ORDER BY
        S1.time
        ) AS T
    HAVING
        (MAX(stops)))
    ORDER BY stop_number;";
        return dbClient::getInstance()->query($sql, [$origin, $destiny]);
    }

    /**
     * Gets the colour of a line
     * @param string $name line name
     * @return string colour
     */
    public static function getLineColour(string $name): string
    {
        $db = dbClient::getInstance();
        $sql = "SELECT colour FROM routes WHERE name = ?;";
        $params = [$name];
        return $db->query($sql, $params)[0]['colour'];
    }
}
