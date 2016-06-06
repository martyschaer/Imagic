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
    protected $profile_image;
    protected $permission_level = 0;
    protected $username = "placeholder";

    public function __construct()
    {

    }

    public function delete($id = null){
        $id = ($id == null ? $this->id : $id);
        $query = 'DELETE FROM `users` WHERE id = :id';
        $params = ['id' => $id];
        MySQLDriver::query($query, $params);
    }

    public function save()
    {
        $query = "UPDATE `users` SET
                  `email` = `:email`,
                  `username` = `:username`,
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
            ':username' => $this->username,
            ':pass' => $this->pass,
            ':reset_hash' => $this->reset_hash,
            ':reset_time' => $this->reset_time,
            ':signup_time' => $this->signup_time,
            ':profile_image' => $this->profile_image,
            ':permission_level' => $this->permission_level
        ];
        MySQLDriver::query($query, $params);
    }

    public function getById($id = null)
    {
        $query = "SELECT * FROM users WHERE `id` = :id";
        $params = ['id' => $id];
        $result = MySQLDriver::query($query, $params);
        if (count($result) != 1) {
            throw new Exception('Could not get this user. Wrong ID or ID does not exist.');
        }
        $data = $result[0];
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->username = $data['username'];
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
        $result = MySQLDriver::query('SELECT * FROM users WHERE `email` = :email', [':email' => $email]);
        if (count($result) != 1) {
            throw new Exception('Could not log in. No Email/Password match.');
        }
        $data = $result[0];
        $db_hash = $data['pass'];

        if (SecurityHelper::verifyPass($pass, $db_hash)) {
            $this->id = $data['id'];
            $this->email = $data['email'];
            $this->username = $data['username'];
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

    public function getByUsername($username){
        if(isset($_SESSION['user']) && $_SESSION['user']->getUsername() == $username){
            return $this->getPrivateData($username);
        }else{
            return $this->getPublicData($username);
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getSignupTime(){
        return $this->signup_time;
    }

    public function getProfileImage(){
        if($this->profile_image != null){
            return $this->profile_image;
        }else{
            return 'anonymous';
        }
    }

    public function getPermissionLevel(){
        return $this->permission_level;
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