<?php namespace App\Posts;

use App\Core\RepositoryTrait;
use DB;

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
     * Locate post record by it's ID number.
     *
     * @param $id
     *
     * @return mixed
     */
    public function findById( $id )
    {
        return $this->findByIdWith( $id, ['user'] );
    }

    /**
     * Location post record by it's ID number and include related data as needed.
     *
     * @param int   $id
     * @param array $with
     * @param array $columns
     *
     * @return mixed
     */
    public function findByIdWith( $id , $with = [ ] , $columns = [ '*' ] )
    {
        return $this->getModel()->with( $with )->findOrFail( $id , $columns );
    }

    /**
     * Fetch a post record by it's ID number and include data about the user who made the post,
     * the comments made towards the post, and the user information about the person who made
     * the comment.
     *
     * @param       $id
     *
     * @return mixed
     */
    public function findByIdWithUserAndComments( $id )
    {
        return $this->getModel()->with(
            'user' ,
            'comments' ,
            'comments.user',
            'parentComments',
            'parentComments.user'
        )->find( $id );
    }

    /**
     * Locate post record by it's slug value.
     *
     * @param $slug
     *
     * @return mixed
     */
    public function findBySlug( $slug )
    {
        return $this->getModel()->whereSlug( $slug )->firstOrFail();
    }

    /**
     * Return a list of all post ids.
     *
     * @return array
     */
    public function getIdList()
    {
        return $this->model->lists( 'id' );
    }

    /**
     * Fetch all records and return them in as paginated.
     *
     * @param int   $per_page The number of records to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginated( $per_page = 15 , $columns = [ '*' ] )
    {
        return $this->model->paginate( $per_page , $columns );
    }

    /**
     * Fetch records that have been marked as "ask" and return them in paginated form. Related user and comments
     * will be in the results as well.
     *
     * @param int   $per_page The number of record to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return mixed
     */
    public function getPaginatedAskWithUserAndComments( $per_page = 15, $columns = [ '*' ])
    {
        return $this->getMOdel()->with(['comments', 'user'])->ask()->paginate( $per_page, $columns );
    }

    /**
     * Fetch the newest record and return them in paginated form
     * @param int   $per_page
     * @param array $columns
     *
     * @return mixed
     */
    public function getPaignatedNewestWithComments( $per_page = 15, $columns = [ '*' ] )
    {
        return $this->getModel()->latest()->paginate( $per_page, $columns);
    }

    /**
     * Fetch all records and return them in paginated form. We will include all eager loaded data as needed.
     *
     * @param array $with     Related data that we want eager-loaded.
     * @param int   $per_page The number of record to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedWith( $with = [ ] , $per_page = 15 , $columns = [ '*' ] )
    {
        return $this->getModel()->with( $with )->paginate( $per_page , $columns );
    }

    /**
     * Fetch all records and return them in paginated form. We will include all eager loaded data as needed as
     * well as apply the ranking algorithm.
     *
     * @param array $with     Related data that we want eager-loaded.
     * @param int   $per_page The number of record to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedRankWith( $with = [ ] , $per_page = 15 , $columns = [ '*' ] )
    {
        return $this->getModel()->with( $with )->ranked()->paginate( $per_page , $columns );
    }

    /**
     * Fetch the newest records and return them in paginated form. Related user and comments will be in the results as well.
     *
     * @param int   $per_page The number of record to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedNewestWithUserAndComments( $per_page = 15 , $columns = [ '*' ] )
    {
        return $this->getModel()->with( [ 'comments', 'user' ]  )->latest()->paginate( $per_page , $columns );
    }

    /**
     * Fetch records that have been marked as show and return them in paginated form. Related user and comments
     * will be in the results as well.
     *
     * @param int   $per_page The number of record to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return mixed
     */
    public function getPaginatedShowOffWithUserAndComments( $per_page = 15, $columns = [ '*' ])
    {
        return $this->getModel()->with(['comments', 'user'])->ranked()->show()->paginate( $per_page, $columns );
    }

    /**
     * Fetch all records and return them in paginated form. Related user and comments will be in the results as well.
     *
     * @param int   $per_page The number of record to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedWithUserAndComments( $per_page = 15 , $columns = [ '*' ] )
    {
        return $this->getPaginatedRankWith(['comments', 'user'], $per_page, $columns);
    }
} 