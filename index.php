<?php
    require_once "App/Utilities/AutoloaderUtility.php";

    use \Utilities\AutoloaderUtility;
    use \Utilities\RouterUtility;
    use \Drivers\MySQLDriver;

    $autoloader = new AutoloaderUtility();
    $autoloader->setIncludePath("/web/www/imagic/App");
    $autoloader->register();

    $router = new RouterUtility();
    $router->map('GET', '/test', function(){
        print_r(MySQLDriver::query("SELECT * FROM `test`", []));
    });

    $router->map('GET', '/', function(){
        echo "Hello World";
    });

    $router->map('GET', '/test/[a:parm]', function($parm){
        echo $parm;
    });

    $match = $router->match();

    if($match && is_callable($match['target'])){
        call_user_func_array($match['target'], $match['params']);
    }else{
        //no route could be matched
        header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        ?>
        <h1>404</h1>
        <h4>the page you requested could not be found on our server</h4>
        <?php
    }