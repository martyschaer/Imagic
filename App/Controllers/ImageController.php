<?php

namespace Controllers;


use Utilities\Constants;

class ImageController
{
    public static function create(){
        if($_FILES['file']['error'] > 0){
            echo "You did not provide an image!";
            die();
        }
        $filename = md5(time());//DON'T DO THIS, TEMPORARY
        move_uploaded_file($_FILES['file']['tmp_name'], Constants::PATH_BASE . '/../Resources/images/full/' . $filename);
        echo "saved as " . $filename;
    }
}