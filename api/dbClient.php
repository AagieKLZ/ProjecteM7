<?php

namespace api;

use PDO;

class dbClient
{

    // Db connection config
    private $usuari = "root";
    private $contrasenya = "123321";
    private $db = "tenfe";
    private $host = "localhost:3306";

    private $conn;

    /**
     * Class constructor
     */
    function __construct()
    {
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->usuari, $this->contrasenya);
        // Creem les taules si no existeixen
        $this->createTables();
    }

    /**
     * Creates the tables if they don't exist
     * @return void
     */
    private function createTables()
    {
        $sql = "CREATE TABLE if not exists stations
(
    id   int         not null auto_increment,
    name varchar(50) not null,
    PRIMARY KEY (id)
);

CREATE TABLE if not exists routes
(
    id   int        not null auto_increment,
    name varchar(3) not null,
    colour varchar(20) not null,
    PRIMARY KEY (id),
    INDEX (name)
);

CREATE TABLE if not exists schedules
(
    route_id    varchar(3) not null,
    station_id  int        not null,
    time        varchar(5) not null,
    train_num    int        not null,
    stop_number smallint   not null,
    FOREIGN KEY (route_id) REFERENCES routes (name),
    FOREIGN KEY (station_id) REFERENCES stations (id)
);

CREATE TABLE if not exists users
(
    id       int          not null auto_increment,
    name     varchar(255) not null,
    password varchar(255) not null,
    email    varchar(255) not null,
    PRIMARY KEY (id)
);";
        $this->conn->exec($sql);
    }


    /**
     * Method to execute a query
     * @param $sql string The query to do without parameters
     * @param $params array The parameters to bind to the query
     * @return array with the results of the query
     */
    function query($sql, $params)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}