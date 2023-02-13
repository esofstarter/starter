<?php

namespace App\Applications\Post\BLL;
use App\Applications\Post\DAL\CommentDALInterface;
use App\Applications\Common\DAL\MediaDALInterface;
use Illuminate\Support\Facades\Auth;

/**
 * @property CommentDALInterface $commentDAL the bar prop
 */
class CommentBLL implements CommentBLLInterface {

    public function __construct(
        CommentDALInterface $commentDAL,
        MediaDALInterface $mediaDAL
    ){
        $this->commentDAL = $commentDAL;
        $this->mediaDAL = $mediaDAL;
    }
    public function getAllComments(){
        return $this->commentDAL->getAll();
    }

    public function getCommentById($id){
        return $this->commentDAL->getPostById($id);
    }
    public function getCommentsByUser($id){

    }

    public function saveComment($data){
        $comment = $this->getEntryDataArray($data);
        // dd($post);
        // if(!$comment['user_id']){
        //     return response()->json(['error' => 'You have to be logged in to comment!'], 401);
        // }
        return $this->commentDAL->saveComment($comment);
    }

    public function editComment($request, $id){
        $comment_data = $request->all();
        $post = $this->commentDAL->getCommentById($id);
        $this->commentDAL->editComment($post, $comment_data);
    }

    public function deleteComment($id){
        return $this->commentDAL->deleteComment($id);
    }

    public function getEntryDataArray($request) {
        $input = [];
        $input['comment'] = $request['comment'];
        $input['posts_id'] = $request['post_id'];
        $input['user_id'] = Auth::user()->id;

        return $input;
    }

}
?>
