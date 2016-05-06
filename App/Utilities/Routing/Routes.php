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
            ['POST', '/user/login', function(){
                UserController::login();
            }],
            ['GET', '/login', function(){
                Renderer::view('login');
            }],
            ['GET', '/register', function(){
                Renderer::view('register');
            }],
            ['POST', '/user/new', function(){
                UserController::create();
            }],
            ['GET', '/user/logout', function(){
                UserController::logout();
                header('Location: /');
            }],
            ['GET', '/profile', function(){
                Renderer::view('profile');
            }]
        ];
    }
}