<?php

namespace api;

if (!class_exists('dbClient')) {
    require_once('dbClient.php');
}


class schedules
{
    /**
     * @param $stationsAndTimes array with station ids and times it goes through them [[station_id, time], [station_id, time], ...]
     * @param $routeId string route id
     * @return bool if the schedule was created
     */
    static function createNew(array $stationsAndTimes, string $routeId): bool
    {
        $db = dbClient::getInstance();
        // First we need to get the last train number
        $lastTrainNum = $db->query("SELECT train_num FROM schedules ORDER BY train_num DESC LIMIT 1",[])[0]["train_num"];
        // We convert it to a number and add one
        $trainNum = intval($lastTrainNum) + 1;

        $sql = "INSERT INTO schedules (route_id, station_id, time, train_num, stop_number) VALUES (?, ?, ?, ?, ?)";
        for ($i = 0; $i < count($stationsAndTimes); $i++) {
            try {
                $db->query($sql, [$routeId, $stationsAndTimes[$i][0], $stationsAndTimes[$i][1], $trainNum, $i]);
            } catch (\Exception $e) {
                return false;
            }
        }
        return true;
    }
}

