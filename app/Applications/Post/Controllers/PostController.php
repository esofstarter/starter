<?php

namespace App\Applications\Post\Controllers;

use Illuminate\Http\Request;
use App\Applications\Post\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Applications\Post\BLL\PostBLLInterface;
use App\Http\Resources\PostResource;

class PostController extends Controller
{

    public function __construct(
        PostBLLInterface $postBLL
    ){
        $this->postBLL = $postBLL;
    }

    public function index(){
        
        return $this->postBLL->index();

    }
    public function getScrolldownPosts(Request $request){
        $data = $this->postBLL->getScrolldownPosts($request);
        // dd($data);
        return $data;
    }

    public function allPosts(){
        // dd($this->postBLL->getAllPosts());
        return $this->postBLL->getAllPosts();
    }
    public function latestPosts()
    {
       return $this->postBLL->getLatestPosts();
    }
    public function getPostById($id){
        return $this->postBLL->getPostById($id);
    }
    public function getPostByIdNonAuth($id){
        
        // dd($this->postBLL->getPostById($id));
        return $this->postBLL->getPostById($id);
    }
    public function getPostsByUser(){
        return $this->postBLL->getPostsByUser();
    }
    public function savePost(PostRequest $request){
        // dd($request);
        return $this->postBLL->savePost( $request)->toJson();
    }
    public function editPost(PostRequest $request, $id){
        return $this->postBLL->editPost($request,$id);
    }
    public function deletePost($id){
        return $this->postBLL->deletePost($id);
    }

}
?>
