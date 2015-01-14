<?php namespace App\Posts;

use Auth;
use Config;
use Illuminate\Support\Str;

class PostObserver {

    /**
     * Observe when a post record is in the process of being saved.
     *
     * @param $post
     */
    public function saving( $post )
    {
        // Automatically assign the logged in users id number.
        //
        $post->user_id = Auth::id();

        // If the start of the title matches that of our show_title_prefix (See config/settings.php) then
        // we will need to tak this as a show post.
        //
        if( $this->titleBeginsWithShowTitlePrefix( $post->title ))
        {
            $post->show = 1;
        }

        // If no url is submitted and the title does not being with the show_title_prefix (See config/settings.php)
        // then we will adjust the title to represent a question.
        //
        if( ! $post->url && ! $this->titleBeginsWithShowTitlePrefix( $post->title ))
        {
            $post->title = 'Ask HNC: ' . $post->title;
        }
    }

    /**
     * Check if the supplied title beings with the show title prefix as indicated in config/settings.php.
     *
     * @param $title
     *
     * @return bool
     */
    public function titleBeginsWithShowTitlePrefix( $title )
    {
        return Str::startsWith( $title, Config::get('show_title_prefix'));
    }
} 