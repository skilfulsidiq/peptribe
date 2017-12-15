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

Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');

Route::post('apiuser', 'ApiuserController@register');
//post
// Route::group(['middleware' => 'auth:api'], function() {

// Route::post('login', 'API\AuthController@login');
// Route::post('register', 'API\AuthController@register');

Route::get('post', 'PostController@index');
Route::get('post/{postid}', 'PostController@show');
Route::post('post', 'PostController@store');
Route::put('post/{postid}', 'PostController@update');
Route::delete('post/{postid}', 'PostController@delete');
//upvote and downvote
Route::get('upvote/{postid}/{userid}', 'PostController@upvote');
Route::get('downvote/{postid}/{userid}', 'PostController@downvote');

// addcomment
Route::post('comment/{postid}', 'PostController@addcomment');
Route::get('comment/{postid}', 'PostController@getcomment');

// count comment,upvote and downvote
Route::get('countupvote/{postid}', 'PostController@countupvote');
Route::get('countdownvote/{postid}', 'PostController@countdownvote');
Route::get('countcomment/{postid}', 'PostController@countcomment');

Route::get('userpoint', 'PostController@userpoint');

// });




// social logins
// Route::get('auth/{provider}', 'API\PassportController@redirectToProvider');
// Route::get('auth/{provider}/callback', 'API\PassportController@handleProviderCallback');

// Route::group(['middleware'=>'auth:api'],function(){
// 	Route::post('get_details', 'API\PassportController@getDetails');
// });

// Auth
// Route::post('register', 'Auth\RegisterController@register');
// Route::post('login', 'Auth\LoginController@login');
// Route::post('logout', 'Auth\LoginController@logout');
// Route::get('post', 'PostController@index');



