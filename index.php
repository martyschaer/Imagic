<?php
    require_once "app/drivers/MySQLDriver.php";

    print_r(dbDriverMySQL::query("SELECT * FROM `test`", []));