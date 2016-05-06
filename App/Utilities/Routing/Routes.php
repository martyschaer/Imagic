<?php
namespace Utilities\Routing;

use \Drivers\MySQLDriver;
use \Views\Renderer;
use \Controllers\UserController;

class Routes
{
    public static function all(){
        return [
            ['GET', '/', function () {
                Renderer::view('home');
            }],
            ['GET', '/about', function () {
                Renderer::view('about');
            }],
            ['GET', '/login', function(){
                UserController::login();
                Renderer::view('login');
            }],
            ['GET', '/register', function(){
                Renderer::view('register');
            }],
            ['GET', '/logout', function(){
                UserController::logout();
                header('Location: /');
            }],
            ['POST', '/user/new', function(){
                UserController::create();
            }],
            ['GET', '/profile', function(){
                Renderer::view('profile');
            }]
        ];
    }
}