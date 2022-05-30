<?php

namespace App\Applications\Post\DAL;
use App\Applications\Post\Model\Posts;
use App\Applications\User\Model\User;

class PostDAL implements PostDALInterface {
   
    public function __construct(
        Posts $post,
        User $user
    ){
        $this->post = $post;
        $this->user = $user;
    }
    public function getAll(){
        return $this->post::all();
    }
    public function getPostById($id){
        return $this->post::findOrFail($id);
    }
    public function getPostsByUser($id){
        return $this->post::whereHas('user_id', function($q){
            $q->where('user_id');
        })->get();
    }
    public function savePost($input){
        $post = $this->post->create($input);
        dd($input);
        return $post;
    }
    public function editPost($post, $input){
        return $post->update($input);
    }
    public function deletePost($id){
        return $this->post
            ->where('id', $id)
            ->delete();
    }

}
?>