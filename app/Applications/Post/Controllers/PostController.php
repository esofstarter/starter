<?php

namespace App\Application\Post\Controllers;

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
    public function savePost(){
        return $this->postBLL->savePost();
    }
    public function editPost(){
        return $this->postBLL->editPost();
    }
    public function deletePost(){
        return $this->postBLL->deletePost();
    }

}
?>