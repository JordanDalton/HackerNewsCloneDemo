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

// Admin Namespace Routing Group
//
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function()
{
    // Dashboard
    //
    Route::get('/', [
        'as'    => 'admin.dashboard',
        'uses'  => 'DashboardController@index'
    ]);

    // Comments Controller
    //
    Route::resource('comments', 'CommentsController');

    // Posts Resource
    //
    Route::resource('posts', 'PostsController');

    // Roles Resource
    //
    Route::resource('roles', 'RolesController');

    // Users Resource
    //
    Route::resource('users', 'UsersController');

    // Votes Resource
    //
    Route::resource('votes', 'VotesController');
});

// Auth Namespace Routing Group
//
Route::group(['namespace' => 'Auth'], function()
{
    Route::get('verify-email/{email_authentication_code}', [
        'as'    => 'auth.email.verify',
        'uses'  => 'AuthController@getEmailVerify'
    ]);

    Route::get('login', [
        'as'    => 'auth.login',
        'uses'  => 'AuthController@getLogin',
    ]);

    Route::post('login', [
        'as'    => 'auth.login',
        'uses'  => 'AuthController@postLogin',
    ]);

    Route::get('logout', [
        'as'    => 'logout',
        'uses'  => 'AuthController@getLogout'
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

    Route::get('ask', [
        'as'     => 'posts.ask',
        'uses'  => 'PostsController@ask'
    ]);

    Route::get('newest', [
        'as'     => 'posts.newest',
        'uses'  => 'PostsController@newest'
    ]);

    Route::get('show', [
       'as'     => 'posts.show_off',
        'uses'  => 'PostsController@show_off'
    ]);

    Route::get('submit', [
        'as'         => 'posts.create',
        'middleware' => ['auth'],
        'uses'       => 'PostsController@create'
    ]);

    Route::post('submit', [
        'as'         => 'posts.create',
        'middleware' => ['auth'],
        'uses'       => 'PostsController@store'
    ]);

    Route::post('{id}/vote', [
        'as'    => 'posts.vote',
        'uses'  => 'PostsController@vote'
    ]);
});

// Comments Resource
//
Route::resource('comments', 'Comments\CommentsController');

// Comments Namespace Routing Group
//
Route::group(['namespace' => 'Comments'], function()
{
    Route::get('newcomments', [
        'as'    => 'comments.newest',
        'uses'  => 'CommentsController@newest'
    ]);

    Route::post('comments/{id}/vote', [
        'as'    => 'comments.vote',
        'uses'  => 'CommentsController@vote'
    ]);
});

// User Namespace Routing Group
//
Route::group(['namespace' => 'Users'], function()
{
    // The Users Resource
    //
    Route::resource('users', 'UsersController');
});

/*
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/