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
        // $query = DB::table('users')->select('username')->join('posts', 'user_id', '=', 'users.id');
        // $username = $query->get();

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
        
        return $this->post->create($input);
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