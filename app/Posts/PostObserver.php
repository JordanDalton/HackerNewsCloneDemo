<?php namespace App\Posts;

use App\Dispatchers\EmailDispatcher;
use Auth;
use Illuminate\Support\Str;

class PostObserver {

    /**
     * The email dispatcher.
     *
     * @var \App\Dispatchers\EmailDispatcher
     */
    protected $dispatcher;

    /**
     * Create new PostObserver instance.
     *
     * @param EmailDispatcher $dispatcher
     */
    public function __construct( EmailDispatcher $dispatcher )
    {
        $this->dispatcher = $dispatcher;
    }

    /*
     * Observe when a post record has been deleted.
     *
     * @param $post
     */
    public function deleted( $post )
    {
        // Since the user had their post deleted we will have to
        // take away some karma :(
        //
        $post->user->decrementKarma();
    }

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
     * Observe when a post record has been saved/
     *
     * @param Post $post
     */
    public function saved( $post )
    {
        // Since the user has made a post we will reward them with some more karma.
        //
        $post->user->incrementKarma();

        // Notify administrators of the new post.
        //
        $this->dispatcher->dispatchNewPostNotificationToAdministrators( $post );
    }

    /**
     * Obtain the show title prefix value from config/settings.php.
     *
     * @return string
     */
    private function getShowTitlePrefix()
    {
        return config('settings.show_title_prefix');
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