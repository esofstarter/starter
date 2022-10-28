<?php

namespace App\Applications\Post\DAL;
use App\Applications\Post\Model\Comment;
use App\Applications\User\Model\User;

/**
 * @property Comment $comment
 */
class CommentDAL implements CommentDALInterface {

    public function __construct(
        Comment $comment,
        User $user
    ){
        $this->comment = $comment;
        $this->user = $user;
    }
    public function getAll(){
        // $query = DB::table('users')->select('username')->join('posts', 'user_id', '=', 'users.id');
        // $username = $query->get();

        return $this->comment::all();
    }
    public function getCommentById($id){
        return $this->comment::findOrFail($id);
    }
    public function getCommentByUser($id){
        return $this->comment::whereHas('user_id', function($q){
            $q->where('user_id');
        })->get();
    }
    public function saveComment($input){

        return $this->comment->create($input);
    }
    public function editComment($comment, $input){
        return $comment->update($input);
    }
    public function deleteComment($id){
        return $this->comment
            ->where('id', $id)
            ->delete();
    }

}
?>
