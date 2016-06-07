<?php

namespace Models\Builders;

use Drivers\MySQLDriver;
use Models\Image;
use Utilities\Validator;

class ImageBuilder extends Image
{
    private $image;

    public function __construct()
    {
        $this->image = new Image();
        return $this;
    }

    public function size($size)
    {
        $this->image->setSize($size);
        return $this;
    }

    public function upload_time($time = null)
    {
        if(!Validator::time($time)){
            throw new \Exception('That\'s not a time');
        }
        if ($time === null) {
            $time = time();
        }
        $this->image->setUploadTime($time);
        return $this;
    }

    public function user_id($id)
    {
        $this->image->setUserId($id);
        return $this;
    }

    public function file_id($id)
    {
        $this->image->setFileId($id);
        return $this;
    }

    public function tags($tags)
    {
        $this->image->setTags($tags);
        return $this;
    }

    public function title($title)
    {
        $this->image->setTitle($title);
        return $this;
    }

    public function make(){
        $query = "INSERT INTO `images`
                  (`size`, `upload_time`, `user_id`, `file_id`, `tags`, `title`)
                  VALUES (:size, :upload_time, :user_id, :file_id, :tags, :title)";
        $params = [
            ':size' => $this->image->size,
            ':upload_time' => $this->image->size,
            ':user_id' => $this->image->user_id,
            ':file_id' => $this->image->file_id,
            ':tags' => $this->image->tags,
            ':title' => $this->image->title
        ];
        MySQLDriver::query($query, $params);
        return $this;
    }
}