<?php

namespace App\Applications\Post\Controllers;

use App\Applications\Post\BLL\CommentBLLInterface;
use App\Applications\Post\Requests\CommentRequest;
use App\Http\Controllers\Controller;

/**
* @property CommentBLLInterface $commentBLL
 */
class CommentController extends Controller
{
    public function __construct(
        CommentBLLInterface $commentBLL
    ){
        $this->commentBLL = $commentBLL;
    }
    public function allComment(){
        return $this->commentBLL->getAllComments();
    }
    public function getCommentById($id){
        return $this->commentBLL->getCommentById($id);
    }
    public function getCommentByUser(){
        return $this->commentBLL->getCommentByUser();
    }
    public function saveComment(CommentRequest $request){
        // dd($request);
        return $this->commentBLL->saveComment( $request);
    }
    public function editComment(CommentRequest $request, $id){
        return $this->commentBLL->editComment($request,$id);
    }
    public function deleteComment($id){
        return $this->commentBLL->deleteComment($id);
    }

}
?>
