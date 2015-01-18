<?php namespace App\Users;

use Illuminate\View\View;

class UserComposer {

    /**
     * The user repository implementation.
     *
     * @var UserRepositoryInterface
     */
    private $users;

    /**
     * Create new UserComposer instance.
     *
     * @param UserRepositoryInterface $users
     */
    public function __construct( UserRepositoryInterface $users )
    {
        $this->users = $users;
    }

    /**
     * Compose the view.
     *
     * @param $view
     */
    public function compose( View $view )
    {
        $users[0] = 'Select User';
        $users = array_merge($users, $this->users->getList());

        $view->with('users', $users);
    }
} 