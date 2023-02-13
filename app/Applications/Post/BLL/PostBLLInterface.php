<?php

namespace App\Applications\Post\BLL;
use App\Applications\Post\Model\Posts;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Http\Request;


interface PostBLLInterface{

    public function index();

    public function getScrolldownPosts(Request $request);

    public function getAllPosts();

    public function getPostById($id);

    public function getPostByIdNonAuth($id);

    public function getLatestPosts();

    public function getPostsByDate(Request $request);
    
    public function getPostsByUser();

    public function savePost($request);

    public function editPost($id, $request);

    public function deletePost($id);
}

?>
