<?php namespace App\Users;

use App\Core\BasePresenter;

class UserPresenter extends BasePresenter {

    /**
     * Create new UserPresenter instance.
     *
     * @param User $resource
     */
    public function __construct( User $resource )
    {
        $this->wrappedObject = $resource;
    }

    /**
     * Return the user's computed average
     *
     * @return int|float
     */
    public function getAverage()
    {
        return 2.5;
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
     * Get the users computed karma score.
     *
     * @return int
     */
    public function getKarmaScore()
    {
        return 2203;
    }

    /**
     * Return the username of the user.
     *
     * @return username
     */
    public function getUsername()
    {
        return $this->getWrappedObject()->username;
    }
} 