<?php namespace App\Http\Controllers\Posts;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditPostFormRequest;
use App\Http\Requests\PostFormRequest;
use App\Posts\PostRepositoryInterface;

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
        //
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
        $posts = $this->postRepository->getNewestWithComments();

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
        $post = $this->postRepository->findById( $id );

        // Show the page.
        //
        return routeView()->withPost( $post );
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
