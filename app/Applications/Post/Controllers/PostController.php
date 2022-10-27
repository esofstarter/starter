<?php

namespace App\Applications\Post\Controllers;

use Illuminate\Http\Request;
use App\Applications\Post\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Applications\Post\BLL\PostBLLInterface;

class PostController extends Controller
{
    public function __construct(
        PostBLLInterface $postBLL
    ){
        $this->postBLL = $postBLL;
    }
    public function allPosts(){
        return $this->postBLL->getAllPosts();
    }
    public function getPostById($id){
        return $this->postBLL->getPostById($id);
    }
    public function getPostsByUser(){
        return $this->postBLL->getPostsByUser();
    }
    public function savePost(PostRequest $request){
        // dd($request);
        return $this->postBLL->savePost( $request);
    }
    public function editPost(PostRequest $request, $id){
        return $this->postBLL->editPost($request,$id);
    }
    public function deletePost($id){
        return $this->postBLL->deletePost($id);
    }

}
?>