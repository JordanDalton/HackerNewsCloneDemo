<?php namespace App\Http\Controllers\Posts;

use App\Http\Requests;
use App\Http\Requests\EditPostFormRequest;
use App\Http\Requests\PostFormRequest;
use App\Http\Requests\VoteFormRequest;
use App\Posts\PostRepositoryInterface;
use App\Votes\VoteRepositoryInterface;
use Auth;
use Illuminate\Routing\Controller;

class PostsController extends Controller {

    /**
     * The post repository implementation.
     *
     * @var \App\Posts\PostRepositoryInterface
     */
    private $postRepository;

    /**
     * Create new PostsController instance.
     *
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct( PostRepositoryInterface $postRepository )
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a paginated list of the ask posts.
     *
     * @return mixed
     */
    public function ask()
    {
        // Fetch the newest posts records form the database.
        //
        $posts = $this->postRepository->getPaginatedAskWithUserAndComments();

        // Show the page.
        //
        return routeView()->withPosts( $posts );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Fetch all the posts as a paginated list.
        //
        $posts = $this->postRepository->getPaginatedWithUserAndComments();

        // Show the page.
        //
        return routeView()->withPosts( $posts );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Create a new post instance.
        //
        $post = $this->postRepository->createNewInstance();

        // Show the page.
        //
        return routeView()->withPost( $post );
    }

    /**
     * Display a paginated list of the newest posts.
     *
     * @return mixed
     */
    public function newest()
    {
        // Fetch the newest posts records form the database.
        //
        $posts = $this->postRepository->getPaginatedNewestWithUserAndComments();

        // Show the page.
        //
        return routeView()->withPosts( $posts );
    }

    /**
     * Display a paginated list of the newest posts.
     *
     * @return mixed
     */
    public function show_off()
    {
        // Fetch the newest posts records form the database.
        //
        $posts = $this->postRepository->getPaginatedShowOffWithUserAndComments();

        // Show the page.
        //
        return routeView()->withPosts( $posts );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostFormRequest $request
     *
     * @return Response
     */
    public function store( PostFormRequest $request )
    {
        // Define the data attributes that we will insert into record.
        //
        $attributes = $request->only( 'text' , 'title' , 'url' );

        // Create a new post record.
        //
        $post = $this->postRepository->createRecord( $attributes );

        // Redirect the user to their newly created post.
        //
        return redirect()->route( 'posts.show' , $post->id );
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
        // Fetch the post record from the database.
        //
        $post = $this->postRepository->findByIdWithUserAndComments( $id );

        // Show the page.
        //
        return routeView()->withPost( $post )->withUserAlreadyVoted( $post->votedByLoggedInUser() );
    }

    /**
     * Show all of the posts submitted by the in session user.
     *
     * @return Response
     */
    public function submitted()
    {
        // Fetch the post from the database.
        //
        $posts = $this->postRepository->getPaginatedWithUserAndCommentsByUserId( Auth::id() );

        // Show the page.
        //
        return routeView()->withPosts($posts);
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
        // Fetch the post from the database.
        //
        $post = $this->postRepository->findById( $id );

        // Show the page.
        //
        return routeView()->withPost( $post );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int                 $id
     * @param EditPostFormRequest $request
     *
     * @return Response
     */
    public function update( $id , EditPostFormRequest $request )
    {
        //
    }

    /**
     * Cast a vote towards a given post.
     *
     * @param int             $id
     * @param VoteFormRequest $request
     * @param VoteRepositoryInterface $voteRepository
     *
     * @return string
     */
    public function vote( $id , VoteFormRequest $request , VoteRepositoryInterface $voteRepository )
    {
        // Fetch the post record by the database.
        //
        $post = $this->postRepository->findById( $id );

        // Check if the user has already voted for this post.
        //
        $userAlreadyVoted = $voteRepository->checkIfUserAlreadyVotedForRecord( Auth::user(), $post );

        // Apply the vote to the post only if the user hasn't already voted.
        //
        if( ! $userAlreadyVoted ) $voteRepository->applyVoteToRecord( $post );

        // Return json response.
        //
        return ['success' => 'Your vote has been casted.'];
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

}
