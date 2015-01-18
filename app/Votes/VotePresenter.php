<?php namespace App\Votes;

use App\Core\BasePresenter;

class VotePresenter extends BasePresenter {

    /**
     * Create new VotePresenter instance.
     *
     * @param Vote $resource
     */
    public function __construct( Vote $resource )
    {
        $this->wrappedObject = $resource;
    }

    /**
     * Get the difference in a human readable format for the duration since the post was created.
     *
     * @return string
     */
    public function getDurationSinceCreated()
    {
        return $this->getWrappedObject()->created_at->diffForHumans();
    }

    /**
     * Return the id of the vote.
     *
     * @return int
     */
    public function getId()
    {
        return $this->getWrappedObject()->id;
    }
} 