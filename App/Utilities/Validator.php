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

    public static function password($pass){
        if(count_chars($pass) >= 12){
            return true;
        }
        return false;
    }

    public static function future_time($stamp){
        if($stamp >= time() && $stamp > 0){
            return true;
        }
        return false;
    }

    public static function permission_level($level){
        $valid = [
            0,  //none
            1,  //view
            2,  //edit
            9   //administrator
        ];

        return in_array($level, $valid, true);
    }
}