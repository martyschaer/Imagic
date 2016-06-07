<?php

namespace Models;


use Drivers\MySQLDriver;

class Image implements \JsonSerializable
{
    protected $id;
    protected $size;
    protected $upload_time;
    protected $user_id;
    protected $file_id;
    protected $tags;
    protected $title;

    public function __construct()
    {

    }

    public function jsonSerialize()
    {
        return [
            'id'            => $this->getId(),
            'size'          => $this->getSize(),
            'upload_time'   => $this->getUploadTime(),
            'user_id'       => $this->getUserId(),
            'file_id'       => $this->getFileId(),
            'tags'          => $this->getTags(),
            'title'         => $this->getTitle()
        ];
    }

    /**
     * returns the image corresponding with this id if available.
     * otherwise returns false
     * @param null $id
     * @return $this|bool
     */
    public function load($id = null){
        $query = "SELECT * FROM `images` WHERE id = :id";
        $params = [':id' => $id];
        $result = MySQLDriver::query($query, $params);
        if(count($result) != 1){
            return false;
        }
        $image = $result[0];
        foreach($image as $k => $v){
            $this->{$k} = $v;
        }
        return $this;
    }

    /**
     * deletes the object from the database
     */
    public function delete($id = null){
        $id = ($id === null ? $this->id : $id);
        $query = 'DELETE FROM `images` WHERE id = :id';
        $params = ['id' => $this->id];
        MySQLDriver::query($query, $params);
    }

    /**
     * Saves the object to the database
     */
    public function save(){
        $query = "UPDATE `ìmages` SET
                  `size` = :size,
                  `upload_time` = :upload_time,
                  `user_id` = :user_id,
                  `file_id` = :file_id,
                  `tags` = :tags,
                  `title` = :title
                  WHERE `id` = :id";
        $params = [
            ':id'           => $this->id,
            ':size'         => $this->size,
            ':upload_time'  => $this->upload_time,
            ':user_id'      => $this->user_id,
            ':file_id'      => $this->file_id,
            'tags'          => $this->tags,
            'title'         => $this->title
        ];

        MySQLDriver::query($query, $params);
    }

    /**
     * updates the object & database with new information provided via patch
     */
    public function patch(){
        $data = Validator::parameters(file_get_contents('php://input'));
        foreach($data as $k => $v){
            if($v != ""){
                $this->{$k} = $v;
            }
        }
        $this->save();
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param mixed $file_id
     */
    public function setFileId($file_id)
    {
        $this->file_id = $file_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param mixed $upload_time
     */
    public function setUploadTime($upload_time)
    {

        $this->upload_time = $upload_time;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getUploadTime()
    {
        return $this->upload_time;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getFileId()
    {
        return $this->file_id;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }


}