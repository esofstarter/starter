<?php

namespace App\Applications\Post\DAL;
use Illuminate\Support\Facades\DB;
use App\Applications\Post\Model\Posts;
use App\Applications\User\Model\User;
use App\Applications\Common\DAL\MediaDALInterface;
use Carbon\Carbon;
use App\Applications\Post\DAL\CategoryDALInterface;
use Illuminate\Http\Request;

class PostDAL implements PostDALInterface {


    public function __construct(
        Posts $post,
        User $user,
        MediaDALInterface $mediaDAL,
        CategoryDALInterface $categoryDAL
    ){
        $this->post = $post;
        $this->user = $user;
        $this->mediaDAL = $mediaDAL;
        $this->categoryDAL = $categoryDAL;
    }

    public function index($postsperpage){
        $data['totalPosts'] = DB::table('posts')->select('*')->count();
        $data['posts'] = DB::table('posts')->select('*')->skip(0)->take($postsperpage)->get();
        // dd($totalPosts);
        // dd($data);
        return $data;
    }

    public function getPostsPerPage(Request $request,$postsperpage){
        $data['start'] = $request->get('start');
        $data['posts'] = DB::table('posts')->select('*')->skip($data['start'])->take($postsperpage)->get();
        $data['totlaPosts'] = DB::table('posts')->select('*')->count();
        // dd($posts,$start);
        return $data;
    }

    public function getAll(){
        // dd($this->post::all());
        return $this->post::all();
    }
    public function getLatestPosts(){
        $allPosts = $this->getAll();
        $latestPostsCollection = collect();
        foreach($allPosts as $post){
            if($post->created_at->toDateTImeString() >= Carbon::now()->subDay()->toDateTimeString()){
                $latestPostsCollection->push($post);
            }
        }
//        dd($latestPostsCollection);
//        $recentPosts = DB::table('posts') // can't query latest like this, get() returns \stdClass
//                        ->where('created_at','>=',Carbon::now()->subHours(24)->toDateTimeString())
//                        ->get();
//        $posts = Posts::whereDate('created_at',Carbon::today())->get();
//        dd($posts);
        return $latestPostsCollection;
    }
    public function getPostById($id){
        return $this->post::findOrFail($id);
    }
    public function getPostByIdNonAuth($id){
        return $this->post::findOrFail($id);
    }
    public function getPostsByUser($id){
        return $this->post->where('user_id', $id)->get();
    }
    public function savePost($input,$request){
        $idArray = $input['category_id'];
        $categoriesIds = [];
        for($i=0;$i<count($idArray);$i++){
            foreach($idArray[$i] as $id){
                array_push($categoriesIds,$id);
                break;
            }
        };
        $newPost = $this->post->create($input);
        $newPost->categories()->attach($categoriesIds);
        // $newPost->categories()->attach($this->categoryDAL->getCategoryBySlug('latest')->id);

        $this->mediaDAL->save($request,$newPost,'post_image');
        return $newPost;
    }
    public function editPost($post, $input){
        return $post->update($input);
    }
    public function deletePost($id){
        return $this->post
            ->where('id', $id)
            ->delete();
    }
}
?>
