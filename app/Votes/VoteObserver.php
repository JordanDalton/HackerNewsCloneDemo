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

    /**
     * Observe for when after a vote record has been saved.
     *
     * @param $vote
     */
    public function saved( $vote )
    {
        // Since a vote has been submitted we will need to access the
        // record which the vote was casted to.

        // Access the voteable record and update it's votes count.
        //
        $voteable = $vote->voteable;
        $voteable->votes = $vote->count();
        $voteable->save();
    }
} 