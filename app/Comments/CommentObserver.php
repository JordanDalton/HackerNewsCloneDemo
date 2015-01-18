<?php namespace App\Comments;

use Auth;

class CommentObserver {

    /**
     * Observe when a comment record is in the process of being saved.
     *
     * @param $comment
     */
    public function saving( $comment )
    {
        // Automatically assign the logged in users id number.
        //
        $comment->user_id = Auth::id();
    }

    /**
     * Observe when a comment record has been saved.
     *
     * @param $comment
     */
    public function saved( $comment )
    {
        // Since the user has posted a comment we will reward them
        // with some karma.
        //
        $comment->user->incrementKarma();
    }
} 