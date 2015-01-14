<?php namespace App\Votes;

use Auth;

class VoteObserver {

    /**
     * Observe when a vote record is in the process of being saved.
     *
     * @param $vote
     */
    public function saving( $vote )
    {
        // Automatically assign the logged in users id number.
        //
        $vote->user_id = Auth::id();
    }

} 