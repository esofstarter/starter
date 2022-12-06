<?php

use Illuminate\Http\Request;
use App\Applications\Post\Model\Posts;
use App\Http\Resources\PostResource;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| This file contains the api routes for the Request module
|
|
*/

// Non auth routes
Route::group([
    'middleware' => 'api',
    'prefix' => 'posts',
], function () {
    Route::get('index','Controllers\PostController@index');
    Route::get('getScrolldownPosts', 'Controllers\PostController@getScrolldownPosts');
    Route::get('allPosts', 'Controllers\PostController@allPosts');
    Route::get('latestPosts', 'Controllers\PostController@latestPosts'); //function(){ return PostResource::collection(Posts::all());})
    Route::get('{id}/fetch', 'Controllers\PostController@getPostByIdNonAuth');

    Route::get('allCategories', 'Controllers\CategoryController@allCategories');
    Route::post('{id}/new', 'Controllers\SlaController@newGuest');
    Route::post('confirm', 'Controllers\SlaController@confirm');
});

// Authorized  post routes
Route::group([
    'middleware' => ['api','jwt.renew'],
    'prefix' => 'posts',
], function () {
    Route::get('all', 'Controllers\PostController@allPosts');
    Route::get('{id}/get', 'Controllers\PostController@getPostById');
    Route::get('{user}/get', 'Controllers\PostController@getPostById');
    Route::post('{id}/edit', 'Controllers\PostController@editPost');
    Route::get('{id}/delete', 'Controllers\PostController@deletePost');
    Route::post('draw', 'Controllers\PostController@allPosts');
    Route::post('drawMyPosts', 'Controllers\PostController@getPostsByUser');
    Route::post('new', 'Controllers\PostController@savePost');
});

//Comment routes
Route::group([
    'middleware' => ['api','jwt.renew'],
    'prefix' => 'comments',
], function () {
    Route::get('all', 'Controllers\CommentController@allComments');
    Route::get('{id}/get', 'Controllers\CommentController@getCommentById');
    Route::get('{user}/get', 'Controllers\CommentController@getCommentByUser');
    Route::post('{id}/edit', 'Controllers\CommentController@editComment');
    Route::get('{id}/delete', 'Controllers\CommentController@deleteComment');
    Route::post('draw', 'Controllers\CommentController@allComment');
    Route::post('new', 'Controllers\CommentController@saveComment');
});

//Category routes
Route::group([
    'middleware' => ['api','jwt.renew'],
    'prefix' => 'category',
], function () {
    Route::get('all', 'Controllers\CategoryController@allCategories');
    Route::get('{id}/get', 'Controllers\CategoryController@getCategoryById');
//    Route::get('{user}/get', 'Controllers\CategoryController@getCommentByUser');
    Route::post('{id}/edit', 'Controllers\CategoryController@editCategory');
    Route::get('{id}/delete', 'Controllers\CategoryController@deleteCategory');
    Route::post('draw', 'Controllers\CategoryController@allCategory');
    Route::post('new', 'Controllers\CategoryController@saveCategory');
});
