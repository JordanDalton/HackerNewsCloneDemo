<?php namespace App\Users;

use App\Core\BasePresenter;
use Carbon\Carbon;

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

    public function getAbout( $raw = false )
    {
        // Obtain the about me text.
        //
        $about_me = $this->getWrappedObject()->about;

        // Return the raw if requried.
        //
        if( $raw ) return $about_me;

        // If $raw = true we will return the raw comment.
        //
        // Otherwise we will return it in a manner to where each new line
        // will become a <br>. We will also prevent the <br> from being
        // stripped out.
        //
        // This is what you would edit should you want additional tags such
        // as links to be shown.
        //
        return strip_tags( nl2br( $about_me ), '<br>' );
    }

    /**
     * Return the user's computed average
     *
     * @return int|float
     */
    public function getAverage()
    {
        $karma = $this->getWrappedObject()->karma;
        $days  = $this->getWrappedObject()->created_at->diffInDays(Carbon::now());

        return ($karma !== $days && $days !== 0) ? number_format($karma / $days, 2) : $karma;
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
     * Return the link to edit the user's profile.
     *
     * @return string
     */
    public function getEditProfileLink()
    {
        return route('users.edit', $this->getWrappedObject()->username);
    }

    /**
     * Return the email address.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getWrappedObject()->email;
    }

    /**
     * Return the ID number of the user.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getWrappedObject()->id;
    }

    /**
     * Get the users computed karma score.
     *
     * @return int
     */
    public function getKarmaScore()
    {
        return $this->getWrappedObject()->karma;
    }

    /**
     * Return the link to the users profile.
     *
     * @return string
     */
    public function getProfileLink()
    {
        return route('users.show', $this->getWrappedObject()->username);
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