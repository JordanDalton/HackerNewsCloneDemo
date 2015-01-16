<?php namespace App\Dispatchers;

use App\Users\User;
use Config;
use Illuminate\Contracts\Mail\MailQueue;

class EmailDispatcher {

    /**
     * The MailQueue implementation.
     *
     * @var \MailQueue
     */
    private $mailQueue;

    /**
     * Create new EmailDispatcher instance.
     *
     * @param MailQueue $mailQueue
     */
    public function __construct( MailQueue $mailQueue )
    {
        $this->mailQueue = $mailQueue;
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
        $this->mailQueue->queue('emails.auth.email.verification', $data, function( $message ) use( $user )
        {
            $message->to( $user->email, $user->username )
                    ->subject('Thank you for joining ' . Config::get('settings.site_name'));
        });
    }
} 