<?php namespace App\Users;

use App\Core\RepositoryTrait;

class UserRepository implements UserRepositoryInterface {

    use RepositoryTrait;

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
     * Find a specific user record by it's username.
     *
     * @param mixed $username
     */
    public function findByUsername( $username )
    {
        return $this->getModel()->whereUsername( $username )->firstOrFail();
    }

    /**
     * Return a list of all user ids.
     *
     * @return array
     */
    public function getIdList()
    {
        return $this->model->lists('id');
    }

    /**
     * Fetch all users records from the database and return in a paginated collection.
     */
    public function getPaginatedResourceListing( $per_page = 15, $columns = [ '*' ])
    {
        return $this->getModel()->latest()->paginate( $per_page , $columns );
    }
} 