<?php
namespace Utilities\Routing;

use Controllers\ImageController;
use Drivers\MySQLDriver;
use \Views\Renderer;
use \Controllers\UserController;

class Routes
{
    /**
     * return all defined routes
     * must be defined like
     * [httpverb, path, function, permission]
     * @return array
     */
    public static function all(){
        return [
            ['GET', '/', function () {
                Renderer::view('home');
            }, false],
            ['GET', '/about', function () {
                Renderer::view('about');
            }, false],
            ['POST', '/users/login', function(){
                UserController::login();
            }, false],
            ['GET', '/login', function(){
                Renderer::view('login');
            }, false],
            ['GET', '/register', function(){
                Renderer::view('register');
            }, false],
            ['POST', '/users', function(){
                UserController::create();
            }, false],
            ['GET', '/users/logout', function(){
                UserController::logout();
            }, 2],
            ['GET', '/users', function(){
                $data = UserController::show();
                Renderer::view('profile', $data);
            }, 2],
            ['DELETE', '/users/[i:id]', function(){
                //delete user with id
            }, 2],
            ['GET', '/upload', function(){
                Renderer::view('upload');
            }, 2],
            ['GET', '/images', function(){
                //get all the images, optional ?q= parameter for searching
            }, 2],
            ['GET', '/images/[i:id]', function($params){
                //get the image with the corresponding id
            }, 2],
            ['POST', '/images', function(){
                ImageController::create();
            }, 2],
            ['DELETE', '/images/[i:id]', function($params){
                //delete image with id
            }, 2],
            ['DELETE', '/images', function(){
                //delete all images of this user
            }, 2]
        ];
    }
}
