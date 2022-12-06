<?php

namespace App\Applications\Post\DAL;

use App\Applications\Post\Model\Posts;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
interface PostDALInterface{

    public function index($postsperpage);

    public function getPostsPerPage(Request $request,$postsperpage);

    public function getAll();

    public function getLatestPosts();

    public function getPostById($id);

    public function getPostByIdNonAuth($id);

    public function getPostsByUser($id);

    public function savePost($input,$request);

    public function editPost($id, $input);

    public function deletePost($id);

}
?>
