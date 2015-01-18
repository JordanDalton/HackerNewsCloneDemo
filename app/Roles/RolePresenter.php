<?php namespace App\Roles;

use App\Core\BasePresenter;

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
     * Return the role's ID number.
     *
     * @return int
     */
    public function getId()
    {
        return $this->getWrappedObject()->id;
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

    /**
     * Return the link to the role page.
     *
     * @return string
     */
    public function getShowLink()
    {
        return route('admin.roles.show', $this->getWrappedObject()->id);
    }
} 