<?php

use App\Applications\Post\Model\Category;
use Illuminate\Database\Seeder;
use App\Applications\User\Model\User;
use App\Applications\Post\Model\Posts;
use App\Applications\Post\Model\Comment;
use App\PostsCategories;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $this->user = User::class;

        // factory(User::class,5)->create()->each(function (User $user){
        //         $post = factory(Posts::class)->create();
        //         $category = Category::inRandomOrder()->first();
        //         $post->category()->save($category);
        //         $user->posts()->save($post);
        //         $posts = collect($post);
        //         $posts->push($post);
        //         for($i=0;$i<random_int(1,5);$i++){
        //             $post = factory(Posts::class)->make();
        //             $comment = factory(Comment::class)->create();
        //             $post->comment()->save($comment);
        //             $posts->push($post);
        //         };
        //        $user->posts()->saveMany($posts);
        // // });
        // factory(Posts::class,10)->create()->each(function (Posts $post){
        //     // $user = $this->user::findOrFail(1);
        //     // $post->user()->save($user);
        //     $category = Category::inRandomOrder()->first();
        //     $post->category()->save($category);
            // $comment = factory(Comment::class)->create();
            // $post->comment()->save($comment);
            // $comments = collect([$comment]);
            // for($i=0;$i<random_int(1,5);$i++){
            //     $comment = factory(Comment::class)->create();
            //     $comments->push($comment);
            // };
            // $post->comment()->saveMany($comments);
        // });
    //    factory(Posts::class, 5)->create();
      factory(PostsCategories::class,25)->create();
    
    }
}
