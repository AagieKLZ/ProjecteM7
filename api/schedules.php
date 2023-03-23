<?php

namespace api;

include "dbClient.php";

class schedules
{
    /**
     * @param $stationsAndTimes array with station ids and times it goes through them
     * @param $routeId string route id
     * @return bool if the schedule was created
     */
    static function createNew(array $stationsAndTimes, string $routeId): bool
    {
        $db = new dbClient();
        $sql = "INSERT INTO schedules (route_id, station_id, time, stop_number) VALUES (?, ?, ?, ?)";
        $params = [];
        foreach ($stationsAndTimes as $stationAndTime) {
            $params[] = [$routeId, $stationAndTime["station_id"], $stationAndTime["time"], $stationAndTime["stop_number"]];
        }
        $db->query($sql, $params);
        // TODO Finish this
    }

    /**
     * @param int $trainNum the train number to modify
     * @param string $time the new departure time
     * @return bool if the departure time was modified
     */
    static function modifyDepartureTime(int $trainNum, string $time): bool
    {

    }
}

