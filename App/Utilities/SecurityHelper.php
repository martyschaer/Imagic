<?php
namespace Utilities;

class SecurityHelper
{
    public static function verifyPass($pass, $hash){
        return password_verify($pass, $hash);
    }

    public static function hashPass($pass){
        return password_hash($pass, PASSWORD_BCRYPT, ['cost' => Constants::SEC_BCRYPT_ROUNDS]);
    }
}