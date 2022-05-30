<?php

namespace App\Applications\Post\Controllers;

use Illuminate\Http\Request;
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
    public function getPostById(){
        return $this->postBLL->getPostById();
    }
    public function getPostsByUser(){
        return $this->postBLL->getPostsByUser();
    }
    public function savePost(Request $request){
        // dd($request);
        return $this->postBLL->savePost($request);
    }
    public function editPost(){
        return $this->postBLL->editPost();
    }
    public function deletePost(){
        return $this->postBLL->deletePost();
    }

}
?>