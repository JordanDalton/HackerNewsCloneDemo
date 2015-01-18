<?php namespace App\Votes;

use App\Core\RepositoryTrait;
use App\Core\SoftDeleteRepositoryTrait;
use App\Users\User;

class VoteRepository implements VoteRepositoryInterface {

    use RepositoryTrait, SoftDeleteRepositoryTrait;

    /**
     * @var Vote
     */
    private $model;

    /**
     * Create new VoteRepository instance.
     *
     * @param Vote $model
     */
    public function __construct( Vote $model )
    {
        $this->model = $model;
    }

    /**
     * Apply vote to a given record.
     *
     * @param $record
     *
     * @return mixed
     */
    public function applyVoteToRecord( $record )
    {
        return $record->votes()->save( $this->createNewInstance() );
    }

    /**
     * Check if the user has already voted for the record.
     *
     * @param User  $user
     * @param mixed $record
     *
     * @return int
     */
    public function checkIfUserAlreadyVotedForRecord( User $user, $record )
    {
        return $record->votes()->whereUserId( $user->id )->count();
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
        return $this->getModel()->withTrashed()->with('user', 'voteable')->latest()->paginate( $per_page , $columns );
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
        return $this->getModel()->withTrashed()->with('user', 'voteable')->latest()->criteria( $search_parameters )->paginate( $per_page, $columns );
    }

    /**
     * Count the number of votes between 2 dates.
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
}