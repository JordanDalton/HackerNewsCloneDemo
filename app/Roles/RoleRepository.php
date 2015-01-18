<?php namespace App\Roles;

use App\Core\RepositoryTrait;
use App\Core\SoftDeleteRepositoryTrait;

class RoleRepository implements RoleRepositoryInterface {

    use RepositoryTrait, SoftDeleteRepositoryTrait;

    /**
     * The role model.
     *
     * @var Role
     */
    protected $model;

    /**
     * Create new RoleRepository instance.
     *
     * @param Role $model
     */
    public function __construct( Role $model )
    {
        $this->model = $model;
    }

    /**
     * Find a role by it's ID number.
     *
     * @param $id
     */
    public function findById( $id )
    {
        return $this->getModel()->withTrashed()->findOrFail( $id );
    }

    /**
     * Find a non-core role by it's ID number.
     *
     * @param $id
     *
     * @return mixed
     */
    public function findNonCoreRoleById( $id )
    {
        return $this->getModel()->nonCore()->findOrFail( $id );
    }

    /**
     * Return id list of available roles.
     *
     * @return mixed
     */
    public function getIdList()
    {
        return $this->getModel()->lists('id');
    }

    /**
     * Return a list of available roles.
     *
     * @return array
     */
    public function getList()
    {
        return $this->getModel()->lists('name', 'id');
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
        return $this->getModel()->paginate( $perPage );
    }

    /**
     * Fetch all roles records from the database and return in a paginated collection.
     *
     * @param int   $per_page The number of records you want to be shown on each page.
     * @param array $columns  The columns of data you want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedResourceListing( $per_page = 15, $columns = [ '*' ])
    {
        return $this->getModel()->with('users')->latest()->paginate( $per_page , $columns );
    }

    /**
     * Fetch all roles records by provided search criteria from the database and return in a paginated collection.
     *
     * @param string $criteria The role provided search criteria
     * @param int   $per_page The number of records you want to be shown on each page.
     * @param array $columns  The columns of data you want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedResourceListingByCriteria( $criteria, $per_page = 15, $columns = [ '*' ])
    {
        return $this->getModel()->with('users')->criteria($criteria)->latest()->paginate( $per_page , $columns );
    }

    /**
     * Return all roles and include users data in the return.
     *
     * @return mixed
     */
    public function getRolesWithCounts()
    {
        return $this->getModel()->with('users')->get();
    }
}