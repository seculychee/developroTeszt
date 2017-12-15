<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', 'PostController@test');


Route::group(['prefix' => 'posts', 'as' => 'post.'], function () {
//posts
    Route::get('/', 'PostController@index');
    Route::post('/', 'PostController@create');
    Route::get('/{post_id}', 'PostController@show');
    Route::put('/{post_id}', 'PostController@edit');
    Route::delete('/{post_id}', 'PostController@destroy');


//comment
    Route::get('/{post_id}/comments', 'CommentController@index');
    Route::post('/{post_id}/comments', 'CommentController@create');
    Route::delete('/{post_id}/comments/{comment_id}', 'CommentController@destroy');

});
