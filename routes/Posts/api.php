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
    Route::post('{id}/new', 'Controllers\SlaController@newGuest');
    Route::post('confirm', 'Controllers\SlaController@confirm');
});

// Authorized routes
Route::group([
    'middleware' => ['api','jwt.renew'],
    'prefix' => 'posts',
], function () {
    Route::get('all', 'Controllers\PostController@allPosts')->middleware('permission:request_view');
    Route::get('{id}/get', 'Controllers\PostController@getPostById')->middleware('permission:request_view');
    Route::get('{user}/get', 'Controllers\PostController@getPostById')->middleware('permission:request_view' , 'role:administrator');
    Route::post('{id}/edit', 'Controllers\PostController@editPost')->middleware('permission:request_write');
    Route::get('{id}/delete', 'Controllers\PostController@deletePost')->middleware('permission:request_write', 'role:administrator');
    Route::get('draw', 'Controllers\PostController@allPosts')->middleware('permission:request_view');
    Route::post('new', 'Controllers\PostController@savePost')->middleware('permission:request_view');
});
