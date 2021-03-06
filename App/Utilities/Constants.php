<?php
namespace Utilities;

/**
 * class to save some often used constants.
 * Class ConstantsUtility
 * @package Utilities
 */
class Constants
{
    const DB_USER = 'imagic';
    const DB_PASS = 'ZfvXN2JnHeP56F73';

    //this amount will roughly take 1 second per password on my machine,
    //which is ideal according to the linked question.
    //http://security.stackexchange.com/questions/3959/recommended-of-iterations-when-using-pkbdf2-sha256/3993#3993
    //this is given as a power of 2, so 2^15 =
    const SEC_BCRYPT_ROUNDS = 15;

    const TIME_MINUTE = 60 * 60;
    const TIME_HOUR = self::TIME_MINUTE * 60;
    const TIME_DAY = self::TIME_HOUR * 24;
    const TIME_WEEK = self::TIME_DAY * 7;

    const PERMISSIONS = [0 => 'user', 1 => 'moderator', 9 => 'admin'];

    const PATH_BASE = '/web/www/imagic/App';


}
