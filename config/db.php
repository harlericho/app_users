<?php
class Db
{
    public static function dbConnection()
    {
        try {
            $db = new PDO('mysql:host=localhost;dbname=db_api_users', 'root', 'root');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
}
