<?php namespace App\Http\Controllers\Comments;

use App\Comments\CommentRepositoryInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentFormRequest;
use App\Http\Requests\VoteFormRequest;
use App\Votes\VoteRepositoryInterface;
use Auth;
use Input;

class CommentsController extends Controller {

    /**
     * The comment repository implementation.
     *
     * @var \App\Comments\CommentRepositoryInterface
     */
    private $commentRepository;

    /**
     * Create new CommentsController instance.
     *
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct( CommentRepositoryInterface $commentRepository )
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Display a paginated list of the newest comments.
     *
     * @return mixed
     */
    public function newest()
    {
        // Fetch the newest comments records form the database.
        //
        $comments = $this->commentRepository->getPaginatedNewestWithReplies();

        // Show the page.
        //
        return routeView()->withComments( $comments );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentFormRequest $request
     *
     * @return Response
     */
    public function store( CommentFormRequest $request )
    {
        // Define the attributes that we want to insert into the record.
        //
        $attributes = $request->only('comment', 'post_id', 'parent_id');

        // Create a new comment record.
        //
        $this->commentRepository->createRecord( $attributes );

        // Redirect the user back to the page.
        //
        return redirect()->back()->withCommentAdded(true);
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
        // Fetch the comment record from the database.
        //
        $comment = $this->commentRepository->findByIdWithReplies( $id );

        // Show the page.
        //
        return routeView()->withComment( $comment )->withUserAlreadyVoted( $comment->votedByLoggedInUser() );
    }

    /**
     * Show all of the comment threads started by the in sessino user.
     *
     * @return Response
     */
    public function threads()
    {
        // Check if a username is being passed at the query string.
        //
        $usernameQuery = Input::get('username', false);

        // Determine which username we're to use.
        //
        $username = Auth::check()
            ? ( $usernameQuery ? $usernameQuery : Auth::user()->uesrname )
            : ( $usernameQuery ? $usernameQuery : false );

        // If no username then we will forward them to the homepage.
        //
        if( ! $username ) return redirect('/');

        // Fetch the newest comments records form the database.
        //
        $comments = $this->commentRepository->getPaginatedNewestWithRepliesByUsername( $username );

        // Show the page.
        //
        return routeView()->withComments( $comments )->withUsername( $username );
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
        //
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
        //
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
        //
    }

    /**
     * Cast a vote towards a given comment.
     *
     * @param int             $id
     * @param VoteFormRequest $request
     * @param VoteRepositoryInterface $voteRepository
     *
     * @return string
     */
    public function vote( $id , VoteFormRequest $request , VoteRepositoryInterface $voteRepository )
    {
        // Fetch the comment record by the database.
        //
        $comment = $this->commentRepository->findById( $id );

        // Check if the user has already voted for this comment.
        //
        $userAlreadyVoted = $voteRepository->checkIfUserAlreadyVotedForRecord( Auth::user(), $comment );

        // Apply the vote to the comment only if the user hasn't already voted.
        //
        if( ! $userAlreadyVoted ) $voteRepository->applyVoteToRecord( $comment );

        // Return json response.
        //
        return ['success' => 'Your vote has been casted.'];
    }
}
