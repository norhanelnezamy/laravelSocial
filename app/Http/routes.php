<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::auth();
Route::get('/home', 'HomeController@index');
Route::get('/profile/{id}', 'HomeController@profile');
Route::post('/post/create','PostsController@store');
Route::post('/post/update/{id}','PostsController@update');
Route::get('/post/delete/{id}','PostsController@destroy');
Route::get('/comment/delete/{id}','CommentsController@destroy');
Route::get('/comments/show/{id}','CommentsController@show');
Route::post('/comment/add','CommentsController@store');
Route::post('/comment/update/{id}','CommentsController@update');
