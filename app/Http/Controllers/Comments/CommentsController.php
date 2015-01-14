<?php namespace App\Http\Controllers\Comments;

use App\Comments\CommentRepositoryInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentFormRequest;

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
        return routeView()->withComment( $comment );
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
}
