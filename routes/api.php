<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'posts', 'as' => 'post.'], function () {
//posts
    Route::get('/', 'PostController@index');
    Route::post('/', 'PostController@create');
    Route::get('/{post_id}', 'PostController@show');
    Route::put('/{post_id}', 'PostController@edit');
    Route::delete('/{post_id}', 'PostController@delete');


//comment
    Route::get('/{post_id}/comments', 'CommentController@index');
    Route::post('/{post_id}/comments', 'CommentController@create');
    Route::delete('/{post_id}/comments/{comment_id}', 'CommentController@delete');

});
