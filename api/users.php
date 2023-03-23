<?php

namespace api;

use Exception;

include "dbClient.php";

class users
{
    /**
     * @param $name string the name of the user
     * @param $email string the email of the user
     * @param $password string the password of the user without encryption
     * @return bool if the user was created
     */
    static function createNew(string $name, string $email, string $password): bool
    {
        $db = new dbClient();
        $sql = "INSERT INTO users (name, password, email) VALUES (?, ?, ?)";
        $params = [$name, $email, $password];
        try {
            $db->query($sql, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}