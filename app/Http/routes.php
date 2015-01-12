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

// Posts Namespace Routing Group
//
Route::group(['namespace' => 'Posts'], function()
{
    Route::get('/', [
        'as'    => 'posts.index',
        'uses'  => 'PostsController@index'
    ]);

    Route::get('{id}', [
        'as'    => 'posts.show',
        'uses'  => 'PostsController@show'
    ])->where('id', '\d+');

    Route::get('submit', [
        'as'    => 'posts.create',
        'uses'  => 'PostsController@create'
    ]);
});

// User Namespace Routing Group
//
Route::group(['namespace' => 'Users', 'prefix' => 'users'], function()
{
    // The user profile page.
    //
    Route::get('{username}', [
        'as'    => 'users.show',
        'uses'  => 'UsersController@show'
    ]);
});

// Auth Namespace Routing Group
//
Route::group(['namespace' => 'Auth'], function()
{
    Route::get('login', [
        'as'    => 'auth.login',
        'uses'  => 'AuthController@getLogin',
    ]);

    Route::post('login', [
        'as'    => 'auth.login',
        'uses'  => 'AuthController@postLogin',
    ]);

    Route::get('register', [
        'as'    => 'auth.register',
        'uses'  => 'AuthController@getRegister',
    ]);

    Route::post('register', [
        'as'    => 'auth.register',
        'uses'  => 'AuthController@postRegister',
    ]);
});


/*
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/