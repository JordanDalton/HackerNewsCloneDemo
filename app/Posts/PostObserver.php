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
            // Mark the record as a show post.
            //
            $post->show = 1;

            // Strip the show title prefix from the submitted title.
            //
            $post->title = str_replace($this->getShowTitlePrefix(), '', $post->title);
        }

        // If no url is submitted and the title does not being with the show_title_prefix (See config/settings.php)
        // then we will mark the record as a question.
        //
        if( ! $post->url && ! $this->titleBeginsWithShowTitlePrefix( $post->title ))
        {
            // Mark the record as a ask (question) post.
            //
            $post->ask = 1;
        }
    }

    /**
     * Obtain the show title prefix value from config/settings.php.
     *
     * @return string
     */
    private function getShowTitlePrefix()
    {
        return Config::get('settings.show_title_prefix');
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
        return Str::startsWith( $title, $this->getShowTitlePrefix());
    }
} 