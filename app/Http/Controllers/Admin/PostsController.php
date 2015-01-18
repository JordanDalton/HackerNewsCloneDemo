<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminEditPostFormRequest;
use App\Posts\PostRepositoryInterface;
use Input;

class PostsController extends Controller {

    /**
     * The post repository implementation.
     *
     * @var \PostRepositoryInterface
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Capture any provided search criteria.
        //
        $criteria = Input::get('post', false);

        // Fetch a paginated listing of all posts in the system.
        //
        $posts = $criteria
               ? $this->postRepository->getPaginatedResourceListingByCriteria( $criteria )
               : $this->postRepository->getPaginatedResourceListing();

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
        return redirect('admin.posts.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        return redirect('admin.posts.index');
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
        $post = $this->postRepository->findById( $id );

        // Redirect the post to the post's profile page.
        //
        return redirect()->to($post->present()->getProfileLink());
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
        // Fetch the post account from the database.
        //
        $post = $this->postRepository->simplyFindById( $id );

        // Show the page.
        //
        return routeView()->withPost( $post );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int                     $id
     * @param AdminEditPostFormRequest $request
     *
     * @return Response
     */
    public function update( $id , AdminEditPostFormRequest $request )
    {
        // Fetch the post account from the database.
        //
        $post = $this->postRepository->simplyFindById( $id );

        // Update the record.
        //
        $this->postRepository->updateRecord( $post, $request->except('_token') );

        // Restore the record if requested.
        //
        if ( $request->has('restore') )
        {
            // Restore the post record.
            //
            $this->postRepository->restoreRecord( $post );
        }

        // Delete the record if requested.
        //
        if ( $request->has('delete') )
        {
            // Restore the post record.
            //
            $this->postRepository->softDeleteRecord( $post );
        }

        // Send the post back to the page and flash a message to them that
        // states the post record was successfully updated.
        //
        return redirect()->back()->withPostUpdatedSuccessfully(true);
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
