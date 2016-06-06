<?php

namespace Models;


class Permission
{
    private static $permissions = [
        0 => 'admin',
        1 => 'moderator',
        2 => 'user'
    ];

    public static function getPermissionLabel($level){
        if(0 <= $level && $level <= 2){
            return self::$permissions[$level];
        }else{
            return false;
        }
    }
}