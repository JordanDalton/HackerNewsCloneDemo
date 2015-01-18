<?php namespace App\Posts;

use App\Core\RepositoryTrait;
use App\Core\SoftDeleteRepositoryTrait;
use DB;

class PostRepository implements PostRepositoryInterface {

    use RepositoryTrait, SoftDeleteRepositoryTrait;

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
     * @param int $id
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
        return $this->getModel()->with(['comments', 'user'])->ask()->paginate( $per_page, $columns );
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
        return $this->getModel()->with( $with )->ranked()->byUnbannedUser()->paginate( $per_page , $columns );
    }

    /**
     * Fetch all comments records from the database and return in a paginated collection.
     *
     * @param int   $per_page The number of records you want to be shown on each page.
     * @param array $columns  The columns of data you want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedResourceListing( $per_page = 15, $columns = [ '*' ])
    {
        return $this->getModel()->withTrashed()->with('user')->latest()->paginate( $per_page , $columns );
    }

    /**
     * Fetch all posts records by provided search parameters from the database and return in a paginated collection.
     *
     * @param array $search_parameters The search parameters.
     * @param int   $per_page The number of records you want to be shown on each page.
     * @param array $columns  The columns of data you want returned.

     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedResourceListingByCriteria( $search_parameters = [] , $per_page = 15, $columns = [ '*' ])
    {
        // We will begin building our query.
        //
        return $this->getModel()->withTrashed()->with('user')->latest()->criteria( $search_parameters )->paginate( $per_page, $columns );
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

    /**
     * Fetch all records and return them in paginated form. Related user and comments will be in the results as well.
     *
     * @param int   $user_id  The user's ID number.
     * @param int   $per_page The number of record to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedWithUserAndCommentsByUserId( $user_id, $per_page = 15 , $columns = [ '*' ] )
    {
        return $this->getModel()->with( ['comments', 'user'] )->ranked()->byUnbannedUser()->whereUserId( $user_id )->paginate( $per_page , $columns );
    }

    /**
     * Get today's ask posts count.
     *
     * @return mixed
     */
    public function getTodaysAskPostCount()
    {
        return $this->getModel()->ask()->byUnbannedUser()->today()->count();
    }

    /**
     * Get today's show posts count.
     *
     * @return mixed
     */
    public function getTodaysShowPostCount()
    {
        return $this->getModel()->show()->byUnbannedUser()->today()->count();
    }

    /**
     * Find a post record simply by it's ID number. No other data will be eager-loaded.
     *
     * @param $id
     *
     * @return mixed
     */
    public function simplyFindById( $id )
    {
        return $this->getModel()->withTrashed()->findOrFail( $id );
    }
} 