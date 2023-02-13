<?php

namespace App\Applications\Post\DAL;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Applications\User\Model\User;
use App\Applications\Post\Model\Posts;
use App\Applications\Common\DAL\MediaDALInterface;
use App\Applications\Post\DAL\CategoryDALInterface;

class PostDAL implements PostDALInterface {
    public $postsOnInitialOpen = 3;

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

    public function index(){
        $posts_by_category_ids = $this->getPostsByCategories();
        // dd(json_decode(json_encode($posts_by_category_ids['news_posts']->toArray()),true));
        // dd($test);
        $data['totalPosts'] = DB::table('posts')->select('*')->count();
        $data['latestPosts'] = DB::table('posts')
                                ->where('posts.created_at','>=',Carbon::now()->subHours(24)->toDateTimeString())
                                ->skip(0)
                                ->take($this->postsOnInitialOpen)
                                ->crossJoin('media','media.model_id','=','posts.id')
                                ->where('media.collection_name','=','post_image')
                                ->select('posts.*','media.file_name','media.id AS media_id')
                                ->get();
        $data['newsPosts'] = DB::table('posts')
                            ->whereIn('posts.id',json_decode(json_encode($posts_by_category_ids['news_posts']->toArray()),true))
                            ->skip(0)
                            ->take($this->postsOnInitialOpen)
                            ->leftJoin('media','media.model_id','=','posts.id')
                            ->where('media.collection_name','=','post_image')
                            ->select('posts.*','media.file_name','media.id AS media_id')
                            ->get();
        // dd($data['latestPosts']);
        
        $data['entertainmentPosts'] = DB::table('posts')
                                    ->whereIn('posts.id',json_decode(json_encode($posts_by_category_ids['entertainment_posts']->toArray()),true))
                                    ->skip(0)
                                    ->take($this->postsOnInitialOpen)
                                    ->leftJoin('media','media.model_id','=','posts.id')
                                    ->where('media.collection_name','=','post_image')
                                    ->select('posts.*','media.file_name','media.id AS media_id')
                                    ->get();
        // dd($data);
        // $data['posts'] = DB::table('posts')->select('*')->skip(0)->take($this->postsOnInitialOpen)->get();
        $data['postsPerPage'] = 3;
        // dd($totalPosts);
        // dd($data);
        return $data;
    }

    public function getPostsPerPage(Request $request,$postsperpage){
        $posts_by_category_ids = $this->getPostsByCategories();
        
        $data['start'] = $request->get('start');
        // $data['posts'] = DB::table('posts')->select('*')->skip($data['start'])->take($postsperpage)->get();
        $data['latestPosts'] =  DB::table('posts')->where('created_at','>=',Carbon::now()->subHours(24)->toDateTimeString())->skip($data['start'])->take($this->postsOnInitialOpen)->get();
        $data['newsPosts'] = DB::table('posts')->select('*')->whereIn('id',json_decode(json_encode($posts_by_category_ids['news_posts']->toArray()),true))->skip($data['start'])->take($this->postsOnInitialOpen)->get();
        $data['entertainmentPosts'] = DB::table('posts')->select('*')->whereIn('id',json_decode(json_encode($posts_by_category_ids['entertainment_posts']->toArray()),true))->skip($data['start'])->take($this->postsOnInitialOpen)->get();
        $data['totlaPosts'] = DB::table('posts')->select('*')->count();
        // dd($posts,$start);
        return $data;
    }

    public function getPostsByCategories(){
        $data['entertainment_posts'] = DB::table('category_post')->select('posts_id')->where('category_id','=','7')->get();
        $data['news_posts'] = DB::table('category_post')->select('posts_id')->where('category_id','=','6')->get();
        $data['sports_posts'] = DB::table('category_post')->select('posts_id')->where('category_id','=','8')->get();
        return $data;
    }


    public function getAll(){
        // dd($this->post::all());
        return $this->post::all();
    }
    public function getLatestPosts(){
       $recentPosts = DB::table('posts') // can't query latest like this, get() returns \stdClass
                       ->where('created_at','>=',Carbon::now()->subHours(24)->toDateTimeString())
                       ->get();
       $posts = Posts::whereDate('created_at',Carbon::today())->get();
        return $posts;
    }

    public function getPostwithComments($id){
        $data['post'] = DB::table('posts')
                ->where('posts.id','=',$id)
                ->leftJoin('media','media.model_id','=','posts.id')
                ->where('media.collection_name','=','post_image')
                ->select('posts.id AS post_id','posts.title','posts.body','posts.created_at','media.file_name AS post_image','media.id AS postimage_id')
                ->get();
        //         ->leftJoin('comments','comments.posts_id','=',$id)
        //         ->leftJoin('users','users.id','=','comments.user_id')
        //         ->leftJoin('media','media.model_id','=','users.id')
        //         ->where('media.collection_name','=','user_avatars')
        //         ->select('posts.id AS post_id','posts.title','posts.body','posts.created_at','media.file_name AS post_image','media.id AS postimage_id',
        //         'comments.id AS comment_id','comments.comment','comments.created_at','users.username','media.file_name AS user_avatar','media.id AS image_id')
        //         ->get();
        $data['comments'] = DB::table('comments')
                    ->where('comments.posts_id','=',$id)
                    // ->select('comments.id AS comment_id','comments.comment','comments.created_at')->get();
                    ->leftJoin('users','users.id','=','comments.user_id')
                    ->leftJoin('media','media.model_id','=','users.id')
                    ->where('media.collection_name','=','user_avatars')
                    ->select('comments.id AS comment_id','comments.comment','comments.created_at','users.username','media.file_name AS user_avatar','media.id AS image_id')
                    ->get();
        return $data;
    }

    public function getPostsByDate($date){
        $posts_by_category_ids = $this->getPostsByCategories();
        $data['newsPosts'] = DB::table('posts')->select('*')
                    ->whereIn('id',json_decode(json_encode($posts_by_category_ids['news_posts']->toArray()),true))
                    ->where('posts.created_at','like','%' . $date . '%')
                    ->get();
        $data['entertainmentPosts'] = DB::table('posts')->select('*')
                    ->whereIn('id',json_decode(json_encode($posts_by_category_ids['entertainment_posts']->toArray()),true))
                    ->where('posts.created_at','like','%' . $date . '%')
                    ->get();
        // $data['posts'] = DB::table('posts')
        //                 ->orWhere('posts.created_at','like','%' . $date . '%')
        //                 ->get();
        // dd($data);
        return $data;
    }

    public function getPostById($id){
        // dd($this->post::findOrFail($id));
        
        return $this->post::findOrFail($id);
    }
    public function getPostByIdNonAuth($id){
        // $post = $this->post::findOrFail($id);
        $post = $this->getPostwithComments($id);
        // dd($posts);

        return $post;
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
