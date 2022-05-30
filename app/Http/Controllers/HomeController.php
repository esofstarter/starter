<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('app');
    }


    /**
     * Run an artisan command from url (used for debugging)
     *
     * @return void
     */
    public function runCommand($command)
    {
        Artisan::call($command);
    }

    /**
     * Get initial data for Vue.js application
     */
    public function vue()
    {
        $homeItems = [
            [
                'label' => 'strings.dashboard',
                'name' => 'item_dashboard',
                'link' => 'dashboard',
                'permission' => 'user_view', // Change to dashboard_view
            ],
            [
                'label' => 'strings.users.main',
                'name' => 'item_users',
                'link' => 'users',
                'expanded' => false,
                'permission' => 'user_view',
                'subcategories' => [
                    [
                        'label' => 'strings.users.admin',
                        'name' => 'item_users',
                        'link' => 'users',
                        'permission' => 'user_view',
                    ],
                    [
                        'label' => 'strings.users.public',
                        'name' => 'item_users_public',
                        'link' => 'users.public',
                        'permission' => 'user_view',
                    ],
                ],
            ],
            [
                'label' => 'strings.posts.main',
                'name' => 'item_posts',
                'link' => 'posts',
                'expanded' => false,
                'permission' => 'user_view',
                'subcategories' => [
                    [
                        'label' => 'strings.posts.my_posts',
                        'name' => 'my_posts',
                        'link' => 'my_posts',
                        'permission' => 'user_view',
                    ],
                    [
                        'label' => 'strings.posts.all_posts',
                        'name' => 'all_posts',
                        'link' => 'all_posts',
                        'permission' => 'user_view',
                     ],
                     [
                        'label' => 'strings.posts.add_post',
                        'name' => 'add_posts',
                        'link' => 'add_posts',
                        'permission' => 'user_view',
                    ],
                ],
            ],
        ];

        $data = [
            'homeItems' => $homeItems,
        ];

        return $data;
    }
}
