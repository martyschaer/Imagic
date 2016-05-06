<?php
require_once "App/Utilities/Autoloader.php";

use \Utilities\Autoloader;
use \Utilities\Router;
use \Drivers\MySQLDriver;
use \Views\Renderer;
use \Controllers\UserController;

//bootstrapping the autoloader
$autoloader = new Autoloader();
$autoloader->setIncludePath("/web/www/imagic/App");
$autoloader->register();

//instantiating the router
$router = new Router();

//TODO put registering routes into a seperate file
//registering routes
$router->map('GET', '/test', function () {
    print_r(MySQLDriver::query("SELECT * FROM `test`", []));
});

$router->map('GET', '/', function () {
    Renderer::view('home');
});


$router->map('GET', '/about', function () {
    Renderer::view('about');
});

$router->map('GET', '/login', function(){
    Renderer::view('login');
});

$router->map('GET', '/register', function(){
    Renderer::view('register');
});

$router->map('POST', '/user/new', function(){
    UserController::create();
});

$router->map('GET', '/profile', function(){
    Renderer::view('profile');
});


$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func($match['target'], $match['params']);
} else {
    Renderer::view('404', ['uri' => $_SERVER['REQUEST_URI']]);
}