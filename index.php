<?php
    require_once "app/database/dbDriverMySQL.php";

    print_r(dbDriverMySQL::query("SELECT * FROM `test`", []));