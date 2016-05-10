<?php
namespace Utilities\Routing;

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
            }],
            ['GET', '/user/', function(){
                UserController::show(null);
                Renderer::view('profile');
            }],
            ['GET', '/user/[a:uri]', function($uri){
                UserController::show($uri);
            }]
        ];
    }
}