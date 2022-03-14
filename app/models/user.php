<?php
require_once './config/db.php';

class User
{
    public static function getAllUsers()
    {
        try {
            $db = Db::dbConnection();
            $sql = 'SELECT * FROM user';
            $query = $db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            $db = null;
        }
    }
    public static function getUserById($id)
    {
        try {
            $db = Db::dbConnection();
            $sql = 'SELECT * FROM user WHERE id = :id';
            $query = $db->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            $db = null;
        }
    }
    public static function createUser($data)
    {
        try {
            $db = Db::dbConnection();
            $sql = 'INSERT INTO user (dni, names, email, address, rol) 
            VALUES (:dni, :names, :email, :address, :rol)';
            $query = $db->prepare($sql);
            $query->bindParam(':dni', $data['dni'], PDO::PARAM_STR);
            $query->bindParam(':names', $data['names'], PDO::PARAM_STR);
            $query->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $query->bindParam(':address', $data['address'], PDO::PARAM_STR);
            $query->bindParam(':rol', $data['rol'], PDO::PARAM_STR);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            $db = null;
        }
    }
    public static function updateUser($data)
    {
        try {
            $db = Db::dbConnection();
            $sql = 'UPDATE user SET dni = :dni, names = :names, email = :email, address = :address, rol = :rol 
            WHERE id = :id';
            $query = $db->prepare($sql);
            $query->bindParam(':id', $data['id'], PDO::PARAM_INT);
            $query->bindParam(':dni', $data['dni'], PDO::PARAM_STR);
            $query->bindParam(':names', $data['names'], PDO::PARAM_STR);
            $query->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $query->bindParam(':address', $data['address'], PDO::PARAM_STR);
            $query->bindParam(':rol', $data['rol'], PDO::PARAM_STR);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            $db = null;
        }
    }
    public static function deleteUser($id)
    {
        try {
            $db = Db::dbConnection();
            $sql = 'UPDATE user SET status = 0 WHERE id = :id';
            $query = $db->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            $db = null;
        }
    }
    public static function validationUserDni($dni)
    {
        try {
            $db = Db::dbConnection();
            $sql = 'SELECT * FROM user WHERE dni = :dni';
            $query = $db->prepare($sql);
            $query->bindParam(':dni', $dni, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            $db = null;
        }
    }
    public static function validationUserDniUpdate($email, $id)
    {
        try {
            $db = Db::dbConnection();
            $sql = 'SELECT COUNT(*) FROM user WHERE dni = :dni OR id = :id';
            $query = $db->prepare($sql);
            $query->bindParam(':dni', $email, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            $db = null;
        }
    }
    public static function validationUserEmail($email)
    {
        try {
            $db = Db::dbConnection();
            $sql = 'SELECT * FROM user WHERE email = :email';
            $query = $db->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            $db = null;
        }
    }
    public static function validationUserEmailUpdate($email, $id)
    {
        try {
            $db = Db::dbConnection();
            $sql = 'SELECT COUNT(*) FROM user WHERE email = :email OR id = :id';
            $query = $db->prepare($sql);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        } finally {
            $db = null;
        }
    }
}
