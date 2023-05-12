<?php

namespace api;

use Exception;
use PDO;

class dbClient
{

    // Db connection config
    private static $instance;
    private $usuari = "root";
    private $contrasenya;
    private $db = "tenfe2";
    private $host = "localhost:3306";
    private $conn;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->setPassword("");
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->usuari, $this->contrasenya, $options);
        // Creem les taules si no existeixen
        // $this->createTables();
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

    public static function getInstance(): dbClient
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
    public function query($sql, $params): array
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function insert($sql, $params): bool
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute($params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function debug($sql, $params) : string
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute($params);
            return $result;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Last id inserted in the db
     * @return int the last insert id
     * @throws Exception if there is no last insert id
     */
    public function lastInsertId(): int
    {
        $id = $this->conn->lastInsertId();
        if ($id == 0) {
            throw new Exception("No last insert id");
        }
        return $id;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return void
     */
    public function delete(string $sql, array $params)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
    }

}
