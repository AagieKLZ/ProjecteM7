<?php

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

    public static function getStationById(int $id): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT * FROM stations WHERE id = ?;";
        $result = $db->query($sql, [$id]);
        if (count($result) == 0) {
            return [];
        } 
        return $result[0];
    }

    /**
     * Method to delete a station from the database
     * @param int $id the id of the station
     * @return void
     */
    public static function deleteStation(int $id)
    {
        $db = dbClient::getInstance();
        $sql = "DELETE FROM stations WHERE id = ?;";
        $db->query($sql, [$id]);
    }
}
