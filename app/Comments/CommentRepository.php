<?php namespace App\Comments;

use App\Core\RepositoryTrait;
use App\Core\SoftDeleteRepositoryTrait;

class CommentRepository implements CommentRepositoryInterface {

    use RepositoryTrait, SoftDeleteRepositoryTrait;

    /**
     * The comment model.
     *
     * @var Comment
     */
    private $model;

    /**
     * Create new CommentRepository instance.
     *
     * @param Comment $model
     */
    public function __construct( Comment $model )
    {
        $this->model = $model;
    }

    /**
     * Locate comment record by it's ID number.
     *
     * @param $id
     *
     * @return mixed
     */
    public function findById( $id )
    {
        return $this->findByIdWith( $id );
    }

    /**
     * Fetch comment record by it's ID number and include related data as needed.
     *
     * @param int   $id
     * @param array $with
     * @param array $columns
     *
     * @return mixed
     */
    public function findByIdWith( $id , $with = [ ] , $columns = [ '*' ] )
    {
        return $this->getModel()->with( $with )->byUnbannedUser()->findOrFail( $id, $columns );
    }

    /**
     * Fetch comment record by it's ID number and include related replies.
     *
     * @param $id
     *
     * @return mixed
     */
    public function findByIdWithReplies( $id )
    {
        return $this->findByIdWith( $id, ['post', 'replies', 'replies.user', 'user'] );
    }

    /**
     * Count the number of posts between 2 dates.
     *
     * @param $start_datetime
     * @param $end_datetime
     *
     * @return int
     */
    public function getCountBetweenDates( $start_datetime, $end_datetime )
    {
        return $this->getModel()->whereBetween('created_at', [$start_datetime, $end_datetime])->byUnbannedUser()->count();
    }

    /**
     * Fetch the latest records and return them in paginated form.
     *
     * @param int   $per_page The number of record to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedNewestWithReplies( $per_page = 15 , $columns = [ '*' ] )
    {
        return $this->getModel()->with(['post', 'replies', 'user'])->latest()->paginate( $per_page, $columns );
    }

    /**
     * Fetch the latest records and return them in paginated form.
     *
     * @param int   $user_id  The user's id number.
     * @param int   $per_page The number of record to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedNewestWithRepliesByUserId( $user_id, $per_page = 15 , $columns = [ '*' ] )
    {
        return $this->getModel()->with(['post', 'replies', 'user'])->latest()->whereUserId( $user_id )->paginate( $per_page, $columns );
    }

    /**
     * Fetch the latest records and return them in paginated form.
     *
     * @param int   $username  The user's username.
     * @param int   $per_page The number of record to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedNewestWithRepliesByUsername( $username, $per_page = 15 , $columns = [ '*' ] )
    {
        $userWhereHas = function( $query ) use( $username )
        {
            return $query->whereUsername( $username );
        };

        return $this->getModel()->with(['post', 'replies', 'user'])->latest()->whereHas('user', $userWhereHas)->paginate( $per_page, $columns );
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
     * Fetch all comments records by provided search parameters from the database and return in a paginated collection.
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
     * Simply find a record by it's ID number. No related data will be eager-loaded.
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