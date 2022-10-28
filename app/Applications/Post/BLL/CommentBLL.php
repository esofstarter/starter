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
        return $this->commentDAL->savePost($data);
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
        $input['title'] = $request['title'];
        $input['body'] = $request['body'];
        $input['user_id'] = Auth::user()->id;
        $input['creator'] =  Auth::user()->first_name;

        return $input;
    }

}
?>
