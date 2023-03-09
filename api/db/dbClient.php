<?php

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
        $this->conn = PDO("mysql:host=$this->host;dbname=$this->db", $this->usuari, $this->contrasenya);
        // Creem les taules si no existeixen
        $this->createTables();
    }

    /**
     * Metode per crear les taules si no existeixen
     * @return void
     */
    private function createTables()
    {
        $sql = readfile("./createTables.sql");
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
        $this->conn->prepare($sql)->execute($params);
    }

}