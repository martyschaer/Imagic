<?php
    require_once "App/Utilities/AutoloaderUtility.php";
    use \Utilities\AutoloaderUtility;
    use \Drivers\MySQLDriver;

    $autoloader = new AutoloaderUtility();
    $autoloader->setIncludePath("/web/www/imagic/App");
    $autoloader->register();

    print_r(MySQLDriver::query("SELECT * FROM `test`", []));