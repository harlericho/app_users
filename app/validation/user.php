<?php
require_once './app/models/user.php';
class Validation
{
    public static function validationUserDni($dni)
    {
        $user = User::validationUserDni($dni);
        if ($user) {
            return array(
                'status' => 'error',
                'message' => 'Dni is already taken'
            );
        } else {
            return false;
        }
    }
    public static function validationUserEmail($email)
    {
        $user = User::validationUserEmail($email);
        if ($user) {
            return array(
                'status' => 'error',
                'message' => 'Email is already taken'
            );
        } else {
            return false;
        }
    }
    public static function validationUserDniUpdate($dni, $id)
    {
        $user = User::validationUserDniUpdate($dni, $id);
        if ($user) {
            return $user;
        } else {
            return false;
        }
    }
    public static function validationUserEmailUpdate($email, $id)
    {
        $user = User::validationUserEmailUpdate($email, $id);
        if ($user) {
            return $user;
        } else {
            return false;
        }
    }
}
