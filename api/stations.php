<?php

namespace api;

namespace api;

if (!class_exists('dbClient')) {
    require_once('dbClient.php');
}

class stations
{
    /**
     * Method to create a new station in the database
     * @param string $stationName the name of the station
     * @return void
     */
    public static function createNew(string $stationName)
    {
        $db = dbClient::getInstance();
        $sql = "INSERT INTO stations (name) VALUES (?);";
        $db->query($sql, [$stationName]);
    }
}
