<?php namespace App\Users;

use App\Core\RepositoryTrait;
use App\Core\SoftDeleteRepositoryTrait;
use App\Roles\Role;

class UserRepository implements UserRepositoryInterface {

    use RepositoryTrait, SoftDeleteRepositoryTrait;

    /**
     * The user model.
     *
     * @var User
     */
    private $model;

    /**
     * Create new UserRepository instance.
     *
     * @param User $model
     */
    public function __construct( User $model )
    {
        $this->model = $model;
    }

    /**
     * Assign/Synchronize roles to a given user account.
     *
     * @param User  $record
     * @param array $roles
     *
     * @return array
     */
    public function attachRoles( $record, $roles = [] )
    {
        return $record->roles()->sync( $roles );
    }

    /**
     * Find a specific user record by it's ID number.
     *
     * @param $id
     *
     * @return mixed
     */
    public function findById( $id )
    {
        return $this->getModel()->findOrFail( $id );
    }

    /**
     * Find a specific user record by it's ID number. We will include their assigned
     * roles in the response data as well.
     *
     * @param $id
     *
     * @return mixed
     */
    public function findByIdWithRoles( $id )
    {
        return $this->getModel()->with('roles')->withTrashed()->findOrFail( $id );
    }

    /**
     * Find a specific user record by it's username.
     *
     * @param mixed $username
     */
    public function findByUsername( $username )
    {
        return $this->getModel()->unbanned()->whereUsername( $username )->firstOrFail();
    }

    /**
     * Search within a role for users based on a supplied search criteria.
     *
     * @param Role   $role     The role model.
     * @param array  $criteria The search criteria.
     * @param int    $per_page The number of records to show on each page.
     * @param array  $columns  The columns we want returned.
     *
     * @return mixed
     */
    public function findWithinRoleByCriteria( Role $role, $criteria = [] , $per_page = 15, $columns = [ '*' ] )
    {
        return $role->users()->criteria( $criteria )->paginate( $per_page, $columns );
    }

    /**
     * Return a list of all user ids.
     *
     * @return array
     */
    public function getIdList()
    {
        return $this->getModel()->lists('id');
    }

    /**
     * Return a list of all users.
     *
     * @return array
     */
    public function getList()
    {
        return $this->getModel()->lists('username', 'id');
    }

    /**
     * Fetch all users records from the database and return in a paginated collection.
     *
     * @param int   $per_page The number of records you want to be shown on each page.
     * @param array $columns  The columns of data you want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedResourceListing( $per_page = 15, $columns = [ '*' ])
    {
        return $this->getModel()->withTrashed()->latest()->paginate( $per_page , $columns );
    }

    /**
     * Fetch all users records by provided search criteria from the database and return in a paginated collection.
     *
     * @param array $criteria The user provided search parameters.
     * @param int   $per_page The number of records you want to be shown on each page.
     * @param array $columns  The columns of data you want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedResourceListingByCriteria( $criteria = [], $per_page = 15, $columns = [ '*' ])
    {
        return $this->getModel()->withTrashed()->criteria($criteria)->latest()->paginate( $per_page , $columns );
    }

    /**
     * Query the database to see if the supplied $email_authentication_code matches
     * that of a user that has yet to be activated.
     *
     * @param string $email_authentication_code The email verification code that was emailed to the user.
     *
     * @return User|null
     */
    public function isValidEmailAuthenticationCode( $email_authentication_code )
    {
        return $this->getModel()->inactive()->whereEmailAuthenticationCode( $email_authentication_code )->first();
    }

    /**
     * Mark a user account as email authenticated.
     *
     * @param User $account
     *
     * @return boolean
     */
    public function markAccountAsEmailAuthenticated( $account )
    {
        return $account->fill([
            'activated_at' => new DateTime,
            'active' => 1
        ])->save();
    }

    /**
     * Find a user record simply by it's username. No other data will be eager-loaded.
     *
     * @param string $username
     *
     * @return mixed
     */
    public function simplyFindByUsername( $username )
    {
        return $this->getModel()->withTrashed()->whereUsername( $username )->firstOrFail();
    }
} 