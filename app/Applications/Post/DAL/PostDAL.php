<?php

namespace App\Applications\Post\DAL;
use Illuminate\Support\Facades\DB;
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
        return $this->post->where('user_id', $id)->get();
    }
    public function savePost($input){
        $idArray = $input['category_id'];
        $categoriesIds = [];
        for($i=0;$i<count($idArray);$i++){
            foreach($idArray[$i] as $id){
                array_push($categoriesIds,$id);
                break;
            }
        };
        $newPost = $this->post->create($input);
        $newPost->category()->attach($categoriesIds);
        return $newPost;
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