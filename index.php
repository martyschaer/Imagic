<?php
require_once "App/Utilities/Autoloader.php";

use \Utilities\Autoloader;
use \Utilities\Routing\Router;
use \Utilities\Routing\Routes;

//bootstrapping the autoloader
$autoloader = new Autoloader();
$autoloader->setIncludePath("/web/www/imagic/App");
$autoloader->register();

//instantiating the router
$router = new Router();

//see the Routes file for all the routes
$router->addRoutes(Routes::all());

//see if the called url matches any routes
$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func($match['target'], $match['params']);
} else {
    Renderer::view('404', ['uri' => $_SERVER['REQUEST_URI']]);
}