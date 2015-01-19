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

// Features Page.
//
Route::get('features', [
    'as'   => 'features',
    'uses' => 'HomeController@features',
]);

// Admin Namespace Routing Group
//
Route::group( [
    'middleware' => [ 'auth' , 'roleGatekeeper' ] ,
    'namespace'  => 'Admin' ,
    'prefix'     => 'admin' ,
    'roles'      => [ 'Administrators' , 'Moderators' ]
] , function ()
{
    // Admin Homepage
    //
    Route::get( '/' , [
        'as' => 'admin' ,
        function ()
        {
            return redirect()->route( 'admin.dashboard.index' );
        }
    ] );

    // Admin Dashboard
    //
    Route::get( 'dashboard' , [
        'as'   => 'admin.dashboard.index' ,
        'uses' => 'DashboardController@index'
    ] );

    // Comments Controller
    //
    Route::resource( 'comments' , 'CommentsController' );

    // Posts Resource
    //
    Route::resource( 'posts' , 'PostsController' );

    // Roles Resource
    //
    Route::resource( 'roles' , 'RolesController' );

    // Users Resource
    //
    Route::resource( 'users' , 'UsersController' );

    // Votes Resource
    //
    Route::resource( 'votes' , 'VotesController' );
} );

// Auth Namespace Routing Group
//
Route::group( [ 'namespace' => 'Auth' ] , function ()
{
    // When a user registers they will be sent a email verification code. When they
    // visit the link it will take them to this page.
    //
    Route::get( 'verify-email/{email_authentication_code}' , [
        'as'   => 'auth.email.verify' ,
        'uses' => 'AuthController@getEmailVerify'
    ] );

    // Login Page
    //
    Route::get( 'login' , [
        'as'   => 'auth.login' ,
        'uses' => 'AuthController@getLogin' ,
    ] );

    // Process Login Page
    //
    Route::post( 'login' , [
        'as'   => 'auth.login' ,
        'uses' => 'AuthController@postLogin' ,
    ] );

    // Logout
    //
    Route::get( 'logout' , [
        'as'   => 'logout' ,
        'uses' => 'AuthController@getLogout'
    ] );

    // Register
    //
    Route::get( 'register' , [
        'as'   => 'auth.register' ,
        'uses' => 'AuthController@getRegister' ,
    ] );

    // Process Registration

    Route::post( 'register' , [
        'as'   => 'auth.register' ,
        'uses' => 'AuthController@postRegister' ,
    ] );

    // Reset Password Page
    //
    Route::get('reset-password', [
        'as'    => 'auth.password',
        'uses'  => 'PasswordController@getEmail'
    ]);

    // Process Password Reset Form
    //
    Route::post('reset-password', [
        'as'    => 'auth.password',
        'uses'  => 'PasswordController@postEmail'
    ]);

    // Confirm Password Reset Request
    //
    Route::get('reset/{token}', [
        'as'    => 'auth.reset',
        'uses'  => 'PasswordController@getReset'
    ]);

    // Process Password Reset Request
    //
    Route::post('reset/{token}', [
        'as'    => 'auth.reset',
        'uses'  => 'PasswordController@postReset'
    ]);

} );

// Posts Namespace Routing Group
//
Route::group( [ 'namespace' => 'Posts' ] , function ()
{
    // Ranked Posts
    //
    Route::get( '/' , [
        'as'   => 'posts.index' ,
        'uses' => 'PostsController@index'
    ] );

    // View Post
    //
    Route::get( '{id}' , [
        'as'   => 'posts.show' ,
        'uses' => 'PostsController@show'
    ] )->where( 'id' , '\d+' );

    // List posts where they ask the community.
    //
    Route::get( 'ask' , [
        'as'   => 'posts.ask' ,
        'uses' => 'PostsController@ask'
    ] );

    // List the latest posts.
    //
    Route::get( 'newest' , [
        'as'   => 'posts.newest' ,
        'uses' => 'PostsController@newest'
    ] );

    // List posts where the user wants to show off a site.
    //
    Route::get( 'show' , [
        'as'   => 'posts.show_off' ,
        'uses' => 'PostsController@show_off'
    ] );

    // Submit a new post.
    //
    Route::get( 'submit' , [
        'as'         => 'posts.create' ,
        'middleware' => [ 'auth' , 'roleGatekeeper' ] ,
        'uses'       => 'PostsController@create' ,
        'roles'      => [ 'Administrators' , 'Moderators' , 'Users' ]
    ] );

    // Process new post submission.
    //
    Route::post( 'submit' , [
        'as'         => 'posts.create' ,
        'middleware' => [ 'auth' , 'roleGatekeeper' ] ,
        'uses'       => 'PostsController@store' ,
        'roles'      => [ 'Administrators' , 'Moderators' , 'Users' ]
    ] );

    // Show post that have been submitted by the user.
    //
    Route::get('submitted', [
        'as'         => 'posts.submitted',
        'middleware' => [ 'auth' , 'roleGatekeeper' ] ,
        'uses'       => 'PostsController@submitted' ,
        'roles'      => [ 'Administrators' , 'Moderators' , 'Users' ]
    ]);

    // Cast vote towards post.
    //
    Route::post( '{id}/vote' , [
        'as'         => 'posts.vote' ,
        'middleware' => [ 'auth' , 'roleGatekeeper' ] ,
        'uses'       => 'PostsController@vote' ,
        'roles'      => [ 'Administrators' , 'Moderators' , 'Users' ]
    ] );
} );

// Comments Resource
//
Route::resource( 'comments' , 'Comments\CommentsController' );

// Comments Namespace Routing Group
//
Route::group( [ 'namespace' => 'Comments' ] , function ()
{
    // Latest Comments
    //
    Route::get( 'newcomments' , [
        'as'   => 'comments.newest' ,
        'uses' => 'CommentsController@newest'
    ] );

    // Cate vote toward comment.
    //
    Route::post( 'comments/{id}/vote' , [
        'as'   => 'comments.vote' ,
        'uses' => 'CommentsController@vote'
    ] );

    // Show comments that have been submitted by the user.
    //
    Route::get('threads', [
        'as'         => 'comments.threads',
        'middleware' => [ 'auth' , 'roleGatekeeper' ] ,
        'uses'       => 'CommentsController@threads' ,
        'roles'      => [ 'Administrators' , 'Moderators' , 'Users' ]
    ]);
} );

// User Namespace Routing Group
//
Route::group( [ 'namespace' => 'Users' ] , function ()
{
    // The Users Resource
    //
    Route::resource( 'users' , 'UsersController' );
} );