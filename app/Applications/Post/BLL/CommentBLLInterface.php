<?php

namespace App\Applications\Post\BLL;
use App\Applications\Post\Model\Posts;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Http\Request;


interface CommentBLLInterface{

    public function getAllComments();

    public function getCommentById($id);

    public function getCommentsByUser($id);

    public function saveComment($request);

    public function editComment($id, $request);

    public function deleteComment($id);
}

?>
