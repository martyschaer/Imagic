<?php

namespace Controllers;


use Drivers\MySQLDriver;
use Models\Builders\ImageBuilder;
use Models\Image;
use Utilities\Constants;
use Utilities\JsonHelper;

class ImageController
{
    public static function create(){
        if($_FILES['file']['error'] > 0){
            echo "You did not provide an image!";
            die();
        }
        if(!isset($_POST['tags']) || !isset($_POST['title'])){
            echo "no all necessary values set";
            die();
        }
        $size = $_FILES['file']['size'];
        $title = $_POST['title'];
        $tags = $_POST['tags'];
        $filename = md5(time() . $title);
        $filepath = Constants::PATH_BASE . '/../Resources/images/full/' . $filename;
        move_uploaded_file($_FILES['file']['tmp_name'], $filepath);

        $image = new ImageBuilder();
        $image->title($title)
            ->file_id($filename)
            ->tags($tags)
            ->upload_time(time())
            ->user_id($_SESSION['user']->getId())
            ->size($size)
            ->make();
        echo 'ok';
    }

    public static function get($fid = null){
        if($fid === null) {
            $query = "SELECT `id` FROM `images` WHERE `user_id` = :uid";
            $params = ['uid' => $_SESSION['user']->getId()];
        }else{
            $query = "SELECT `id` FROM `images` WHERE `user_id` = :uid AND `file_id` = :fid";
            $params = [
                'uid' => $_SESSION['user']->getId(),
                'fid' => $fid
            ];

        }
        $results = MySQLDriver::query($query, $params);
        $images = [];
        foreach ($results as $result) {
            $img = new Image();
            $iid = $result['id'];
            $images[] = $img->load($iid);
        }

        return json_encode($images);
    }
}