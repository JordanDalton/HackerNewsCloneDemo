<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Name
    |--------------------------------------------------------------------------
    |
    | Set the name of the site. This will be shown in areas such as the page
    | title, copyright, or anywhere else you define in the views.
    |
    */

    'site_name' => 'Hacker News Clone',

    /*
    |--------------------------------------------------------------------------
    | Ask Title Prefix
    |--------------------------------------------------------------------------
    |
    | When is a post is made that will serve as a question to the rest of the
    | site users we will need to prefix all of the titles for that post.
    |
    | Before: What do you think of Laravel 5?
    | After:  ASK HNC: What do you think of my site?
    |
    | Please note the added space after the colon.
    */

    'ask_title_prefix' => 'Ask HNC: ',

    /*
    |--------------------------------------------------------------------------
    | Show Title Prefix
    |--------------------------------------------------------------------------
    |
    | When is a post is made where a user wants to show off their website we
    | will need to prefix all of the titles for that post.
    |
    | Before: HackerNewsClone.com
    | After:  Show HNC: What do you think of my site?
    |
    | Please note the added space after the colon.
    |
    */

    'show_title_prefix' => 'Show HNC: '
];