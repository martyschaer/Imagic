<?php

namespace Utilities;

class Validator
{
    public static function email($email = "")
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public static function password($pass)
    {
        if (count_chars($pass) >= 12) {
            return true;
        }
        return false;
    }

    public static function future_time($stamp)
    {
        if ($stamp >= time() && $stamp > 0) {
            return true;
        }
        return false;
    }

    public static function permission_level($level)
    {
        $valid = [
            0,  //admin
            1,  //mod
            2,  //none
        ];

        return in_array($level, $valid, true);
    }

    public static function parameters($urlstring)
    {
        parse_str(urldecode($urlstring), $data);
        return $data;
    }

    public static function time($stamp){
        return (is_numeric($stamp) && $stamp > 0);
    }

    public static function update_query($query)
    {
        return self::str_starts_with($query, 'UPDATE');
    }

    public static function insert_query($query)
    {
        return self::str_starts_with($query, 'INSERT');
    }

    public static function delete_query($query)
    {
        return self::str_starts_with($query, 'DELETE');
    }

    private static function str_starts_with($string, $query)
    {
        return mb_substr($string, 0, mb_strlen($query)) === $query;
    }
}