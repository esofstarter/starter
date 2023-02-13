<?php

namespace App\Applications\Post\BLL;

use App\Applications\Common\DAL\MediaDAL;
use App\Applications\Post\DAL\PostDALInterface;
use App\Applications\Common\DAL\MediaDALInterface;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCommentsResource;
use Illuminate\Http\Request;

class PostBLL implements PostBLLInterface {

    public $postsperpage = 3;

    public function __construct(
        PostDALInterface $postDAL,
        MediaDALInterface $mediaDAL

    ){
        $this->postDAL = $postDAL;
        $this->mediaDAL = $mediaDAL;
    }

    public function index(){
        return $this->postDAL->index();
    }

    public function getScrolldownPosts(Request $request){
        // dd($this->postDAL->getPostsPerPage($request,$this->postsperpage));
        $data = $this->postDAL->getPostsPerPage($request,$this->postsperpage);
        return $data;
    }

    public function getAllPosts(){
        return PostResource::collection($this->postDAL->getAll());
    }

    public function getLatestPosts(){
        return PostResource::collection($this->postDAL->getLatestPosts());
    }

    public function getPostsByDate(Request $request){
        $date = $request->input('date');

        return /* PostResource::collection( */$this->postDAL->getPostsByDate($date)/* ) */;
    }

    public function getPostById($id){
        return new PostResource($this->postDAL->getPostById($id));
    }
    public function getPostByIdNonAuth($id){
        return $this->postDAL->getPostByIdNonAuth($id);
    }
    public function getPostsByUser(){
        $userId = Auth::user()->id;
        return $this->postDAL->getPostsByUser($userId);
    }

    public function savePost($data){

        $post = $this->getEntryDataArray($data);

        return $this->postDAL->savePost($post,$data);
    }

    public function editPost($request, $id){
        $post_data = $request->all();
        $post = $this->postDAL->getPostById($id);
        $this->mediaDAL->save($request, $post, 'post_image');
        $this->postDAL->editPost($post, $post_data);
      }

    public function deletePost($id){
        return $this->postDAL->deletePost($id);
    }

    public function getEntryDataArray($request) {
        $input = [];
        $input['image'] = $request->file('image');
        $input['title'] = $request['title'];
        $input['body'] = $request['body'];
        $input['category_id'] = $request['categories'];
        $input['user_id'] = Auth::user()->id;
        $input['creator'] =  Auth::user()->first_name;
        return $input;
    }

}
?>
