<?php namespace App\Votes;

use Auth;

class VoteObserver {

    /**
     * Observe when a vote record is in the process of being created.
     *
     * @param $vote
     */
    public function creating( $vote )
    {
        // Automatically assign the logged in users id number.
        //
        $vote->user_id = Auth::id();
    }

    /**
     * Observe for when after a vote record has been created.
     *
     * @param $vote
     */
    public function created( $vote )
    {
        // Access the voteable record and update it's votes count.
        //
        $vote->voteable->update(['votes' => $vote->count()]);
    }
} 