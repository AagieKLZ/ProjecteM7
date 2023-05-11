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

    public static function getAllStationsWithConnectionsPaginated(int $page): array
    {
        $stations = self::getAllStationsPaginated($page);
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
        $sql = "SELECT id, name FROM stations ORDER BY name;";
        $stations = $db->query($sql, []);
        usort($stations, function ($a, $b) {
            return $a["name"] <=> $b["name"];
        });
        return $stations;
    }

    public static function getStationNumber(): int
    {
        $db = dbClient::getInstance();
        $sql = "SELECT COUNT(*) AS count FROM stations;";
        $result = $db->query($sql, []);
        if (count($result) == 0) {
            return 0;
        }
        return $result[0]['count'];
    }

    public static function getAllStationsPaginated(int $page): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT id, name FROM stations ORDER BY name LIMIT ? OFFSET ?;";
        $offset = ($page - 1) * 10;
        $size = 10;
        $stations = $db->query($sql, [(int) $size, $offset]);
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
    public static function getConnectionsOfStation(int $stationId): array
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
     * Gets all the routes and their stations
     * @return array with all different lines and their origin and destination
     */
    public static function getLines(): array
    {
        $db = dbClient::getInstance();
        $sql = "CALL list_all_lines()";
        return $db->query($sql, []);
    }

    /**
     * Gets all the routes and their stations
     * @return array with all different lines
     */
    public static function getDistinctLines(): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT DISTINCT name FROM routes;";
        return $db->query($sql, []);
    }

    /**
     * Gets all the line variants of a line
     * @param string $name line name
     * @return array with all the directions of a line
     */
    public static function getDirections(string $name): array
    {
        $db = dbClient::getInstance();
        $sql = "CALL get_line_variants(?)";
        $params = [$name];
        return $db->query($sql, $params);
    }

    /**
     * @param string $origin origin station name
     * @param string $destiny destiny station name
     * @return array with all the trains that pass through the origin and destiny stations
     */
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

    /**
     * @param string $origin origin station name
     * @param string $destiny destiny station name
     * @return array with all the stations between the origin and destiny stations
     */
    public static function getAllStationsBetween(string $origin, string $destiny): array
    {
        $sql = "SELECT
        stop_number, ST.name, ST.id
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
                last_stop AS stops
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

    /**
     * @return array with all the lines
     */
    public static function getAllLines(): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT name, colour FROM routes;";
        return $db->query($sql, []);
    }

    /**
     * @param string $name Name of the line
     * @param string $colour (must be a TailwindCSS colour)
     * @return void
     */
    public static function createNew(string $name, string $colour)
    {
        $db = dbClient::getInstance();
        $sql = "INSERT INTO routes (name, colour) VALUES (?, ?);";
        $params = [$name, $colour];
        $db->query($sql, $params);
    }
}
