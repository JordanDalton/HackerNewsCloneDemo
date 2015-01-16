<?php namespace App\Roles;

class RolePresenter extends BasePresenter {

    /**
     * Create new RolePresenter instance.
     *
     * @param Role $resource
     */
    public function __construct( Role $resource )
    {
        $this->wrappedObject = $resource;
    }

    /**
     * Return the role name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getWrappedObject()->name;
    }
} 