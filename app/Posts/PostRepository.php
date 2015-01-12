<?php namespace App\Posts;

use App\Core\RepositoryTrait;

class PostRepository implements PostRepositoryInterface {

    use RepositoryTrait;

    /**
     * @var Post
     */
    private $model;

    /**
     * Create new PostRepository instance.
     *
     * @param Post $model
     */
    public function __construct( Post $model )
    {
        $this->model = $model;
    }

    /**
     * Return a list of all post ids.
     *
     * @return array
     */
    public function getIdList()
    {
        return $this->model->lists('id');
    }

    /**
     * Fetch all records and return them in as paginated.
     *
     * @param int   $per_page The number of records to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginated( $per_page = 15, $columns = ['*'] )
    {
        return $this->model->paginate( $per_page, $columns);
    }

    /**
     * Fetch all records and return them in paginated form. We will include all eager loaded data as needed.
     *
     * @param array $with       Related data that we want eager-loaded.
     * @param int   $per_page   The number of record to show on each page.
     * @param array $columns    The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedWith( $with = [], $per_page = 15, $columns = ['*'] )
    {
        return $this->model->with( $with )->paginate( $per_page, $columns );
    }

    /**
     * Fetch all records and return them in paginated form. Related comments will be in the results as well.
     *
     * @param int   $per_page   The number of record to show on each page.
     * @param array $columns    The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedWithComments( $per_page = 15, $columns = ['*'] )
    {
        return $this->getPaginatedWith( ['comments'], $per_page, $columns );
    }

    /**
     * Fetch all records and return them in paginated form. Related user and comments will be in the results as well.
     *
     * @param int   $per_page   The number of record to show on each page.
     * @param array $columns    The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedWithUserAndComments( $per_page = 15, $columns = ['*'] )
    {
        return $this->getPaginatedWith(['comments', 'user'], $per_page, $columns);
    }

    /**
     * Locate item record by it's ID number.
     *
     * @param $id
     */
    public function findById( $id )
    {
        return $this->getModel()->findOrFail( $id );
    }

    /**
     * Locate item record by it's slug value.
     *
     * @param $slug
     *
     * @return mixed
     */
    public function findBySlug( $slug )
    {
        return $this->getModel()->whereSlug( $slug )->firstOrFail();
    }
} 