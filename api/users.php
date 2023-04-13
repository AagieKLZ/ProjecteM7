<?php

namespace api;

use Exception;

if (!class_exists('dbClient')) {
    require_once('dbClient.php');
}


class users
{
    /**
     * Method to get an array of users (user_admin)
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
     * Method to get an array of users
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
     * Method to log in a user
     * @param string $email email of the user
     * @param string $password password of the user
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

    /**
     * Method to create a new user
     * @param string $name name of the user
     * @param string $email email of the user
     * @param string $password password of the user
     * @return bool
     */
    public static function create(string $name, string $email, string $password): bool
    {
        $db = dbClient::getInstance();
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $params = [$name, $email, $password];
        try {
            return $db->insert($sql, $params);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Method to delete a user
     * @param int $id id of the user
     * @return void
     */
    public static function delete(int $id)
    {
        $db = dbClient::getInstance();
        $sql = "DELETE FROM users WHERE id = ?";
        $params = [$id];
        $db->delete($sql, $params);
    }


    /**
     * Method to get the user given its id
     * @param int $id id of the user
     * @return string name of the user
     */
    public static function getNameById(int $id): string
    {
        $db = dbClient::getInstance();
        $sql = "SELECT * FROM users WHERE id = ?";
        $params = [$id];
        return $db->query($sql, $params)[0]['name'];
    }
}