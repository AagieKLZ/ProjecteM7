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

    /**
     * Method to change the name of a station
     * @param string $newName the new name of the station
     * @param int $id the id of the station
     * @return void
     */
    public static function updateStationName(string $newName, int $id)
    {
        $db = dbClient::getInstance();
        $sql = "UPDATE stations SET name = ? WHERE id = ?;";
        $db->query($sql, [$newName, $id]);
    }

    /**
     * Method to delete a station from the database
     * @param int $id the id of the station
     * @return void
     */
    public static function delete(int $id)
    {
        $db = dbClient::getInstance();
        $sql = "DELETE FROM stations WHERE id = ?;";
        $db->query($sql, [$id]);
    }
}
