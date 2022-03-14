<?php
require_once './app/models/user.php';
class Validation
{
    public static function dniLength($dni)
    {
        if (strlen($dni) == 10) {
            return true;
        } else {
            return false;
        }
    }
    public static function dniEmpty($dni)
    {
        if (!empty($dni)) {
            return true;
        } else {
            return false;
        }
    }
    public static function emailVerification($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    public static function emailEmpty($email)
    {
        if (!empty($email)) {
            return true;
        } else {
            return false;
        }
    }
    public static function namesEmpty($names)
    {
        if (!empty($names)) {
            return true;
        } else {
            return false;
        }
    }
    public static function rolEmpty($rol)
    {
        if (!empty($rol)) {
            return true;
        } else {
            return false;
        }
    }
}
