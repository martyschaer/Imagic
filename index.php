<?php
require_once "App/Utilities/Autoloader.php";

use \Utilities\Autoloader;
use \Utilities\Routing\Router;
use \Utilities\Routing\Routes;
use \Utilities\Constants;
use \Views\Renderer;

//bootstrapping the autoloader
$autoloader = new Autoloader();
$autoloader->setIncludePath("/web/www/imagic/App");
$autoloader->register();


ini_set('session.cookie_lifetime', Constants::TIME_WEEK);
session_start();
$_SESSION['session_id'] = session_id();
if(!isset($_SESSION['user'])){
    session_regenerate_id(true);
}

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