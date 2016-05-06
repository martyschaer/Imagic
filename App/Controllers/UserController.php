<?php
namespace Controllers;

use \Models\User;
use \Models\Factories\UserFactory;

class UserController
{
    public static function create(){
        if(!(isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['pass_repeat']))){
            echo "Not all required fields are filled out.";
            die();
        }
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $pass_repeat = $_POST['pass_repeat'];
        if($pass !== $pass_repeat){
            echo "The entered passwords don't match.";
            die();
        }

        $factory = new UserFactory();
        $user = $factory
            ->email($email)
            ->pass($pass)
            ->permission_level(0)
            ->signup_time(time())
            ->make();

        if($user instanceof User){
            echo "ok";
            die();
        }
        echo print_r(get_defined_vars(), true);
        die();
    }

    public static function login(){
        $email = 'schaer.marius@gmail.com';
        $pass = 'supersecurex';
        $user = new User();
        $user->getByEmail($email, $pass);
        $_SESSION['user'] = $user;
    }

    public static function logout(){
        $_SESSION = null;
        session_destroy();
    }
}