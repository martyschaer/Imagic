<?php
require_once "App/Utilities/AutoloaderUtility.php";

use \Utilities\AutoloaderUtility;
use \Utilities\RouterUtility;
use \Drivers\MySQLDriver;
use \Views\Renderer;

//bootstrapping the autoloader
$autoloader = new AutoloaderUtility();
$autoloader->setIncludePath("/web/www/imagic/App");
$autoloader->register();

//instantiating the router
$router = new RouterUtility();

//TODO put registering routes into a seperate file
//registering routes
$router->map('GET', '/test', function () {
    print_r(MySQLDriver::query("SELECT * FROM `test`", []));
});

$router->map('GET', '/', function () {
    Renderer::view('home');
});

$router->map('GET', '/test/[a:teststring]', function ($params) {
    Renderer::view('test', $params);
});

$router->map('GET', '/about', function () {
    Renderer::view('about');
});


$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func($match['target'], $match['params']);
} else {
    Renderer::view('404', ['uri' => $_SERVER['REQUEST_URI']]);
}