<?php

namespace App\Applications\Post\BLL;
use App\Applications\Post\DAL\PostDALInterface;
use App\Applications\Common\DAL\MediaDALInterface;
use Illuminate\Support\Facades\Auth;

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
        $post = $this->getEntryDataArray($input);
        // dd($post);
        return $this->postDAL->savePost($post);
    }

    public function editPost($id, $input){
      }

    public function deletePost($id){

    }

    public function getEntryDataArray($request) {
        $input = [];
        $input['title'] = $request['title'];
        $input['body'] = $request['body'];
        $input['user_id'] = Auth::user()->id;

        return $input;
    }

}
?>