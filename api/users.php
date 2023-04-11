<?php

namespace api;

use Exception;

if (!class_exists('dbClient')) {
    require_once('dbClient.php');
}


class users
{
    /**
     * @param $name string the name of the user
     * @param $email string the email of the user
     * @param $password string the password of the user without encryption
     * @param $lines array the lines the user is able to edit
     * @return bool if the user was created
     */
    public static function createNew(string $name, string $email, string $password, array $lines): bool
    {
        $db = dbClient::getInstance();

        // Create the new user
        $sql = "INSERT INTO users (name, password, email) VALUES (?, ?, ?)";
        $params = [$name, $email, $password];
        try {
            $db->query($sql, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return array with all the users (user_admin)
     */
    public static function getAll(): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT * FROM user_admin";
        $params = [];
        return $db->query($sql, $params);
    }

    /**
     * @return array with all the users (users)
     */
    public static function getUsers(): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT * FROM users";
        $params = [];
        return $db->query($sql, $params);
    }

    /**
     * @param string $email email of the user
     * @param string $password password of the user
     * 
     * @return bool if the user exists and the password is correct
     */
    public static function logIn(string $email, string $password): bool
    {
        $db = dbClient::getInstance();
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $params = [$email, $password];
        $result = $db->query($sql, $params);
        if (count($result) == 1) {
            return true;
        }
        return false;
    }

    public static function create(string $name, string $email, string $password): bool{
        $db = dbClient::getInstance();
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $params = [$name, $email, $password];
        try {
            return $db->insert($sql, $params);
        } catch (Exception $e) {
            return false;
        }
    }
}