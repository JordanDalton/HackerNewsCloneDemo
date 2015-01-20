<?php namespace App\Comments;

use App\Dispatchers\EmailDispatcher;
use Auth;

class CommentObserver {

    /**
     * The email dispatcher.
     *
     * @var \App\Dispatchers\EmailDispatcher
     */
    protected $dispatcher;

    /**
     * Create new CommentObserver instance.
     *
     * @param EmailDispatcher $dispatcher
     */
    public function __construct( EmailDispatcher $dispatcher )
    {
        $this->dispatcher = $dispatcher;
    }

    /*
     * Observe when a comment record has been deleted.
     *
     * @param $comment
     */
    public function deleted( $comment )
    {
        // Since the user had their comment deleted we will have to
        // take away some karma :(
        //
        $comment->user->decrementKarma();
    }

    /**
     * Observe when a comment record is in the process of being created.
     *
     * @param $comment
     */
    public function creating( $comment )
    {
        // Automatically assign the logged in users id number.
        //
        $comment->user_id = Auth::id();
    }

    /**
     * Observe when a comment record has been created.
     *
     * @param $comment
     */
    public function created( $comment )
    {
        // Since the user has posted a comment we will reward them
        // with some karma.
        //
        $comment->user->incrementKarma();

        // Notify administrators of the new comment.
        //
        $this->dispatcher->dispatchNewCommentNotificationToAdministrators( $comment );
    }
} 