<?php namespace App\Dispatchers;

use App\Users\User;
use App\Users\UserRepositoryInterface;
use Illuminate\Contracts\Mail\MailQueue;

class EmailDispatcher {

    /**
     * The MailQueue implementation.
     *
     * @var \MailQueue
     */
    private $mailQueue;

    /**
     * The user repository implementation.
     *
     * @var \App\Users\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Create new EmailDispatcher instance.
     *
     * @param MailQueue               $mailQueue
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct( MailQueue $mailQueue , UserRepositoryInterface $userRepository )
    {
        $this->mailQueue      = $mailQueue;
        $this->userRepository = $userRepository;
    }

    /**
     * Notify the administrator when a new comment is posted.
     *
     * @param $comment
     */
    public function dispatchNewCommentNotificationToAdministrators( $comment )
    {
        // Prepare the data that will be passed into the email view.
        //
        $data = $comment->toArray();

        // Fetch all administrators from the database.
        //
        $administrators = $this->userRepository->getAdministrators();

        // Loop through the the $administrators and dispatch an
        // email to each one, notifying them of the new comment.
        //
        foreach ( $administrators as $administrator )
        {
            // Push the email onto the dispatch queue.
            //
            $this->mailQueue->queue( 'emails.new.comment' , $data , function ( $message ) use ( $administrator, $comment )
            {
                //$message->to( $administrator->email, 'Administrator' )->bcc('jordan.dalton@ymail.com')->subject( 'New Comment @ ' . config('settings.site_name') );
                $message->to( 'jordan.dalton@ymail.com' )->subject( 'New Comment @ ' . config('settings.site_name') );
            } );
        }
    }

    /**
     * Notify the administrator when a new post is made.
     *
     * @param $post
     */
    public function dispatchNewPostNotificationToAdministrators( $post )
    {
        // Prepare the data that will be passed into the email view.
        //
        $data = $post->toArray();

        // Fetch all administrators from the database.
        //
        $administrators = $this->userRepository->getAdministrators();

        // Loop through the the $administrators and dispatch an
        // email to each one, notifying them of the new post.
        //
        foreach ( $administrators as $administrator )
        {
            // Push the email onto the dispatch queue.
            //
            $this->mailQueue->queue( 'emails.new.post' , $data , function ( $message ) use ( $administrator, $post )
            {
                //$message->to( $administrator->email, 'Administrator' )->bcc('jordan.dalton@ymail.com')->subject( 'New Post @ ' . config('settings.site_name') );
                $message->to( 'jordan.dalton@ymail.com' )->subject( 'New Post @ ' . config('settings.site_name') );
            } );
        }
    }

    /**
     * Notify the administrator when a new user registers.
     *
     * @param $user
     */
    public function dispatchNewUserNotificationToAdministrators( $user )
    {
        // Prepare the data that will be passed into the email view.
        //
        $data = $user->toArray();

        // Fetch all administrators from the database.
        //
        $administrators = $this->userRepository->getAdministrators();

        // Loop through the the $administrators and dispatch an
        // email to each one, notifying them of the new user.
        //
        foreach ( $administrators as $administrator )
        {
            // Push the email onto the dispatch queue.
            //
            $this->mailQueue->queue( 'emails.new.user' , $data , function ( $message ) use ( $administrator, $user )
            {
                //$message->to( $administrator->email, 'Administrator' )->bcc('jordan.dalton@ymail.com')->subject( $user->username . ' has joined ' . config('settings.site_name') );
                $message->to( 'jordan.dalton@ymail.com' )->subject( $user->username . ' has joined ' . config('settings.site_name') );
            } );
        }
    }

    /**
     * Dispatch a verification email to the users email address.
     *
     * @param User $user
     */
    public function dispatchVerificationEmailToUser( User $user )
    {
        // Prepare the data that will be passed into the email view.
        //
        $data = $user->toArray();

        // Push the email onto the dispatch queue.
        //
        /*
        $this->mailQueue->queue( 'emails.auth.email.verification' , $data , function ( $message ) use ( $user )
        {
            $message->to( $user->email , $user->username )
                ->subject( 'Thank you for joining ' . config( 'settings.site_name' ) );
        } );
        */

        // Dispatch email notification to all administrators to notify them of the new user.
        //
        $this->dispatchNewUserNotificationToAdministrators( $user );
    }
} 