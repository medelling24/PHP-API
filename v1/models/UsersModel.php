<?php

namespace users\model;
require '../db/conection.php';
use connection\connection;
use PDO;

/**
 * Class UsersModel
 * Make calls to the DB in the table users
 * @package users\model
 */
class UsersModel{


    /**
     * Method to insert a new user.
     * @param $email string  user email
     * @param $first_name string user first name
     * @param $last_name string user last name
     * @param $password string user password
     * @return bool true if the user is inserted, false if not inserted
     */
    public static function insert($email, $first_name, $last_name, $password)
    {

        $password = self::encryptPassword($password);

        try {
            $pdo = connection::getInstance()->getDB();


            $query = "INSERT INTO user ( 
                      email, 
                      first_name,
                      last_name,
                      password)
                      VALUES(?,?,?,?)";

            $sth = $pdo->prepare($query);

            $sth->bindParam(1, $email);
            $sth->bindParam(2, $first_name);
            $sth->bindParam(3, $last_name);
            $sth->bindParam(4, $password);

            $result = $sth->execute();

            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }

    }

    /**
     * Use to create a secure password encryption
     * @param $password string
     * @return string Encrypted password
     */
    private function encryptPassword($password)
    {
        if ($password)
            return password_hash($password, PASSWORD_DEFAULT);
        else return "temporal1";
    }

    /**
     * Get a user from the ID,
     * @param $id number
     * @return array|bool Array when doesn't have any errors, with the number of the rows and the data for the first row
     * if rows is 0 means that the ID doesn't have any user
     */
    public static function getById($id)
    {

        try {
            $pdo = connection::getInstance()->getDB();


            $query = "SELECT email, first_name, last_name 
                      FROM user 
                      WHERE id = ? and deleted_at IS NULL";

            $sth = $pdo->prepare($query);

            $sth->bindParam(1, $id);
            $result = $sth->execute();

            if ($result) {
                return [
                    "rows" => $sth->rowCount(),
                    "data"=>$sth->fetch(PDO::FETCH_ASSOC)
                ];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }

    }

    /**
     * Get a user from the email,
     * @param $email string
     * @return array|bool Array when doesn't have any errors, with the number of the rows and the data for the first row
     * if rows is 0 means that the email doesn't have any user
     */
    public static function getByEmail($email)
    {

        try {
            $pdo = connection::getInstance()->getDB();


            $query = "SELECT id, email, first_name, last_name 
                      FROM user 
                      WHERE email LIKE ? AND deleted_at IS NULL";

            $sth = $pdo->prepare($query);

            $sth->bindParam(1, $email);
            $result = $sth->execute();

            if ($result) {
                return [
                    "rows" => $sth->rowCount(),
                    "data"=>$sth->fetch(PDO::FETCH_ASSOC)
                ];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }

    }

    /**
     * Update user data from the ID
     * @param $id number
     * @param $email string
     * @param $first_name string
     * @param $last_name string
     * @param $password string
     * @return array|bool Array when update a row and the number of rows updated (should be 1 in all the cases)
     * false when there is an error
     */
    public static function updateById($id, $email, $first_name, $last_name, $password){
        try {
            $pdo = connection::getInstance()->getDB();

            $password = self::encryptPassword($password);

            $query = "UPDATE user SET 
                          email = ?, 
                          first_name = ?, 
                          last_name = ?,
                          password = ?,
                          updated_at = NOW()
                      WHERE id = ? 
                      and deleted_at IS NULL";

            $sth = $pdo->prepare($query);

            $sth->bindParam(1, $email);
            $sth->bindParam(2, $first_name);
            $sth->bindParam(3, $last_name);
            $sth->bindParam(4, $password);
            $sth->bindParam(5, $id);

            $result = $sth->execute();

            if ($result) {
                return [
                    "rows" => $sth->rowCount()
                ];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Delete a user base on the ID
     * @param $id number
     * @return array|bool Array when update a row and the number of rows deleted (should be 1 in all the cases)
     * false when there is an error
     */
    public static function deleteById($id){
        try {
            $pdo = connection::getInstance()->getDB();

            $query = "UPDATE user SET 
                          deleted_at = NOW()
                      WHERE id = ? 
                      and deleted_at IS NULL";

            $sth = $pdo->prepare($query);

            $sth->bindParam(1, $id);

            $result = $sth->execute();

            if ($result) {
                return [
                    "rows" => $sth->rowCount()
                ];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
}