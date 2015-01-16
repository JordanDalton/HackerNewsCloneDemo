<?php namespace App\Roles;

class RoleRepository implements RoleRepositoryInterface {

    /**
     * The role model.
     *
     * @var Role
     */
    protected $role;

    /**
     * Create new RoleRepository instance.
     *
     * @param Role $role
     */
    public function __construct( Role $role )
    {
        $this->role = $role;
    }

    /**
     * Return id list of available roles.
     *
     * @return mixed
     */
    public function getIdList()
    {
        return $this->role->lists('id');
    }

    /**
     * Return a list of available roles.
     *
     * @return array
     */
    public function getList()
    {
        return $this->role->lists('name', 'id');
    }

    /**
     * Return paginated list of role.
     *
     * @param int $perPage The number of record to show on each page.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginated( $perPage = 15 )
    {
        return $this->role->paginate( $perPage );
    }

    /**
     * Return the table name of the model.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->role->getTable();
    }
}