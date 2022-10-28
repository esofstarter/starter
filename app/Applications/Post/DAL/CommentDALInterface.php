<?php

namespace App\Applications\Post\DAL;

interface CommentDALInterface{

    public function getAll();

    public function getCommentById($id);

    public function getCommentByUser($id);

    public function saveComment($input);

    public function editComment($id, $input);

    public function deleteComment($id);

}
?>
