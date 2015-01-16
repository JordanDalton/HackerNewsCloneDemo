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
        $view->with('roles', $this->roles->getList());
    }
} 