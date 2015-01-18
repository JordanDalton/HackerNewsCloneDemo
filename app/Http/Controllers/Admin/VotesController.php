<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminEditVoteFormRequest;
use App\Votes\VoteRepositoryInterface;
use Input;

class VotesController extends Controller {

    /**
     * The vote repository implementation.
     *
     * @var \VoteRepositoryInterface
     */
    private $voteRepository;

    /**
     * Create new VotesController instance.
     *
     * @param VoteRepositoryInterface $voteRepository
     */
    public function __construct( VoteRepositoryInterface $voteRepository )
    {
        $this->voteRepository = $voteRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Capture any provided search criteria.
        //
        $criteria = Input::get( 'vote' , false );

        // Fetch a paginated listing of all votes in the system.
        //
        $votes = $criteria
            ? $this->voteRepository->getPaginatedResourceListingByCriteria( $criteria )
            : $this->voteRepository->getPaginatedResourceListing();

        // Show the page.
        //
        return routeView()->withVotes( $votes );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return redirect( 'admin.votes.index' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        return redirect( 'admin.votes.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show( $id )
    {
        return redirect( 'admin.votes.index' );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit( $id )
    {
        return redirect( 'admin.votes.index' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update( $id )
    {
        return redirect( 'admin.votes.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy( $id )
    {
        // Fetch the vote record from the database.
        //
        $vote = $this->voteRepository->simplyFindById( $id );

        // If the record is not deleted then we will delete it.
        //
        if ( ! $vote->trash() )
        {
            $this->voteRepository->deleteRecord( $vote );
        }

        // Return the response response.
        //
        return ['success' => 'The vote has successfully been deleted'];
    }

}
