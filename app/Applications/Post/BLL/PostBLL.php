<?php

namespace App\Applications\Post\BLL;
use App\Applications\Post\DAL\PostDALInterface;
use App\Applications\Common\DAL\MediaDALInterface;

class PostBLL implements PostBLLInterface {
   
    public function __construct(
        PostDALInterface $postDAL,
        MediaDALInterface $mediaDAL
    ){
        $this->postDAL = $postDAL;
        $this->mediaDAL = $mediaDAL;
    }
    public function getAllPosts(){
        return $this->postDAL->getAll();
    }

    public function getPostById($id){
        return $this->postDAL->getPostById();
    }
    public function getPostsByUser($id){

    }

    public function savePost($input){

    }

    public function editPost($id, $input){

    }

    public function deletePost($id){

    }
}
?>