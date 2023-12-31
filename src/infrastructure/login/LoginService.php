<?php

class LoginService {

    public static function encryptPassword(string $password) : string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function comparePassword(string $password, string $hash) : bool
    {
        return password_verify($password, $hash);
    }
}