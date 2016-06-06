<?php
namespace Utilities;

class SecurityHelper
{
    //TODO DOS Mitigation

    /**
     * Verifies if the given password mathes the hash in the database
     * @param $pass
     * @param $hash
     * @return bool
     */
    public static function verifyPass($pass, $hash)
    {
        return password_verify($pass, $hash);
    }

    /**
     * Hashes the password with the required bcrypt rounds
     * @param $pass
     * @return bool|string
     */
    public static function hashPass($pass)
    {
        return password_hash($pass, PASSWORD_BCRYPT, ['cost' => Constants::SEC_BCRYPT_ROUNDS]);
    }


    /**
     * Checks if the user is logged in, and if they have the right permission level to access the site they requested
     * @param null $minimumPermission
     * @return bool
     */
    public static function isAuthentificated($minimumPermission = false)
    {
        if (isset($_SESSION['user'])) {
            if ($minimumPermission == false) {
                return true;
            } elseif ($_SESSION['user']->getPermissionLevel() <= $minimumPermission) {
                return true;
            }
            return false;
        } elseif ($minimumPermission == false) {
            return true;
        } else {
            return false;
        }
    }
}