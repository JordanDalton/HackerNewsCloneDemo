<?php namespace App\Users;

use App\Dispatchers\EmailDispatcher;

class UserObserver {

    /**
     * The email dispatcher.
     *
     * @var \App\Dispatchers\EmailDispatcher
     */
    protected $dispatcher;

    /**
     * Create new UserObserver instance.
     *
     * @param EmailDispatcher $dispatcher
     */
    public function __construct( EmailDispatcher $dispatcher )
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Observe when a user record has been created.
     *
     * @param $user
     */
    public function created( $user )
    {
        // At minimum we will assign the user to the users group.
        //
        // $user->assignUserRole();

        // Dispatch email verification code.
        //
        $this->dispatcher->dispatchVerificationEmailToUser( $user );
    }
} 