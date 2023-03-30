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

        // // Then for each line in lines we add it to the user_lines table
        // $sql = "INSERT INTO users_permissions (user_id, line_id) VALUES (?, ?)";
        // $params = [];
        // foreach ($lines as $line) {
        //     $params[] = [$db->lastInsertId(), $line];
        //     try {
        //         $db->query($sql, $params);
        //     } catch (Exception $e) {
        //         return false;
        //     }
        // }
        // return true;
    }

    /**
     * @return array with all the users
     */
    public static function getAll(): array
    {
        $db = dbClient::getInstance();
        $sql = "SELECT * FROM user_admin";
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

    /**
     * @param int $userId the id of the user to update
     * @param string $name the name of the user
     * @param string $email the email of the user
     * @param array $lines the lines the user is able to edit
     * @return bool if the user was modified successfully
     */
    public static function modify(int $userId, string $name, string $email, array $lines): bool
    {
        $db = dbClient::getInstance();

        // First we get the actual user data and compare the name and email
        $sql = "SELECT * FROM users WHERE id = ?";
        try {

            $userData = $db->query($sql, [$userId])[0];

            // If the name or email is different we update it
            if ($userData['name'] != $name) {
                $sql = "UPDATE users SET name = ? WHERE id = ?";
                $db->query($sql, [$name, $userId]);
            }

            if ($userData['email'] != $email) {
                $sql = "UPDATE users SET email = ? WHERE id = ?";
                $db->query($sql, [$email, $userId]);
            }

        } catch (Exception $e) {
            // The user doesn't exist
            return false;
        }

        // Then we get the actual user permissions and compare them with the new ones
        $sql = "SELECT * FROM users_permissions WHERE user_id = ?";
        try {
            $userPermissions = $db->query($sql, [$userId]);

            // We create an array with the actual permissions
            $actualPermissions = [];
            foreach ($userPermissions as $permission) {
                $actualPermissions[] = $permission['line_id'];
            }

            // We compare the actual permissions with the new ones
            $toAdd = array_diff($lines, $actualPermissions);
            $toRemove = array_diff($actualPermissions, $lines);

            // We add the new permissions
            $sql = "INSERT INTO users_permissions (user_id, line_id) VALUES (?, ?)";
            foreach ($toAdd as $line) {
                $db->query($sql, [$userId, $line]);
            }

            // We remove the permissions that are not in the new array
            $sql = "DELETE FROM users_permissions WHERE user_id = ? AND line_id = ?";
            foreach ($toRemove as $line) {
                $db->query($sql, [$userId, $line]);
            }
        } catch (Exception $e) {
            // The user doesn't exist or permisons are not set
            return false;
        }

        return true;
    }
}