<?php namespace App\Votes;

use App\Core\RepositoryTrait;

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
}