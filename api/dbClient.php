<?php

namespace api;

use PDO;

class dbClient
{

    // Configuracio de la conexio a la db
    private $usuari = "root";
    private $contrasenya = "123321";
    private $db = "tenfe";
    private $host = "localhost:3306";

    private $conn;

    /**
     * Constructor de la classe
     */
    function __construct()
    {
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->usuari, $this->contrasenya);
        // Creem les taules si no existeixen
        $this->createTables();
    }

    /**
     * Metode per crear les taules si no existeixen
     * @return void
     */
    private function createTables()
    {
        $sql = "CREATE TABLE if not exists parades
            (
                id_parada int         not null auto_increment,
                nom       varchar(50) not null,
                PRIMARY KEY (id_parada)
            );
            
            CREATE TABLE if not exists linies
            (
                id  int        not null auto_increment,
                nom varchar(3) not null,
                PRIMARY KEY (id),
                INDEX (nom)
            );
            
            CREATE TABLE if not exists horarios
            (
                linia     varchar(3)                   not null,
                id_parada int                          not null,
                hora      varchar(5)                   not null,
                id_viaje  int                          not null,
                orden     smallint                     not null,
                FOREIGN KEY (linia) REFERENCES linies (nom),
                FOREIGN KEY (id_parada) REFERENCES parades (id_parada)
            );
            
            CREATE TABLE if not exists usuarios
            (
                id_usuario int          not null auto_increment,
                nombre     varchar(255) not null,
                password   varchar(255) not null,
                email      varchar(255) not null,
                PRIMARY KEY (id_usuario)
            );";
        $this->conn->exec($sql);
    }


    /**
     * Metode per fer queries a la db
     * @param $sql string Query a fer (sql)
     * @param $params array Parametres de la query (valors)
     * @return mixed Resultat de la query
     */
    function query($sql, $params)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}