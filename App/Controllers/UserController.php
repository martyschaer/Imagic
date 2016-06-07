<?php
namespace Controllers;

use \Models\User;
use \Models\Builders\UserBuilder;
use \Models\Permission;

class UserController
{

    public static function create()
    {
        if (!(isset($_POST['email']) && isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['pass_repeat']))) {
            echo "Not all required fields are filled out.";
            die();
        }
        $email = $_POST['email'];
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        $pass_repeat = $_POST['pass_repeat'];
        if ($pass !== $pass_repeat) {
            echo "The entered passwords don't match.";
            die();
        }

        $factory = new UserBuilder();
        $user = $factory
            ->email($email)
            ->pass($pass)
            ->permission_level(0)
            ->signup_time(time())
            ->username($username)
            ->make();

        if ($user instanceof User) {
            echo "ok";
            die();
        }
        die();
    }

    public static function login()
    {
        if (!(isset($_POST['email']) && $_POST['pass'])) {
            echo "Not all required fields are filled out.";
            die();
        }
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $user = new User();
        try {
            $user->getByEmail($email, $pass);
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            die();
        }
        $_SESSION['user'] = $user;
        echo "ok";
        die();
    }

    public static function show(){
        $user = $_SESSION['user'];
        $signup = date('Y-m-d', $user->getSignupTime());
        $permission = Permission::getPermissionLabel($user->getPermissionLevel());
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'signup' => $signup,
            'username' => $user->getUsername(),
            'profile_image' => $user->getProfileImage(),
            'permission' => $permission
        ];
    }

    public static function destroy($id){
        //TODO admins deleting other users
        $user = $_SESSION['user'];
        $user->logout();
        $user->delete();
        echo 'ok';
    }

    public static function update($id){
        //TODO admins updating other users
        $user = $_SESSION['user'];
        $user->patch();
    }


    public static function logout()
    {
        $user = $_SESSION['user'];
        $user->logout();
    }
}
