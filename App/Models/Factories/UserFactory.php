<?php
namespace Models\Factories;

use \Drivers\MySQLDriver;
use \Exception;
use \Utilities\SecurityHelper;
use \Utilities\Validator;
use \Models\User;

class UserFactory extends User
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
        return $this;
    }

    public function email($email)
    {
        if (!Validator::email($email)) {
            throw new Exception("'{$email}' is not a valid email address");
        }
        $this->user->email = $email;
        return $this;
    }

    public function pass($pass)
    {
        if (!Validator::password($pass)) {
            throw new Exception('Your password must be at least 12 characters long.');
        }
        $this->user->pass = SecurityHelper::hashPass($pass);
        return $this;
    }

    public function reset_hash($hash)
    {
        $this->user->reset_hash = $hash;
        return $this;
    }

    public function reset_time($stamp)
    {
        if (!Validator::future_time($stamp)) {
            throw new Exception('That\'s not a time in the future.');
        }
        $this->user->reset_time = $stamp;
        return $this;
    }

    public function signup_time($stamp = -1)
    {
        if (!is_numeric($stamp)) {
            throw new Exception('That\'s not a time.');
        }
        if ($stamp < 0) {
            $stamp = time();
        }
        $this->user->signup_time = $stamp;
        return $this;
    }

    public function profile_image()
    {
        //TODO implement
        return $this;
    }

    public function permission_level($level = 0)
    {
        if (!Validator::permission_level($level)) {
            throw new Exception('That\'s not a valid permission');
        }
        $this->user->permission_level = $level;
        return $this;
    }

    public function uri($uri = null)
    {
        //TODO implement
        $this->user->uri = $uri;
    }

    public function make()
    {
        $query = "INSERT INTO `users`
                  (`email`, `uri`, `pass`, `reset_hash`, `reset_time`, `signup_time`, `profile_image`, `permission_level`)
                  VALUES (:email, :uri, :pass, :reset_hash, :reset_time, :signup_time, :profile_image, :permission_level)";
        $params = [
            ':email' => $this->user->email,
            ':uri' => $this->user->uri,
            ':pass' => $this->user->pass,
            ':reset_hash' => $this->user->reset_hash,
            ':reset_time' => $this->user->signup_time,
            ':signup_time' => $this->user->signup_time,
            ':profile_image' => $this->user->profile_image,
            ':permission_level' => $this->user->permission_level
        ];
        MySQLDriver::query($query, $params);
        return $this->user;
    }
}