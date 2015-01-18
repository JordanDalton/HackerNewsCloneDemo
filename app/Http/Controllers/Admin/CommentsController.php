<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminEditCommentFormRequest;
use App\Comments\CommentRepositoryInterface;
use Input;

class CommentsController extends Controller {

    /**
     * The comment repository implementation.
     *
     * @var \CommentRepositoryInterface
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
        // Capture any provided search criteria.
        //
        $criteria = Input::get('comment', false);

        // Fetch a paginated listing of all comments in the system.
        //
        $comments = $criteria
               ? $this->commentRepository->getPaginatedResourceListingByCriteria( $criteria )
               : $this->commentRepository->getPaginatedResourceListing();

        // Show the page.
        //
        return routeView()->withComments( $comments );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Show the page.
        //
        return routeView();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
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
        $comment = $this->commentRepository->findById( $id );

        // Redirect the comment to the comment's profile page.
        //
        return redirect()->to($comment->present()->getProfileLink());
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
        // Fetch the comment account from the database.
        //
        $comment = $this->commentRepository->simplyFindById( $id );

        // Show the page.
        //
        return routeView()->withComment( $comment );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int                     $id
     * @param AdminEditCommentFormRequest $request
     *
     * @return Response
     */
    public function update( $id , AdminEditCommentFormRequest $request )
    {
        // Fetch the comment account from the database.
        //
        $comment = $this->commentRepository->simplyFindById( $id );

        // Update the record.
        //
        $this->commentRepository->updateRecord( $comment, $request->except('_token') );

        // Restore the record if requested.
        //
        if ( $request->has('restore') )
        {
            // Restore the comment record.
            //
            $this->commentRepository->restoreRecord( $comment );
        }

        // Delete the record if requested.
        //
        if ( $request->has('delete') )
        {
            // Restore the comment record.
            //
            $this->commentRepository->softDeleteRecord( $comment );
        }

        // Send the comment back to the page and flash a message to them that
        // states the comment record was successfully updated.
        //
        return redirect()->back()->withCommentUpdatedSuccessfully(true);
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
