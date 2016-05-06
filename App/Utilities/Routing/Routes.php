<?php
namespace Utilities\Routing;

use \Drivers\MySQLDriver;
use \Views\Renderer;
use \Controllers\UserController;

class Routes
{
    public static function all(){
        return [
            ['GET', '/test', function () {
                print_r(MySQLDriver::query("SELECT * FROM `test`", []));
            }],
            ['GET', '/', function () {
                Renderer::view('home');
            }],
            ['GET', '/about', function () {
                Renderer::view('about');
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
            ['GET', '/profile', function(){
                Renderer::view('profile');
            }]
        ];
    }
}