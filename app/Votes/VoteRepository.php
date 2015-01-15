<?php namespace App\Votes;

use App\Core\RepositoryTrait;
use App\Users\User;

class VoteRepository implements VoteRepositoryInterface {

    use RepositoryTrait;

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
}