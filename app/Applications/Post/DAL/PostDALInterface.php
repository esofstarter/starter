<?php

namespace App\Applications\Post\DAL;

use App\Applications\Post\Model\Posts;
use Illuminate\Database\Eloquent\Collection;

interface PostDALInterface{
    
    public function getAll();

    public function getPostById($id);

    public function getPostsByUser($id);

    public function savePost($input);

    public function editPost($id, $input);

    public function deletePost($id);

}
?>