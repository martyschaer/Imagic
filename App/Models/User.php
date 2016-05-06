<?php
namespace Models;

use \Drivers\MySQLDriver;
use \Exception;
use \Utilities\SecurityHelper;
use \Utilities\Validator;

class User
{
    protected $id;
    protected $email;
    protected $pass;
    protected $reset_hash = null;
    protected $reset_time = null;
    protected $signup_time = 0;
    protected $profile_image = "placeholder";
    protected $permission_level = 0;
    protected $uri = "placeholder";

    public function __construct()
    {

    }

    public function save()
    {
        $query = "UPDATE `users` SET
                  `email` = `:email`,
                  `uri` = `:uri`,
                  `pass` = `:pass`,
                  `reset_hash` = `:reset_hash`,
                  `reset_time` = `:reset_time`,
                  `signup_time` = `:signup_time`,
                  `profile_image` = `:profile_image`,
                  `permission_level` = `:permission_level`
                  WHERE `id` = `:id`";
        $params = [
            ':id' => $this->id,
            ':email' => $this->email,
            ':uri' => $this->uri,
            ':pass' => $this->pass,
            ':reset_hash' => $this->reset_hash,
            ':reset_time' => $this->reset_time,
            ':signup_time' => $this->signup_time,
            ':profile_image' => $this->permission_level,
            ':permission_level' => $this->permission_level
        ];
        MySQLDriver::query($query, $params);
    }

    public function getById($id = null)
    {
        $query = "SELECT * FROM users WHERE `id` = `:id`";
        $params = ['id' => $id];
        $result = MySQLDriver::query($query, $params);
        if (count($result) != 1) {
            throw new Exception('Could not get this user. Wrong ID or ID does not exist.');
        }
        $data = $result[0];
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->uri = $data['uri'];
        $this->pass = $data['pass'];
        $this->reset_hash = $data['reset_hash'];
        $this->reset_time = $data['reset_time'];
        $this->signup_time = $data['signup_time'];
        $this->profile_image = $data['profile_image'];
        $this->permission_level = $data['permission_level'];
        return $this;
    }

    public function getByEmail($email, $pass)
    {
        $result = MySQLDriver::query('SELECT * FROM users WHERE `email` = `:email`', [':email' => $email]);
        if (count($result) != 1) {
            throw new Exception('Could not log in. No Email/Password match.');
        }
        $data = $result[0];
        $db_hash = $data['pass'];

        if (SecurityHelper::verifyPass($pass, $db_hash)) {
            $this->id = $data['id'];
            $this->email = $data['email'];
            $this->uri = $data['uri'];
            $this->pass = $data['pass'];
            $this->reset_hash = $data['reset_hash'];
            $this->reset_time = $data['reset_time'];
            $this->signup_time = $data['signup_time'];
            $this->profile_image = $data['profile_image'];
            $this->permission_level = $data['permission_level'];
            return $this;
        } else {
            throw new Exception('Could not log in. No Email/Password match.');
        }
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if (Validator::email($email)) {
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }
}