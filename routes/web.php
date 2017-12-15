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


Route::get('/home', 'HomeController@index')->name('home');

// 
Route::get('userpoint', 'PostController@userpoint');
Route::get('upvote/{postid}/{userid}', 'PostController@upvote');
Route::get('post', 'PostController@index');
Route::get('comment/{postid}', 'PostController@getcomment');
// Route::get('post/{postid}', 'PostController@show');
// Route::post('post', 'PostController@store');
// // Route::post('comment/{postid}', 'PostController@comment');
// Route::put('post/{postid}', 'PostController@update');
// Route::delete('post/{postid}', 'PostController@delete');

// Route::get('upvote/{postid}', 'PostController@upvote');
// Route::get('downvote/{postid}', 'PostController@downvote');

// // for testing count
// Route::get('count/{postid}', 'PostController@count');

Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');



