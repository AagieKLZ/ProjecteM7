<?php

namespace api;

use Exception;
use PDO;

class dbClient
{

    // Db connection config
    private $usuari = "root";
    private $contrasenya;
    private $db = "tenfe";
    private $host = "localhost:3306";

    private $conn;

    private static $instance;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->setPassword("");
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->usuari, $this->contrasenya);
        // Creem les taules si no existeixen
        // $this->createTables();
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new dbClient();
        }

        return self::$instance;
    }

    /**
     * Method to execute a query
     * @param $sql string The query to do without parameters
     * @param $params array The parameters to bind to the query
     * @return array with the results of the query
     */
    public function query($sql, $params)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function insert($sql, $params){
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute($params);
        if ($result) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

    /**
     * Last id inserted in the db
     * @return int the last insert id
     * @throws Exception if there is no last insert id
     */
    public function lastInsertId() {
        $id = $this->conn->lastInsertId();
        if ($id == 0) {
            throw new Exception("No last insert id");
        }
        return $id;
    }

    /**
     * Sets the password
     * @param $password
     * @return void
     */
    private function setPassword($password)
    {
        $this->contrasenya = $password;
    }

    /**
     * Creates the tables if they don't exist
     * @return void
     */
    private function createTables()
    {
        // Get the content of createTables.sql
        $sql = file_get_contents("./api/createTables.sql");
        // Execute the query
        $this->conn->exec($sql);
    }


}