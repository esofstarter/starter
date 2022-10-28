<?php

use Illuminate\Http\Request;

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
    Route::get('allPosts', 'Controllers\PostController@allPosts');
    Route::post('{id}/new', 'Controllers\SlaController@newGuest');
    Route::post('confirm', 'Controllers\SlaController@confirm');
});

// Authorized routes
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
    Route::post('new', 'Controllers\PostController@savePost');
});
