<?php namespace App\Roles;

class RoleComposer {

    /**
     * The roles repository implementation.
     *
     * @var App\Roles\RolesRepository
     */
    protected $roles;

    /**
     * Create new RoleComposer instance.
     *
     * @param $roles
     */
    function __construct( RoleRepositoryInterface $roles )
    {
        $this->roles = $roles;
    }

    /**
     * Compose the view.
     *
     * @param $view
     */
    public function compose( $view )
    {
        $roles = $this->roles->getList();

        // If the user is not administrator then we need
        // to remove the admin group from the $roles.
        //
        if( ! isAdmin() )
        {
            $roles = array_except($roles, [1]);
        }


        $view->with('roles', $roles);
    }
} 